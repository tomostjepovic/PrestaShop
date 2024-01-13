<?php

$tables = array(
    'activity_type_shop',
    'activity_type_lang',
    'activity_type',
);
if($tables)
{
    foreach($tables as $table)
        Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . pSQL($table).'`');
}
