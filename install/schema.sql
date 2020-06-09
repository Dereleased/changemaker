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
INSERT INTO currency_format (name_singular, name_plural, is_physical) VALUES
    ('bill', 'bills', 1),
    ('coin', 'coins', 1),
    ('gem', 'gems', 0)
;
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
