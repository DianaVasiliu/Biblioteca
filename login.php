<?php

session_start();


// DE TEST - sa nu raman autentificat fara buton de logout
//$_SESSION["loggedin"] = false;
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: paginaprincipala.php");
    exit;
}

require_once "./requirements/dbconnect.php";

$link = connectdb();

$username = $password = "";
$username_err = $password_err = $active_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Te rugam introdu username sau email.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Te rugam introdu parola";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT id_client, username, parola, email, activ FROM client WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                
                if(mysqli_stmt_num_rows($stmt) == 1){   
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password,$email, $activ);

                    if(mysqli_stmt_fetch($stmt)){
                        if ($activ == 0) {
                            $active_err = "Cont inactiv! Te rugam activeaza-ti contul!";
                        }

                        elseif(password_verify($password, $hashed_password)){
                            
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            
                            
                            header("location: paginaprincipala.php");
                            
                            //$_SESSION["loggedin"] = false;
                        } else{
                            
                            $password_err = "Date de conectare invalide.";
                            $username_err = "Date de conectare invalide.";
                        }
                    }
                } else{

                    $username_err = "Date de conectare invalide.";
                    $password_err = "Date de conectare invalide.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Autentificare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}
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
            
        </form>
    </div>    
</body>
</html>