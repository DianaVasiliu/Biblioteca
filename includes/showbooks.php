<?php

    require_once 'dbconnect.php';

    $conn = connectdb();

    $query = "SELECT DISTINCT categorie FROM carte WHERE tip='digitala' ORDER BY categorie";
    $categories = array();
    $titlu = array();
    $prenume = array();
    $nume = array();

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        array_push($categories, $row[0]);
    }

    print '<div id="categorii"><div class="column">';

    for ($nrcat = 0; $nrcat <= count($categories) / 2; $nrcat++) {
        $titlu = array();
        $prenume = array();
        $nume = array();
        $fisier = array();
        $link = '';

        print '<h2>'.ucfirst(strtolower($categories[$nrcat])).'</h2>';
        print '<ol class="listacarti fictiune">';

        $query2 = "SELECT  titlu, prenume, nume, url_fisier " 
                . "FROM carte JOIN autor USING (id_autor) "
                . "WHERE tip='digitala' AND lower(carte.categorie) = '"
                . strtolower($categories[$nrcat])
                ."'";

        $result2 = mysqli_query($conn, $query2);

        while($row = mysqli_fetch_array($result2)) {
            array_push($titlu, $row[0]);
            array_push($prenume, $row[1]);
            array_push($nume, $row[2]);
            array_push($fisier, $row[3]);
        }

        for ($i = 0; $i < count($titlu); $i++) {
            print '<li><a href="./pdf_files/'.$fisier[$i].'" download="'.$fisier[$i].'">'; 
            print '"' . $titlu[$i] . '" - ' . $prenume[$i] . ' ' . $nume[$i];
            print '</a></li>';
        }

        print '</ol><br>';
    }

    print '</div>'; // inchid prima coloana
    print '<div class="column">';

    for ($nrcat = count($categories) / 2 + 1; $nrcat < count($categories); $nrcat++) {
        $titlu = array();
        $prenume = array();
        $nume = array();
        $fisier = array();
        $link = '';

        print '<h2>'.ucfirst(strtolower($categories[$nrcat])).'</h2>';
        print '<ol class="listacarti fictiune">';

        $query2 = "SELECT  titlu, prenume, nume, url_fisier " 
                . "FROM carte JOIN autor USING (id_autor) "
                . "WHERE tip='digitala' AND lower(carte.categorie) = '"
                . strtolower($categories[$nrcat])
                . "'";

        $result2 = mysqli_query($conn, $query2);

        while($row = mysqli_fetch_array($result2)) {
            array_push($titlu, $row[0]);
            array_push($prenume, $row[1]);
            array_push($nume, $row[2]);
            array_push($fisier, $row[3]);
        }

        for ($i = 0; $i < count($titlu); $i++) {
            print '<li><a href="./pdf_files/'.$fisier[$i].'" download="'.$fisier[$i].'">'; 
            print '"' . $titlu[$i] . '" - ' . $prenume[$i] . ' ' . $nume[$i];
            print '</a></li>';
        }

        print '</ol><br>';
    }
    print '</div></div>';   // inchid a doua coloana si "categorii"
    
?>
