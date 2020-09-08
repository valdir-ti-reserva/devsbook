<?php
require 'config.php';
require 'models/Auth.php';

//Verifica se o usuário está logado
$auth     = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

echo 'Index';
