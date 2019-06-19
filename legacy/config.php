<?php 
extract(array (
  'dbms' => 'pdo',
  'dbhost' => 'przemo-mysql',
  'dbname' => 'przemo',
  'dbuser' => 'root',
  'dbpasswd' => 'root',
  'table_prefix' => 'przemo_',
  'pdo' => 
  array (
    'dsn' => 'mysql:host=przemo-mysql;dbname=przemo;charset=utf8',
    'user' => 'root',
    'pass' => 'root',
  ),
));
define('PHPBB_INSTALLED', true);
