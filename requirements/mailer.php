<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../Composer/vendor/autoload.php';

if ($anyerror == 0)
{

$hash = md5(rand(0,1000));

$query = "UPDATE client SET token ='" . $hash . "' WHERE lower(email)='". strtolower($email) . "'";

if ($stmt = mysqli_query($link, $query)) {
    $anyerror = 1;
}
else {
    echo "Something went wrong. Please try again later.";
}

mysqli_close($link);

if ($anyerror == 1) {

$name = $lastname . ' ' . $firstname;

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

$mail->setFrom('diana.vasiliu10@gmail.com', 'Biblioteca');
$mail->addAddress($email, $name);

$mail->isHTML(true);
$mail->Subject = 'Confirmare inregistrare';
$mail->Body    = '
<div style="font-size: 130%; padding-top: 10px;">
    <p>Multumim pentru inregistrare!</p>
    
    <p>Contul tau a fost creat, te poti loga cu datele de mai jos dupa ce activezi contul.</p>
    
    <br>
    
    <div>
    ----------------------------------------------<br>
    Username:  ' . $username . ' <br>
    Parola:    ' . $password . ' <br>
    ----------------------------------------------
    </div>
    
    <br><br>

    <p>Apasa pe link-ul de mai jos pentru a-ti activa contul:</p>
    http://'.$host.'/Proiect/requirements/user_activation.php?email=' . strtolower($email) . '&hash=' . $hash . '
    <br>
    <p>Cu stima,<br>Echipa BNR</p>
</div>';

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;
}
else {
?>
    <p style="margin-left: 50px;">A fost trimis un email de confirmare.</p><br>
    <p style="margin-left: 50px;"><a href="./paginaprincipala.php">Inapoi la pagina principala</a></p><br>
<?php
}

}
else {
?>
    <p style="margin-left: 50px;">Am intampinat o problema. Ne cerem scuze.</p><br>
    <p style="margin-left: 50px;"><a href="../paginaprincipala.php">Inapoi la pagina principala</a></p><br>
<?php
}
}
?>