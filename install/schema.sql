CREATE DATABASE changemaker;

CREATE TABLE currency (
    id int(11) unsigned not null primary key auto_increment,
    code char(3) not null,
    symbol varchar(8) null default null,
    name varchar(128) not null,
    
    unique key code(code)
) ENGINE=InnoDB;

CREATE TABLE currency_unit (
    id int(11) unsigned not null primary key auto_increment,
    currency_id int(11) unsigned not null,

    parent_unit_id int(11) unsigned null default null,
    parent_unit_ratio int(11) unsigned null default null,
    
    name_singular varchar(128) not null,
    name_plural varchar(128) not null,
    
    separator_symbol_mask varchar(128) null default null,
    
    index currency_id (currency_id),
    index parent_unit_id (parent_unit_id)
) ENGINE=InnoDB;

CREATE TABLE currency_format (
    id int(11) unsigned not null primary key auto_increment,
    
    name_singular varchar(128) not null,
    name_plural varchar(128) not null,
    
    is_physical tinyint(1) not null
) ENGINE=InnoDB;

CREATE TABLE currency_unit_denom (
    id int(11) unsigned not null primary key auto_increment,
    currency_unit_id int(11) unsigned not null,
    
    value int(11) unsigned not null,
    
    currency_format_id int(11) not null,
    
    name_singular varchar(128) null default null,
    name_plural varchar(128) null default null,

    index currency_unit_id (currency_unit_id),
    unique key prev_dupe (currency_unit_id, value, currency_format_id)
) ENGINE=InnoDB;

INSERT INTO currency_format (id, name_singular, name_plural, is_physical) VALUES
    (1, 'bill', 'bills', 1),
    (2, 'coin', 'coins', 1),
    (3, 'gem', 'gems', 0)
;

INSERT INTO `currency` (`code`, `symbol`, `name`) VALUES ('USD', '$', 'United States Dollar');
INSERT INTO `currency` (`code`, `symbol`, `name`) VALUES ('MAL', '#', 'Maltese Scudo');

INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (1, NULL, NULL, 'Dollar', 'Dollars', NULL);
INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (1, 1, 100, 'Cent', 'Cents', '.');
INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (2, NULL, NULL, 'Scudo', 'Scudi', NULL);
INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (2, 3, 12, 'tari', 'tari', 't');
INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (2, 4, 20, 'grano', 'grani', 'g');
INSERT INTO `currency_unit` (`currency_id`, `parent_unit_id`, `parent_unit_ratio`, `name_singular`, `name_plural`, `separator_symbol_mask`) VALUES (2, 5, 6, 'piccolo', 'piccoli', 'p');

INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 100, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 50, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 20, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 10, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 5, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (2, 25, 2, 'quarter', 'quarters');
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (2, 10, 2, 'dime', 'dimes');
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (2, 5, 2, 'nickel', 'nickels');
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (2, 1, 2, 'penny', 'pennies');
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 1000, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 500, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 100, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 50, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 20, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 10, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 5, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (3, 1, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (4, 6, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (4, 1, 1, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (5, 10, 2, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (5, 5, 2, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (5, 1, 2, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (6, 3, 2, NULL, NULL);
INSERT INTO `currency_unit_denom` (`currency_unit_id`, `value`, `currency_format_id`, `name_singular`, `name_plural`) VALUES (6, 1, 2, NULL, NULL);
