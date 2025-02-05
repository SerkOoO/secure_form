<?php
require_once('includes/form_secure.php');

if(isset($_SESSION["authenticated"])){
  header("Location: dashboard.php");

}

awaitRegisterForm($con);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/components/head.php'); ?>
<body>
<?php include('includes/components/navbar.php'); ?>

<?php 

  if(isset($_SESSION['status-fail'])){
      echo "<div class='alert alert-danger'>";
      echo "<p style='margin-bottom : 0' class='verif_p'>".$_SESSION["status-fail"]. "</p>";
      echo "</div>";
      unset($_SESSION["status-fail"]); 
  }
?>

<?php 

  if(isset($_SESSION['status-success'])){
      echo "<div class='alert alert-success'>";
      echo "<p style='margin-bottom : 0' class='verif_p'>".$_SESSION["status-success"]. "</p>";
      echo "</div>";
      unset($_SESSION["status-success"]); 
  }
?>

<form method="post" action="" class="form-login">


<div>
      <label for="nomInput" class="form-label mt-4">Votre nom</label>
      <input name="nom" type="text" class="form-control" id="nomInput" placeholder="John">

    </div>
    <div>
      <label for="prenomInput" class="form-label mt-4">Votre prénom</label>
      <input name="prenom" type="text" class="form-control" id="prenomInput" placeholder="Doe">
    </div>
    <div>
      <label for="emailInput" class="form-label mt-4">Votre adresse email</label>
      <input name="email" type="email" class="form-control" id="emailInput" placeholder="john.doe@mail.com">
      <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre e-mail avec quelqu'un d'autre.</small>
    </div>
    <div>
      <label for="mdpInput" class="form-label mt-4">Votre Mot de passe</label>
      <input name="mdp" type="password" class="form-control" id="mdpInput" placeholder="" minlength="13" autocomplete="off">
      <small id="emailHelp" class="form-text text-muted">Votre mot de passe doit contenir 13 caractères, avec au moins 1 caractère spécial et 1 majuscule</small>
      
    </div>

    <div>
      <label for="mdpInput" class="form-label mt-4">Re entrez votre Mot de passe</label>
      <input name="remdp" type="password" class="form-control" id="mdpInput" placeholder="" minlength="13" autocomplete="off">
    </div>

    <input type="submit" class="btn btn-primary mt-4 mb-4" value="S'inscire"></input>

    </form>

    <?php include('includes/components/footer.php'); ?>
</body>
</html>