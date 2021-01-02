<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../Composer/vendor/autoload.php';
require_once './requirements/dbconnect.php';

$link = connectdb();
mysqli_set_charset($link , "utf8");

session_start();

$captcha_err = '';
$trimis = '';

if (!isset($_POST['submit'])) {
    $message = $subject = '';
}

if (isset($_POST['submit'])) {
    $captcha = mysqli_real_escape_string($link, trim($_POST['captcha_challenge']));
    $message = mysqli_real_escape_string($link, trim($_POST['mesaj']));
    $subject = mysqli_real_escape_string($link, trim($_POST['subject']));

    if ($captcha == $_SESSION['captcha_text']) {
        $from = mysqli_real_escape_string($link, trim($_POST['email']));
        $name = mysqli_real_escape_string($link, trim($_POST['nume']));
    
        $mail = new PHPMailer(true);

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    
        $mail->Host = 'smtp.gmail.com';
    
        $mail->setFrom('myemail', 'Biblioteca');
        $mail->addAddress('myemail', 'Biblioteca');
    
        $mail->isHTML(true);
        $mail->Subject = 'E-mail nou de la utilizator';
        $mail->Body = '
            Email nou de la utilizatorul: <br>
            Nume: ' . $name . '<br>
            Email: ' . $from . '<br><br>
            Subiect: ' . $subject . '<br>
            Mesajul transmis:<br>
            "' . $message . '"<br>';
    
        if (!$mail->send()) {
            $trimis = 'fail';
        }
        else {
            $trimis = 'succes';
        }
        header("Location: ./desprenoi.php?status=".$trimis);
    }
    else {
        $captcha_err = "Captcha incorect!";
    } 
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <link rel="stylesheet" href="./css/desprenoi.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">
    <link rel="stylesheet" href="./css/contactform.css">

    <title>Despre noi</title>

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
	<header id="header">
<?php 
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."requirements/header.php"); 
?>
	</header>
<?php
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."requirements/mobile_menu.php"); 
?>

<div id="corp">
    <div id="continut">
        <section class="sectiune istoric">
            <h2 id="istoric">Scurt istoric</h2>
            <p>
            Potrivit celor mai multi istorici si cercetatori, Biblioteca Nationala a Romaniei isi gaseste originile intr-una dintre cele mai vechi si reprezentative biblioteci din Romania - Biblioteca Colegiului Sf. Sava din Bucuresti. Aceasta si-a deschis colectiile catre publicul larg in anul 1838, atunci cand au fost catalogate aproximativ 1000 de volume de carte frantuzeasca. Dupa Unirea din 1859, aceasta a obtinut statutul de biblioteca nationala, primind alternativ denumirea de Biblioteca Nationala si Biblioteca Centrala. in anul 1864, prin legea Reglementarilor publice, este numita Biblioteca Centrala a Statului, denumire si statut pastrate pana in anul 1901, cand este desfiintata, iar colectiile sale sunt transferate Bibliotecii Academiei Romane care primeste statutul de biblioteca nationala. Pentru perioada aceasta doar o singura functie nationala poate fi considerata relevanta pentru biblioteca si anume, functia patrimoniala. in anul 1955 fondul de carte revine noii biblioteci infiintate - Biblioteca Centrala de Stat, principala biblioteca publica din Romania.
            </p>
            <p>
            Imediat dupa prabusirea comunismului, la inceputul lunii ianuarie 1990, Biblioteca Centrala de Stat a devenit Biblioteca Nationala a Romaniei (ISIL RO-B-011), ca urmare a deciziei adoptate de noua putere, iar dupa intrarea Romaniei in Uniunea Europeana aceasta isi dezvolta functiile, implicandu-se activ in numeroase proiecte nationale si internationale, precum TELplus, Manuscriptorium, Rediscover s.a. 
            </p>
        </section>
        <br>
        <section class="sectiune motivatie">
            <h2 id="motivatie">Motivatie</h2>
            <p>
                Motivatia noastra este promovarea lecturii de orice tip, fie ea de specialitate sau beletristica, in scopul de a culturaliza oamenii prin intermediul literaturii. Scopul literaturii este acela de a deschide orizonturi noi, de a hrani imaginatia si de a crea lumi noi, in care orice este posibil. Acest lucru face oamenii mai buni si vrem sa facem parte din cei care ajuta la crearea unei lumi mai bune.
            </p>
        </section>
        <br>
        <section class="sectiune regulament">
            <h2 id="regulament">Regulament intern</h2>
            <p>
                Ca in orice institutie civilizata, trebuie sa existe si un set de reguli ce trebuie respectate. Acestea pot fi gasite la link-ul de mai jos:
            </p>
            <a href="https://drive.google.com/file/d/1gOaVO5SeKFcUAfEHEnsCzyms07fqozEv/view?usp=sharing" target="_blank">Regulament</a>
        </section>
        <br>
        <section class="sectiune gdpr">
            <h2 id="gdpr">Informatii GDPR</h2>
            <p>
                Ne asumam raspunderea de a avea grija de toate datele furnizate de clientii nostri, astfel ca avem politica GDPR foarte bine pusa la punct. O poti vedea accesand link-ul de mai jos:
            </p>
            <a href="https://drive.google.com/file/d/1uJzkwqSEfR8VJXo9em6gol38LwRU2q02/view?usp=sharing" target="_blank">GDPR</a>
        </section>
        <br>
        <hr>
        <br>
        <section class="sectiune scontact">
            <h2 id="contact">Contact</h2>
            <div class="div_contact">
                <div class="contact_2">
                    <h3>Sediul principal:</h3>
                    <p>
                        Bulevardul Unirii nr. 22, Bucuresti 030833
                    </p>
                    <br>
                    <h3>Sectia de colectii speciale:</h3>
                    <p>
                        Strada Biserica Amzei 5-7, Bucuresti 10394
                    </p>
                    <br>

                    <h3>Informatii pentru utilizatori</h3>
                    <p>Telefon: 0213142434/1064; 0213174711</p>
                    <p>E-mail: <a href="mailto:comunicarea.colectiilor@bibnat.ro">comunicarea.colectiilor@bibnat.ro</a></p>
                    <br>
                    <div class="wrapper" id="contact">
                        <h2>Formular de contact</h2>
                        <p>Campurile marcate cu * sunt obligatorii.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <table id="contacttable">
                                <tr>
                                    <td class="item">Nume complet *</td>
                                    <td class="values"><input type="text" name="nume" class="form-input" required></td>
                                </tr>
                                <tr>
                                    <td class="item">E-mail *</td>
                                    <td class="values"><input type="email" name="email" class="form-input" required></td>
                                </tr>
                                <tr>
                                    <td class="item">Subiect *</td>
                                    <td class="values"><input type="text" name="subject" class="form-input" required value="<?php echo $subject; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="item">Mesaj *</td>
                                    <td><textarea name="mesaj" class="form-textarea" required><?php echo $message; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>

                            </table>

                            <div class="elem-group">
                                <label for="captcha">Te rugam introdu textul Captcha</label> <br>
                                <img src="./requirements/captcha.php" alt="CAPTCHA" class="captcha-image">
                                <span class="fas fa-redo refresh-captcha">Genereaza cod nou</span> <br>
                                <input type="text" class="form-input" id="captcha" name="captcha_challenge"> <br> <br>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn" value="Trimite" name='submit'>
                                <br>
<?php 
                                if (isset($_GET['status'])) {
                                    if ($_GET['status'] == 'fail') {
                                        echo 'Mailul nu a putut fi trimis.';
                                    }
                                    else {
                                        echo 'Email-ul a fost trimis cu succes!'; 
                                    }
                                }
                                
                                echo $captcha_err;
?>
                            </div>
                        </form>
                    </div>        
                </div>

                <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1ygqcYgAjN6y7yVUX-6h_b1MwdMEz34Yp" ></iframe>
            </div>
        </section>
    </div>
</div>

<?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
?>
    
    <script src="./js/common.js"></script>
    <script src="./js/desprenoi.js"></script>

</body>
</html>


