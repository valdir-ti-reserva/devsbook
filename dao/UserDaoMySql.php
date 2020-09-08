<?php
require_once 'models/User.php';

class UserDaoMySql implements UserDAO {
  private $pdo;
  private $name = 'users';

  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  //Gerando o usuário padrão
  private function generateUser($array){
    $u = new User();

    $u->id        = $array['id'] ?? 0;
    $u->email     = $array['email'] ?? '';
    $u->name      = $array['name'] ?? '';
    $u->city      = $array['city'] ?? '';
    $u->work      = $array['work'] ?? '';
    $u->cover     = $array['cover'] ?? '';
    $u->token     = $array['token'] ?? '';
    $u->avatar    = $array['avatar'] ?? '';
    $u->birthdate = $array['birthdate'] ?? '';

    return $u;
  }

  public function findByToken($token){
    if(!empty($token)){
      $sql = $this->pdo->prepare("SELECT * FROM ".$this->name." WHERE token = :token");
      $sql->bindValue(':token', $token);
      $sql->execute();

      if($sql->rowCount() > 0){
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $user = $this->generateUser($data);
        return $user;
      }
    }

    return false;
  }
}