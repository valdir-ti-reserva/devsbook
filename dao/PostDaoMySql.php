<?php

require_once 'models/Post.php';
require_once 'dao/UserRelationDaoMySql.php';
require_once 'dao/UserDaoMySql.php';

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

  public function getHomeFeed($id_user){
    $array = [];
    //1- Buscar os usuários que eu sigo
    $urDao = new UserRelationDaoMySql($this->pdo);
    $userList = $urDao->getRelationsFrom($id_user);

    //2- Buscar od posts por ordem cronológica
    $sql = $this->pdo->query("SELECT * FROM ".$this->name." 
                                WHERE id_user IN (".implode(',', $userList).") 
                                ORDER BY created_at DESC");
    if($sql->rowCount() > 0){
      $data = $sql->fetchAll(PDO::FETCH_ASSOC);

      //3- Transformar os resultados em objetos
      $array = $this->_postListToObject($data, $id_user);
    }

    return $array;
  }

  private function _postListToObject($post_list, $id_user){
    $posts = [];
    $userDao = new UserDaoMySql($this->pdo);
    
    foreach($post_list as $post_item){
      $newPost = new Post();
      $newPost->id         = $post_item['id'];
      $newPost->type       = $post_item['type'];
      $newPost->body       = $post_item['body'];
      $newPost->created_at = $post_item['created_at'];
      $newPost->mine       = false;
      
      if($post_item['id_user'] == $id_user){
        $newPost->mine       = true;
      }

      //Buscar informações do usuário
      $newPost->user = $userDao->findById($post_item['id_user']);

      //Buscar informações de likes
      $newPost->likeCount = 0;
      $newPost->liked = false;
      
      //Buscar informações de comments
      $newPost->comments = [];

      $posts[] = $newPost;
    }
    
    return $posts;
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