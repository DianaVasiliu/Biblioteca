<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/faq.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">

    <title>Intrebari frecvente</title>
</head>

<script src="paginaprincipala.js"></script>

<body>
    <header id="header">
        <?php 
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."/includes/header.php"); 
        ?>
    </header>
    <?php
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."includes/mobile_menu.php"); 
    ?>

    <div id="corp">
        <div id="continut">

            <section>
                <div class="container">
                    <div class="accordion">
                        <div class="accordion-item" id="question1">
                            <div class="accordion-link">
                                Cum imi creez un cont?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                                <p>
                                Foarte simplu! Tot ce trebuie sa faci este sa apesi pe butonul din coltul din dreapta sus pe care scrie "Inregistrare" si vei fi redirectionat automat catre un formular. Completezi datele cerute, iar apoi vei primi un e-mail cu instructiuni de validare a contului. Gata! Contul tau este acum activ!
                                </p>
                            </div>
                        </div>

                        <div class="accordion-item" id="question2">
                            <div class="accordion-link">
                                De ce sa imi creez un cont?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                                <p>
                                Sunt multe avantaje in a avea un cont de utilizator. Cateva dintre acestea sunt: </p>
                                <ul>
                                    <li>poti face imprumuturi de la noi (nu se pot imprumuta carti fara un cont de utilziator)</li>
                                    <li>ai acces la descrierea cartilor din biblioteca noastra</li>
                                    <li>poti lasa un review la orice carte doresti</li>
                                    <li>in cadrul contului tau, ai acces la lista tuturor cartilor pe care le-ai imprumutat de la noi</li>
                                </ul>
                                <p>
                                Te incurajam sa iti creezi un cont de utilizator! Daca esti nemultumit, il poti sterge oricand. In plus, totul este gratuit!
                                </p>
                            </div>
                        </div>

                        <div class="accordion-item" id="question3">
                            <div class="accordion-link">
                                Cum imprumut o carte si de unde o ridic?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Poti imprumuta o carte doar daca esti autentificat in contul tau de utilizator. La "Profilul meu", exista un formular de cerere de imprumut. Completezi datele cerute acolo si vei primi un mesaj cu statusul cartii cerute. Trebuie sa alegi o data la care poti ridica cartea! 
                            </p>
                            <p>
                                Cartea poate fi ridicata de la sediul central al bibliotecii noastre, de pe Bulevardul Unirii nr. 22, in timpul programului afisat.
                            </p>
                            <p>
                                <span class="bold">Atentie!</span> Daca nu ridici cartea la data solicitata, atunci imprumutul va fi anulat si vei fi taxat conform Regulamentului.
                            </p>
                            </div>
                        </div>

                        <div class="accordion-item" id="question4">
                            <div class="accordion-link">
                                Exista sali de lectura pentru studentii care vin de acasa sa invete?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Da. Va asteptam cu drag.
                            </p> 
                            <p>
                                Exista numeroase spatii deschise si sali de lectura in sediul central (cel de pe Bd. Unirii). O parte din locurile din spatiile deschise sunt dotate cu calculatoare conectate la internet, iar cea mai mare parte din ele sunt dotate cu priza si cu lampa personala.
                            </p>
                            </div>
                        </div>
                        <div class="accordion-item" id="question5">
                            <div class="accordion-link">
                                As dori sa fac voluntariat / practica de specialitate la Biblioteca dvs. Cum procedez?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Citeste <a href="../pdf_files/Regulament.pdf" download="../pdf_files/Regulament.pdf">regulamentul</a> si scrie-ne la exemplu@gmail.com. Iti vom raspunde in cel mai scurt timp.
                            </p> 
                            </div>
                        </div>
                        <div class="accordion-item" id="question6">
                            <div class="accordion-link">
                                Ce este "biblioteca digitala"?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Biblioteca digitala este o biblioteca in care gasesti carti in format digital (.pdf), disponibile pentru descarcare gratuita.
                            </p> 
                            </div>
                        </div>
                        <div class="accordion-item" id="question7">
                            <div class="accordion-link">
                                Care este programul spatiilor deschise ale Bibliotecii?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Utilizatorii au acces in spatiile deschise, in limita locurilor disponibile, dupa urmatorul program: Luni, Miercuri, Vineri ora 08:00-20:00, Marti, Joi ora 08:00-18:00, Sambata ora 09:00-18:00, Duminica inchis.
                            </p> 
                            </div>
                        </div>
                        <div class="accordion-item" id="question8">
                            <div class="accordion-link">
                                Biblioteca ofera servicii de livrare la domiciliu a cartilor solicitate pentru imprumut?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Biblioteca noastra nu ofera servicii de livrare pentru niciun fel de solicitare.
                            </p> 
                            </div>
                        </div>
                        <div class="accordion-item" id="question9">
                            <div class="accordion-link">
                                Cate titluri pot solicita simultan?
                                <span class="icon plus">+</span>
                                <span class="icon minus">-</span>
                            </div>
                            <div class="answer">
                            <p>
                                Poti solicita maxim 5 carti la un imprumut.
                            </p> 
                            </div>
                        </div>
                    </div>
                </div>
            </section>



        </div>
    </div>


    <?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."includes/footer.php"); 
    ?>


<script src="./js/faq.js"> </script>
<script src="./js/common.js"></script>

</body>

</html>