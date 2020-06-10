<?php

declare(strict_types=1);

namespace Changemaker\Helper;

use Changemaker\Currency\{ Currency, CurrencyInterface };
use Changemaker\Currency\Denomination\Format\FormatFactory;
use Changemaker\Currency\Denomination\Denomination;
use Changemaker\Currency\Unit\{ Unit as CurrencyUnit, UnitInterface as CurrencyUnitInterface };
use Changemaker\Exception\InvalidCurrencyDefinitionException;
use Changemaker\SQLStatement\{
    SelectCurrency,
    SelectCurrencyDenominationFormats,
    SelectCurrencyUnitDenominations,
    SelectCurrencyUnits,
    Executor\PDO as PDOExecutor
};

class CurrencyBuilder
{
    /** @var \PDO */
    protected $pdo;

    /** @var PDOExecutor */
    protected $pdoExecutor;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdoExecutor = new PDOExecutor($pdo);
    }

    public function getCurrencyByCode(string $code): CurrencyInterface
    {
        return $this->getCurrency(new SelectCurrency($code, SelectCurrency::CRITERION_CODE));
    }

    public function getCurrencyById(int $id): CurrencyInterface
    {
        return $this->getCurrency(new SelectCurrency($id, SelectCurrency::CRITERION_ID));
    }

    protected function getCurrency(SelectCurrency $select): CurrencyInterface
    {
        $denom_formats = $this->pdoExecutor->select(new SelectCurrencyDenominationFormats());

        foreach ($denom_formats as $df) {
            FormatFactory::create((int)$df['id'], $df['name_singular'], $df['name_plural'], (bool)$df['is_physical']);
        }

        $currency_data = $this->pdoExecutor->select($select);

        if (!count($currency_data)) {
            throw new \Exception("Unable to find requested currency: " . $select->getParams()[0]);
        }

        $currency_data = $currency_data[0];

        $currency = new Currency($currency_data['symbol'], $currency_data['code'], $currency_data['name'], (int)$currency_data['id']);

        $this->attachCurrencyUnitData($currency);

        return $currency;
    }

    protected function attachCurrencyUnitData(CurrencyInterface $currency): void
    {
        $unit_data = $this->pdoExecutor->select(new SelectCurrencyUnits($currency->getId()));

        $units = $parents = [];
        foreach ($unit_data as $ud) {
            $units[$ud['id']] = $ud;
        }

        $target_parent_id = null;
        $last_unit        = $currency;
        while (count($units)) {
            foreach ($units as $key => $ud) {
                if ($ud['parent_unit_id'] === $target_parent_id) {
                    if ($last_unit instanceof Currency) {
                        $unit = new CurrencyUnit($currency, $ud['name_singular'], $ud['name_plural'], null, null, $ud['separator_symbol_mask'], (int)$ud['id']);
                        $last_unit->setUnit($unit);
                    } else {
                        $unit = new CurrencyUnit($currency, $ud['name_singular'], $ud['name_plural'], $last_unit, (int)$ud['parent_unit_ratio'], $ud['separator_symbol_mask'], (int)$ud['id']);
                        $last_unit->setChildUnit($unit);
                    }
                    
                    $target_parent_id = $ud['id'];
                    $last_unit        = $unit;
                    unset($units[$target_parent_id]);

                    $this->attachCurrencyUnitDenominationData($unit);

                    continue 2;
                }
            }

            throw new InvalidCurrencyDefinitionException(InvalidCurrencyDefinitionException::ERROR_BAD_PARENT_RELATIONSHIP);
        }
    }

    protected function attachCurrencyUnitDenominationData(CurrencyUnitInterface $currencyUnit): void
    {
        $denom_data = $this->pdoExecutor->select(new SelectCurrencyUnitDenominations($currencyUnit->getId()));
        foreach ($denom_data as $denom) {
            $currencyUnit->addDenomination(new Denomination(
                (int)$denom['value'],
                $currencyUnit,
                FormatFactory::getById((int)$denom['currency_format_id']),
                $denom['name_singular'],
                $denom['name_plural'],
                (int)$denom['id']
            ));
        }
    }
}