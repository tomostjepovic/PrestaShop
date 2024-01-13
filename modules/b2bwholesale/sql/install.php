<?php

$sql = array();
$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'activity_type` (
    `id_activity_type` INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY  (`id_activity_type`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'activity_type_lang` (
    `id_activity_type` INT NOT NULL AUTO_INCREMENT,
    `id_lang` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_activity_type`, `id_lang`),
    FOREIGN KEY (`id_lang`) REFERENCES ' . _DB_PREFIX_ . 'lang(id_lang),
    FOREIGN KEY (`id_activity_type`) REFERENCES ' . _DB_PREFIX_ . 'activity_type(id_activity_type)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'activity_type_shop` (
    `id_activity_type` INT NOT NULL,
    `id_shop` INT NOT NULL,
    PRIMARY KEY (`id_activity_type`, `id_shop`),
    FOREIGN KEY (`id_shop`) REFERENCES ' . _DB_PREFIX_ . 'shop(id_shop),
    FOREIGN KEY (`id_activity_type`) REFERENCES ' . _DB_PREFIX_ . 'activity_type(id_activity_type)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
