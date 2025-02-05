<?php

function sanitize($value)
{
    $value = trim($value);
    $value = stripslashes($value);

    $value = escapeshellcmd($value);
    $value = htmlspecialchars($value);
    return $value;
}

function sanitize_password($value)
{
    $value = trim($value);
    $value = escapeshellcmd($value);
    $value = htmlspecialchars($value);
    return $value;
}

function parseConfig($folderName,$relativePath){
    try{
        return parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/" . $folderName . "/" . $relativePath);
    }
    catch (Exception $e) {  
        return "". $e->getMessage();
    }
}

function start_session()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

function throwUnknownError(){
    die("Unknown error, please contact server administrator");
}


function connectDB(){
    $config = parseConfig("form_secure","config/config.ini");

    $host = $config['database_host'];
    $dbname = $config['database_name'];
    $username = $config['database_username'];
    $password = $config['database_password'];

    try {

        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {

        echo "Erreur lors de la connexion à la base de données: " . $e->getMessage();
        return null;
    }
}


function isValidPassword($password) {

    $hasUppercase = preg_match('/[A-Z]/', $password);
    
    $hasDigit = preg_match('/\d/', $password);
    
    $hasSpecialChar = preg_match('/[\W_]/', $password);
    
    return $hasUppercase && $hasDigit && $hasSpecialChar;
}




function register($nom, $prenom, $email, $mdp) {
    $db = connectDB();
    if ($db !== null) {
        try {
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO credentials (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdp', $mdp);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion dans la base de données: " . $e->getMessage();
            return false;
        }
    } else {
        return false;
    }
}

function awaitRegisterForm($con) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = sanitize($_POST['nom']);
        $prenom = sanitize($_POST['prenom']);
        $email = sanitize($_POST['email']);
        $mdp = sanitize_password($_POST['mdp']);
        $remdp = sanitize_password($_POST['remdp']);

        if ($remdp != $mdp) {
            $_SESSION['status-fail'] = "Les mots de passe ne correspondent pas";
            header("Location: index.php");
            exit;
        }

        if (!isValidPassword($mdp)) {
            $_SESSION['status-fail'] = "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.";
            header("Location: register.php");
            exit;
        }

        try {
            $email_check = "SELECT * FROM credentials WHERE email = :email";
            $result = $con->prepare($email_check);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->execute();

            if ($result->rowCount() > 0) {
                $_SESSION['status-fail'] = "Adresse email déjà utilisée";
                header("Location: register.php");
                exit;
            }

            $result = register($nom, $prenom, $email, $mdp);

            if ($result === true) {
                $_SESSION['status-success'] = "Votre compte a bien été créé, connectez-vous !";
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['status-fail'] = "Une erreur s'est produite lors de l'enregistrement.";
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['status-fail'] = "Une erreur s'est produite avec la base de données : " . $e->getMessage();
            header("Location: index.php");
            exit;
        }
    }
}


function awaitLogin($con){
    if(isset($_POST["submit_login"])) {
        if(!empty(sanitize($_POST["email"])) && !empty(sanitize_password($_POST["mdp"]))) {
            $email = sanitize($_POST['email']);
            $mdp = sanitize_password($_POST['mdp']);

            try {
                $stmt = $con->prepare("SELECT mdp FROM credentials WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $hashed_password = $row['mdp'];

                    if (password_verify($mdp, $hashed_password)) {
                        $stmt = $con->prepare("SELECT * FROM credentials WHERE email = :email");
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($user) {
                            $_SESSION['authenticated'] = true;
                            $_SESSION['auth_user'] = [
                                'username' => $user['name'],
                                'email' => $user['email'],
                                'id' => $user['id'],
                                'password' => $user['password'],
                            ];
                            return true;
                        } else {
                            $_SESSION['status-fail'] = 'Please create an account <a href="register.php">here</a>';
                            header('Location: index.php');
                            exit();
                        }
                    } else {
                        $_SESSION['status-fail'] = 'Invalid password';
                        header('Location: index.php');
                        exit();
                    }
                } else {
                    $_SESSION['status-fail'] = 'Email not found. Please create an account <a href="register.php">here</a>';
                    header('Location: index.php');
                    exit();
                }
            } catch (PDOException $e) {
                $_SESSION['status-fail'] = "Error: " . $e->getMessage();
                header('Location: index.php');
                exit();
            }
        } else {
            $_SESSION['status-fail'] = "Email and password are required";
            header('Location: index.php');
            exit();
        }
    }
}





function getUserById($id, $con){
    try {
        $stmt = $con->prepare("SELECT * FROM credentials WHERE id = :id");
        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête.");
        }

      
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);


        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("Erreur d'exécution de la requête.");
        }


        $result_set = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_set;

    } catch (Exception $e) {
        throw new Exception("Une erreur est survenue: " . $e->getMessage());
       
    }
}

?>