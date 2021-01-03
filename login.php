<?php

require_once "./requirements/dbconnect.php";

$link = connectdb();
mysqli_set_charset($link , "utf8");

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: paginaprincipala.php");
    exit;
}

$username = $password = "";
$tip = 0;
$username_err = $password_err = $active_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(mysqli_real_escape_string($link, mysqli_real_escape_string($link, trim($_POST["username"]))))) {
        $username_err = "Te rugam introdu username sau email.";
    } 
    else {
        $username = mysqli_real_escape_string($link, trim($_POST["username"]));
    }
    
    if(empty(mysqli_real_escape_string($link, trim($_POST["password"])))) {
        $password_err = "Te rugam introdu parola";
    } 
    else {
        $password = mysqli_real_escape_string($link, trim($_POST["password"]));
    }
    
    
    if(empty($username_err) && empty($password_err)){
        
        $query = "SELECT id_client, username, parola, email, activ, nume, prenume, adresa, tip 
                  FROM client 
                  WHERE BINARY username = ?";
        
        if($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1) {   
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password,$email, $activ, $nume, $prenume, $adresa, $tip);

                    if(mysqli_stmt_fetch($stmt)) {
                        if ($activ == 0) {
                            $active_err = "Cont inactiv! Te rugam activeaza-ti contul!";
                        }
                        elseif(password_verify($password, $hashed_password)) {
                           
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["lastname"] = $nume;
                            $_SESSION["firstname"] = $prenume;
                            $_SESSION["address"] = $adresa;
                            $_SESSION["tip"] = $tip;

                            if ($tip == 1) {
                                $_SESSION['redirecting'] = 1;
                                header("location: contulmeu.php");
                            }
                            
                            if ($tip == 2) {
                                $_SESSION["insert_notif_bibl_flag"] = 1;
                                $_SESSION['send_notif_retur_flag'] = 1;  
                                $_SESSION['send_notif_taxa_flag'] = 1;
                            }
                        
                            if ($tip == 2 || $tip == 3) {
                                header("location: contulmeu.php");    
                            }
                        }
                        else {
                            $password_err = "Date de conectare invalide.";
                            $username_err = "Date de conectare invalide.";
                        }
                    }
                } 
                else {
                    $username_err = "Date de conectare invalide.";
                    $password_err = "Date de conectare invalide.";
                }
            } 
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <title>Autentificare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body { 
            font: 14px sans-serif; 
        }
        .wrapper { 
            width: 350px; 
            padding: 20px; 
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Autentificare</h2>
        <p>Te rugam completeaza datele pentru logare.</p>
        <span class="help-block"><?php echo $active_err; ?></span>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Parola</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Nu ai un cont? <a href="register.php">Inregistreaza-te</a>.</p>
            <p><a href="./requirements/password_recovery/enter_email.php">Ai uitat parola?</a></p>
            
        </form>
    </div>    
</body>
</html>