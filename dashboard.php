<?php
$loggedPage = true;
require_once('includes/form_secure.php');


?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/components/head.php'); ?>
<body>
<?php include('includes/components/navbar.php'); ?>


<h3 class="text-dark mt-4 mx-4">Hi, <?= $user["nom"] ?></h3>

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



</body>
</html>