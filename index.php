<?php
  require 'config.php';
  require 'models/Auth.php';

  //Verifica se o usuário está logado
  $auth       = new Auth($pdo, $base);
  $userInfo   = $auth->checkToken();
  $activeMenu = 'home';

  require 'partials/header.php';
  require 'partials/menu.php';
?>

<section class="feed mt-10">

...

</section>

<?php
  require 'partials/footer.php';
?>
