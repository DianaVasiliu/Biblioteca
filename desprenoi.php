<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // require '../Composer/vendor/autoload.php';
    require 'C:/xampp/Composer/vendor/autoload.php';
    require_once './requirements/dbconnect.php';

    session_start();
    
    $link = connectdb();
    mysqli_set_charset($link , "utf8");

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
        
            $mail->setFrom('diana.vasiliu10@gmail.com', 'Biblioteca');
            $mail->addAddress('diana.vasiliu10@gmail.com', 'Biblioteca');
        
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
    <meta charset="UTF-8">
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
                Potrivit celor mai mulţi istorici şi cercetători, Biblioteca Naţională a României îşi găseşte originile într-una dintre cele mai vechi şi reprezentative biblioteci din România - Biblioteca Colegiului Sf. Sava din Bucureşti. Aceasta şi-a deschis colecţiile către publicul larg în anul 1838, atunci când au fost catalogate aproximativ 1000 de volume de carte franţuzească. După Unirea din 1859, aceasta a obţinut statutul de bibliotecă naţională, primind alternativ denumirea de Bibliotecă Naţională şi Bibliotecă Centrală. În anul 1864, prin legea Reglementărilor publice, este numită Biblioteca Centrală a Statului, denumire şi statut păstrate până în anul 1901, când este desfiinţată, iar colecţiile sale sunt transferate Bibliotecii Academiei Române care primeşte statutul de bibliotecă naţională. Pentru perioada aceasta doar o singură funcţie naţională poate fi considerată relevantă pentru bibliotecă şi anume, funcţia patrimonială. În anul 1955 fondul de carte revine noii biblioteci înfiinţate - Biblioteca Centrală de Stat, principala bibliotecă publică din România.
                </p>
                <p>
                Imediat după prăbuşirea comunismului, la începutul lunii ianuarie 1990, Biblioteca Centrală de Stat a devenit Biblioteca Naţională a României (ISIL RO-B-011), ca urmare a deciziei adoptate de noua putere, iar după intrarea României în Uniunea Europeană aceasta îşi dezvoltă funcţiile, implicându-se activ în numeroase proiecte naţionale şi internaţionale, precum TELplus, Manuscriptorium, Rediscover ş.a. 
                </p>
            </section>
            <br>
            <section class="sectiune motivatie">
                <h2 id="motivatie">Motivatie</h2>
                <p>
                    Motivatia noastra este promovarea lecturii de orice tip, fie ea de specialitate sau beletristica, in scopul de a culturaliza oamenii prin intermediul literaturii. Scopul literaturii este acela de a deschide orizonturi noi, de a hrani imaginatia si de a crea lumi noi, in care orice este posibil. Acest lucru face oamenii mai buni si vrem sa facem parte din cei care ajuta la crearea unei lumi mai bune.
                </p>
            </sectiune>
            <br>
            <section class="sectiune regulament">
                <h2 id="regulament">Regulament intern</h2>
                <p>
                    Ca in orice institutie civilizata, trebuie sa existe si un set de reguli ce trebuie respectate. Acestea pot fi gasite la link-ul de mai jos:
                </p>
                <a href="./pdf_files/Regulament.pdf" download="Regulament.pdf">Regulament</a>
            </section>
            <br>
            <section class="sectiune gdpr">
                <h2 id="gdpr">Informatii GDPR</h2>
                <p>
                    Ne asumam raspunderea de a avea grija de toate datele furnizate de clientii nostri, astfel ca avem politica GDPR foarte bine pusa la punct. O poti vedea accesand link-ul de mai jos:
                </p>
                <a href="./pdf_files/GDPR.pdf" download="Politica_BNR_GDPR_2020.pdf">GDPR</a>
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


