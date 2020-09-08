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

    header("Location: ".$this->base."/login.php");
    exit;
  }

  public function validateLogin($email, $password){
    
    $userDao = new UserDaoMySql($this->pdo);
    $user    = $userDao->findByEmail($email);
    if($user){
      
      if(password_verify($password, $user->password)){
       
        $token = md5(time().rand(0, 9999));

        $_SESSION['token'] = $token;
        $user->token       = $token;
        $userDao->update($user);
        
        return true;
      }

    }

    return false;
  }

  public function emailExists($email){
    
    $userDao = new UserDaoMySql($this->pdo);
    return $userDao->findByEmail($email) ? true : false;

  }

  public function registerUser($name, $email, $password, $birthdate){
    $userDao = new UserDaoMySql($this->pdo);
    
    $hash  = password_hash($password, PASSWORD_DEFAULT);
    $token = md5(time().rand(0, 9999));

    $newUser            = new User();
    $newUser->name      = $name;
    $newUser->email     = $email;
    $newUser->password  = $hash;
    $newUser->birthdate = $birthdate;
    $newUser->token     = $token;

    $userDao->insert($newUser);

    $_SESSION['token'] = $token;
  }

}