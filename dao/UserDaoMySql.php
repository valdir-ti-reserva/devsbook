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
  
  public function findByEmail($email){
    if(!empty($email)){
      $sql = $this->pdo->prepare("SELECT * FROM ".$this->name." WHERE email = :email");
      $sql->bindValue(':email', $email);
      $sql->execute();

      if($sql->rowCount() > 0){
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $user = $this->generateUser($data);
        return $user;
      }
    }

    return false;
  }

  public function update(User $u){
    
    $sql = $this->pdo->prepare("UPDATE ".$this->name." SET 
      email = :email,
      password = :password,
      name = :name,
      bithdate = :bithdate,
      city = :city,
      work = :work,
      avatar = :avatar,
      cover = :cover,
      token = :token
      WHERE id = :id");

    $sql->bindValue(':id', $id);
    $sql->bindValue(':name', $name);
    $sql->bindValue(':city', $city);
    $sql->bindValue(':work', $work);
    $sql->bindValue(':cover', $cover);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':token', $token);
    $sql->bindValue(':avatar', $avatar);
    $sql->bindValue(':password', $password);
    $sql->bindValue(':birthdate', $birthdate);

    $sql->execute();

    return true;
  }

  public function insert(User $u){
    $sql = $this->pdo->prepare("INSERT INTO ".$this->name." (
      email, name, password, birthdate, token
    ) VALUES (
      :email, :name, :password, :birthdate, :token
    )");
    
    $sql->bindValue(':name', $u->name);
    $sql->bindValue(':token', $u->token);
    $sql->bindValue(':email', $u->email);
    $sql->bindValue(':password', $u->password);
    $sql->bindValue(':birthdate', $u->birthdate);

    $sql->execute();

    return true;
  }
}