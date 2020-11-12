<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "includes/dbconnect.php";
require 'C:/xampp/Composer/vendor/autoload.php';

function valid_email($str) {

    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

$link = connectdb();

$query = "SELECT judet FROM judete ORDER BY id_judet";

$options = "";
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_array($res)) {
    $options = $options.'<option value="'.$row[0].'">'.$row[0].'</option>';
}

$username = $password = $confirm_password = "";
$firstname = $lastname = "";
$phone = $email = "";
$street = "";
$streetno = "";
$city = "";
$county = "";

$username_err = $password_err = $confirm_password_err = "";
$firstname_err = $lastname_err = "";
$phone_err = $email_err = ""; 
$street_err = "";
$streetno_err = "";
$city_err = "";
$county_err = "";
$anyerror = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validare username
    if(empty(trim($_POST["username"]))){
        $username_err = "Te rugam introdu un username.";
        $anyerror = 1;
    } 
    else{
        // Pregatesc cererea sql
        $sql = "SELECT id_client FROM client WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Inlocuiesc valorile ? din cerere cu valorile parametrilor
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Setez parametrul dorit
            $param_username = trim($_POST["username"]);
            
            // Execut cererea
            if(mysqli_stmt_execute($stmt)){
                // Retin rezultatul cererii
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username deja folosit.";
                    $anyerror = 1;
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Inchid cererea
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validare parola
    if(empty(trim($_POST["password"]))) {
        $password_err = "Te rugam introdu o parola.";   
        $anyerror = 1;  
    } 
    elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Parola trebuie sa aiba cel putin 6 caractere.";
        $anyerror = 1;
    }
    else {
        $password = trim($_POST["password"]);
    }
    
    // Validare confirmare parola
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Te rugam confirma parola.";   
        $anyerror = 1;  
    }
    else {
        $confirm_password = trim($_POST["confirm_password"]);

        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Parolele nu coincid.";
            $anyerror = 1;
        }
    }

    // Validare prenume
    if(empty(trim($_POST["firstname"]))) {
        $firstname_err = "Te rugam introdu un prenume.";     
        $anyerror = 1;
    } 
    else {
        $firstname = ucfirst(trim($_POST["firstname"]));
    }

    // Validare nume
    if(empty(trim($_POST["lastname"]))) {
        $lastname_err = "Te rugam introdu un nume.";    
        $anyerror = 1; 
    } 
    else {
        $lastname = ucfirst(trim($_POST["lastname"]));
    }

    // Validare telefon
    if(empty(trim($_POST["phone"]))) {
        $phone_err = "Te rugam introdu un numar de telefon.";  
        $anyerror = 1;   
    } 
    elseif (strlen(trim($_POST["phone"])) != 10 || trim($_POST["phone"])[0] != "0") {
        $phone_err = "Te rugam introdu un numar de telefon valid.";
        $anyerror = 1;
    }
    else {
        // Pregatesc cererea sql
        $sql = "SELECT id_client FROM client WHERE telefon = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Inlocuiesc valorile ? din cerere cu valorile parametrilor
            mysqli_stmt_bind_param($stmt, "s", $param_phone);
            
            // Setez parametrul dorit
            $param_phone = trim($_POST["phone"]);
            
            // Execut cererea
            if(mysqli_stmt_execute($stmt)){
                // Retin rezultatul cererii
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $phone_err = "Telefon deja folosit.";
                    $anyerror = 1;
                } else{
                    $phone = trim($_POST["phone"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Inchid cererea
            mysqli_stmt_close($stmt);
        }
    }

    // Validare email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Te rugam introdu un email.";     
        $anyerror = 1;
    } 
    //elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
    elseif (!valid_email(trim($_POST["email"]))){
        $email_err = "Te rugam introdu un email valid.";
        $anyerror = 1;
    }
    else {
        $sql = "SELECT id_client FROM client WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Inlocuiesc valorile ? din cerere cu valorile parametrilor
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Setez parametrul dorit
            $param_email = trim($_POST["email"]);
            
            // Execut cererea
            if(mysqli_stmt_execute($stmt)){
                // Retin rezultatul cererii
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Email deja folosit.";
                    $anyerror = 1;
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Inchid cererea
            mysqli_stmt_close($stmt);
        }
    }

    // Validare strada
    if(empty(trim($_POST["street"]))) {
        $street_err = "Te rugam introdu o strada."; 
        $anyerror = 1;    
    }
    else {
        $street = trim($_POST["street"]);
    }

    // Validare nr. strada
    if(empty(trim($_POST["streetno"]))) {
        $streetno_err = "Te rugam introdu un numar.";     
        $anyerror = 1;
    }
    elseif (!ctype_alnum(trim($_POST["streetno"]))) {
        $streetno_err = "Te rugam introdu un numar valid.";  
        $anyerror = 1;
    }
    else {
        $streetno = trim($_POST["streetno"]);
    }

    // Validare oras
    if(empty(trim($_POST["city"]))) {
        $city_err = "Te rugam introdu un oras.";     
        $anyerror = 1;
    } 
    elseif (!ctype_alnum(trim($_POST["city"]))) {
        $city_err = "Te rugam introdu un oras valid.";
        $anyerror = 1;
    }
    else {
        $city = trim($_POST["city"]);
    }

     // Validare judet

    if($_POST["county"] == "" || !isset($_POST["county"])) {
        $county_err = "Te rugam selecteaza un judet.";     
        $anyerror = 1;
    } 
    elseif ($_POST["county"] != "NULL" && isset($_POST["county"])) {
        $county = trim($_POST["county"]);
    }
    
    // Verificarea erorilor de input inainte de introducerea in BD
    if($anyerror == 0){
        
        // Pregatesc cererea de inserare
        $sql = "INSERT INTO `client` (`nume`, `prenume`, `telefon`, `email`, `adresa`, `username`, `parola`) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssssss", $param_lastname, $param_firstname, $param_phone, $param_email, $param_address, $param_username, $param_password);
            
            $param_lastname = mysqli_real_escape_string($link, $lastname);
            $param_firstname = mysqli_real_escape_string($link, $firstname);
            $param_phone = mysqli_real_escape_string($link, $phone);
            $param_email = mysqli_real_escape_string($link, $email);
            $param_address = mysqli_real_escape_string($link, $street)
                             .' '
                             .mysqli_real_escape_string($link, $streetno)
                             .' '
                             .mysqli_real_escape_string($link, $city)
                             .' '
                             .mysqli_real_escape_string($link, $county);
            $param_username = mysqli_real_escape_string($link, $username);
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            
            if(mysqli_stmt_execute($stmt)){
                //header("location: ./includes/mailer.php");
                $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
                include ($IPATH."includes/mailer.php");
            } 
            else {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    //mysqli_close($link);


}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inregistrare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Inregistrare</h2>
        <p>Te rugam completeaza acest formular pentru inscriere.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Nume -->
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Nume *</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div> 

            <!-- Prenume -->
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>Prenume *</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" required>
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div> 

            <!-- Email -->
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <!-- Telefon -->
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Telefon *</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" required>
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div> 

            <!-- Username -->
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username *</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>  

            <!-- Parola   -->
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Parola *</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <!-- Confirmare parola -->
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirma parola *</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <!-- Adresa -->
            <label>Adresa:</label>
            <div class="form-group <?php echo (!empty($street_err)) ? 'has-error' : ''; ?>">
                <label>Strada *</label>
                <input type="text" name="street" class="form-control" value="<?php echo $street; ?>" required>
                <span class="help-block"><?php echo $street_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($streetno_err)) ? 'has-error' : ''; ?>">
                <label>Numar *</label>
                <input type="text" name="streetno" class="form-control" value="<?php echo $streetno; ?>" required>
                <span class="help-block"><?php echo $streetno_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>Oras *</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>" required>
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                <label>Judet *</label>
                <select name="county" class="form-control" autocomplete="off" required>
                    <option value="">--Alege--</option>
                        <?php
                            echo $options;
                        ?>
                </select>
                <span class="help-block"><?php echo $county_err; ?></span>
            </div>


            <!-- Butoane -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Ai deja un cont? <a href="login.php">Autentificare</a>.</p>
            <!-- <input type="" name="error" value="<?php echo $anyerror; ?>" style="display:none;"> -->
        </form>
    </div>    
</body>
</html>