<?php

declare(strict_types=1);

namespace Changemaker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputArgument,
    InputOption,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;
use Changemaker\Helper\{ ConfigReader, CurrencyBuilder };
use Changemaker\Calculator;
use Changemaker\Change\ChangeUnitInterface;
use Changemaker\Exception\{ BalanceNotSatisfiedException, UnitExceedsAlowedRangeException };

class CalculateCommand extends Command
{
    protected static $defaultName = 'calculate';

    protected static $defaultCurrency = 'USD';

    protected function configure()
    {
        $this
            ->setDescription('Performs a change-making calculation')
            ->setHelp("USAGE: calculate [--currency XYZ] due paid")
        ;

        $this
            ->addArgument('due', InputArgument::REQUIRED, "The amount due")
            ->addArgument('paid', InputArgument::REQUIRED, "The amount that was paid")
            ->addOption('currency', null, InputOption::VALUE_REQUIRED, "The currency code to use")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbconf = ConfigReader::readConfig('config', 'db');
        $pdo    = new \PDO("mysql:dbname={$dbconf['db']};host={$dbconf['host']}", $dbconf['user'], $dbconf['pass']);
        $cb     = new CurrencyBuilder($pdo);

        try {
            $ctl      = $input->getOption('currency') ?: self::$defaultCurrency;
            $currency = $cb->getCurrencyByCode($ctl);
        } catch (\Exception $e) {
            $output->writeln("Could not load the specifid currency: $ctl");
            return Command::FAILURE;
        }

        $calc = new Calculator($currency);

        $due  = $input->getArgument('due');
        $paid = $input->getArgument('paid');

        try {
            $change = $calc->makeChange($due, $paid);

            $output->writeln("Please return the following change:");
            $output->writeln("");

            /** @var ChangeUnitInterface $changeItem */
            foreach ($change as $changeItem) {
                $output->writeln((string)$changeItem);
            }

            return Command::SUCCESS;
        } catch (UnitExceedsAllowedRangeException $range) {
            $output->writeln($range->getMessage());
            return Command::FAILURE;
        } catch (BalanceNotSatisfiedException $bal) {
            $output->writeln($bal->getMessage());
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("GENERAL ERROR: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::FAILURE; // but how did we get here?!
    }
}