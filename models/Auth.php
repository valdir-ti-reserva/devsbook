<?php

require_once 'dao/UserDaoMySql.php';

class Auth {

  private $pdo;
  private $base;

  public function __construct(PDO $pdo, $base){ 
    $this->pdo = $pdo;
    $this->base = $base;
  }  

  //Checando o Token do usuário
  public function checkToken(){
    if(!empty($_SESSION['token'])){
      $token = $_SESSION['token'];

      $userDao = new UserDaoMySql($this->pdo);
      $user    = $userDao->findByToken($token);

      if($user){
        return $user;
      }
    }

    header("Location: ".$this->base."login.php");
    exit;
  }

}