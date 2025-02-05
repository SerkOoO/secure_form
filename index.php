<?php

require_once('includes/form_secure.php');

if(isset($_SESSION["authenticated"])){
   header("Location: dashboard.php");

}


if (awaitLogin($con)) {
  header("Location: dashboard.php");
}
;
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/components/head.php'); ?>

<body>
  <?php include('includes/components/navbar.php'); ?>

  <div class="container">


    <?php
    if (isset($_SESSION['status-fail'])) {
      echo "<div class='alert alert-danger'>";
      echo "<p style='margin-bottom : 0' class='verif_p'>" . $_SESSION["status-fail"] . "</p>";
      echo "</div>";
      unset($_SESSION["status-fail"]);
    }
    ?>

    <?php
    if (isset($_SESSION['status-success'])) {
      echo "<div class='alert alert-success'>";
      echo "<p style='margin-bottom : 0' class='verif_p'>" . $_SESSION["status-success"] . "</p>";
      echo "</div>";
      unset($_SESSION["status-success"]);
    }
    ?>

    <form method="post" action="" class="form-login">

      <div>
        <label for="emailInput" class="form-label mt-4">Votre adresse email</label>
        <input name="email" type="email" class="form-control" id="emailInput" placeholder="john.doe@mail.com">
      </div>
      <div>
        <label for="mdpInput" class="form-label mt-4">Votre Mot de passe</label>
        <input name="mdp" type="password" class="form-control" id="mdpInput" placeholder="" autocomplete="off">

      </div>



      <input name="submit_login" type="submit" class="btn btn-primary mt-4 mb-4" value="Connexion"></input>

    </form>

  </div>



</body>

</html>