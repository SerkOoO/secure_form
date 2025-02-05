<?php 
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Secure Form</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Accueil</a>
        </li>
        <?php if(!isset($_SESSION["authenticated"])) : ?>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>" href="register.php">Inscription</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'en-savoir-plus.php') ? 'active' : ''; ?>" href="en-savoir-plus.php">En savoir +</a>
        </li>
      </ul>
      <?php if(isset($_SESSION["authenticated"])) : ?>
      <div class="d-flex">
        <a href="./auth/logout.php" class="btn btn-secondary my-2 my-sm-0">Déconnexion</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
