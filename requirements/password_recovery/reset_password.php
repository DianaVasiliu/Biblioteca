<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../Composer/vendor/autoload.php';
require_once '../dbconnect.php';

$link = connectdb();

session_start();

$errors = [];
$user_id = $_SESSION['id'];

if (isset($_GET['token'])) {
  $_SESSION['token'] = mysqli_real_escape_string($link, $_GET['token']);
}


if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($link, $_POST['email']);
  
  $query = "SELECT email FROM client WHERE email LIKE BINARY '" . $email . "'";
  $res = mysqli_query($link, $query);

  if (empty($email)) {
    array_push($errors, "Adresa de email este obligatorie!");
  }
  else if ($res && mysqli_num_rows($results) <= 0) {
    array_push($errors, "Ne pare rau, nu exista utilizator cu acest email in sistem!");
  }
  
  $token = bin2hex(random_bytes(50));

  if (count($errors) == 0) {
    
    $query = "INSERT INTO password_reset (email, token) VALUES ('$email', '$token')";
    $res = mysqli_query($link, $query);

    $mail = new PHPMailer(true);

    //$mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
    );

    // $host = "localhost";
    $host = "bib.epizy.com";

    $mail->SMTPSecure = 'tls';

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    $mail->setFrom('myemail', 'Biblioteca');
    $mail->addAddress($email);

    $resetlink = $host . '/Proiect/requirements/password_recovery/new_pass.php?token=' . $token;

    $mail->isHTML(true);
    $mail->Subject = 'Resetare parola';
    $mail->Body    = 'Salutare! <br><br>
    <p>Am primit cererea ta pentru resetarea parolei pe bib.epizy.com. Apasa pe link-ul de mai jos pentru a reseta parola.</p>
    <br>
    <a href="'. $resetlink .'">'. $resetlink .'</a>
    <br>
    <p>Cu stima,<br>Echipa BNR</p>';
    

    if (!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: '.$mail->ErrorInfo;
    }
    else {
      header('location: pending.php?email=' . $email);
    }
    
  }
}


if (isset($_POST['new_password'])) {
  $new_pass = mysqli_real_escape_string($link, $_POST['new_pass']);
  $new_pass_c = mysqli_real_escape_string($link, $_POST['new_pass_c']);

  $token = $_SESSION['token'];

  if (empty($new_pass) || empty($new_pass_c)) 
    array_push($errors, "Parola este obligatorie");

  if ($new_pass !== $new_pass_c) 
    array_push($errors, "Parolele nu coincid");

  if (count($errors) == 0) {
    
    $query = "SELECT email FROM password_reset WHERE token LIKE BINARY '" . $token. "' LIMIT 1";
    $res = mysqli_query($link, $query);
    $email = mysqli_fetch_array($res)[0];

    if ($email) {
      $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
      $query = "UPDATE client SET parola='" . $new_pass . "' WHERE email LIKE BINARY '" . $email . "'";
      $res = mysqli_query($link, $query);

      header('location: index.php');
    }
  }
}
?>