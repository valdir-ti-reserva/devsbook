<?php

session_start();

$timeout = 600; // Tempo da sessao em segundos
 
// Verifica se existe o parametro timeout
if(isset($_SESSION['timeout'])) {
    // Calcula o tempo que ja se passou desde a cricao da sessao
    $duracao = time() - (int) $_SESSION['timeout'];
  
  	// Verifica se ja expirou o tempo da sessao
    if($duracao > $timeout) {
        // Destroi a sessao e cria uma nova
        session_destroy();
        session_start();
    }
}
 
// Atualiza o timeout.
$_SESSION['timeout'] = time();

date_default_timezone_set('America/Sao_Paulo');

$base = 'http://localhost:81/devsbook';

$db_name = 'devsbook';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);

