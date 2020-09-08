<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

$base = 'http://localhost:81/devsbook';

$db_name = 'devsbook';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);

