


<div id="top">
    <div id="div_titlu">
        <h1><a href="paginaprincipala.php">
            Biblioteca Nationala
        </a></h1>
        <!-- <div><h4>Biblioteca publica a bucurestenilor</h4></div> -->
        
    </div>   

<?php
    
    $inactive = 3600;
    ini_set('session.gc_maxlifetime', $inactive);

    if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $inactive)) {
        
        session_unset();
        session_destroy();
    }
    $_SESSION['testing'] = time(); // Update session
?>
    <p style="color: white">
<?php
    echo $_SESSION['ok'];
?>
    </p>
    <div id="login">
        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] == true)
                echo 'Salut, ' . $_SESSION["username"] . "!";
        ?>
        <?php

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        ?>
                <p>
                    <a href="./contulmeu.php">Contul meu</a>
                    |
                    <a href="./requirements/logout.php">Deconectare</a>
                </p>
        <?php
            }
            else {
        ?>
                <p>
                    <a href="./login.php">Autentificare</a>
                    |
                    <a href="./register.php">Inregistrare</a>
                </p>
        <?php
            }
        ?>
    </div>


    <div id="div_meniu">
        <a href="desprenoi.php" id="dnlink"><!--
        --><div class="meniu b1">
                <h2>Despre noi</h2>
            </div><!--
    --></a><!--
    --><a href="bibliotecafizica.php"><!--
        --><div class="meniu b2">
                <h2>Biblioteca fizica</h2>
            </div><!--
    --></a><!--
    --><a href="bibliotecadigitala.php"><!--
        --><div class="meniu b3">
                <h2>Biblioteca digitala</h2>
            </div><!--
    --></a><!--
    --><a href="faq.php"><!--
        --><div class="meniu b4">
                <h2>Intrebari frecvente</h2>
            </div><!--
    --></a>
    </div>

    <div class="div_hamburger">
        <input type="button" id="hamburger" class="noreset" value="≡"></input>
    </div>
    


</div>




