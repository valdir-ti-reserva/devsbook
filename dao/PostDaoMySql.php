<?php

require_once 'models/Post.php';

class PostDaoMySql implements PostDAO {
  private $pdo;
  private $name = 'posts';

  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  //Gerando o usuário padrão
  private function generatePost($array){
    $p = new Post();

    $u->id         = $array['id'] ?? 0;
    $u->id_user    = $array['id_user'] ?? '';
    $u->type       = $array['type'] ?? '';
    $u->body       = $array['body'] ?? '';
    $u->created_at = $array['created_at'] ?? '';    
   
    return $u;
  }

  public function insert(Post $p){
    $sql = $this->pdo->prepare("INSERT INTO ".$this->name." (
      id_user, type, created_at, body
    ) VALUES (
      :id_user, :type, :created_at, :body
    )");
    
    $sql->bindValue(':id_user', $p->id_user);
    $sql->bindValue(':type', $p->type);
    $sql->bindValue(':created_at', $p->created_at);
    $sql->bindValue(':body', $p->body);
    $sql->execute();

    return true;
  }

  // public function update(User $u){
    
  //   $sql = $this->pdo->prepare("UPDATE ".$this->name." SET 
  //     email = :email,
  //     password = :password,
  //     name = :name,
  //     birthdate = :birthdate,
  //     city = :city,
  //     work = :work,
  //     avatar = :avatar,
  //     cover = :cover,
  //     token = :token
  //     WHERE id = :id");
      
  //     $sql->bindValue(':id', $u->id);
  //     $sql->bindValue(':name', $u->name);
  //     $sql->bindValue(':city', $u->city);
  //     $sql->bindValue(':work', $u->work);
  //     $sql->bindValue(':cover', $u->cover);
  //     $sql->bindValue(':token', $u->token);
  //     $sql->bindValue(':email', $u->email);
  //     $sql->bindValue(':avatar', $u->avatar);
  //     $sql->bindValue(':password', $u->password);
  //     $sql->bindValue(':birthdate', $u->birthdate);

  //   $sql->execute();

  //   return true;
  // }

  
}