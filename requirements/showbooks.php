<?php

    require_once 'dbconnect.php';

    $conn = connectdb();

    $query = "SELECT DISTINCT id_categorie, categorie
                FROM carte JOIN categorie USING (id_categorie)
                WHERE tip='digitala'
                ORDER BY categorie";

    $categories = array();
    $categories_id = array();
    $titlu = array();
    $prenume = array();
    $nume = array();

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        array_push($categories_id, $row[0]);
        array_push($categories, $row[1]);
    }

    print '<div id="categorii"><div class="column">';

    for ($nrcat = 0; $nrcat <= count($categories) / 2 - 1; $nrcat++) {
        $titlu = array();
        $fisier = array();
        $link = '';

        print '<h2>'.ucfirst(strtolower($categories[$nrcat])).'</h2>';
        print '<ol class="listacarti fictiune">';

        $query2 = "SELECT DISTINCT titlu
                    FROM carte JOIN carte_autor USING (id_carte)
                    JOIN autor USING (id_autor)
                    WHERE tip='digitala' AND id_categorie = '"
                 . $categories_id[$nrcat]."'";

        $result2 = mysqli_query($conn, $query2);

        while($row = mysqli_fetch_array($result2)) {
            array_push($titlu, $row[0]);
        }

        for ($i = 0; $i < count($titlu); $i++) {
            
            $prenume = array();
            $nume = array();
            
            $query2 = "SELECT prenume, nume, url_fisier
                        FROM carte JOIN carte_autor USING (id_carte)
                        JOIN autor USING (id_autor)
                        WHERE tip='digitala'
                        AND id_categorie = " . $categories_id[$nrcat] . 
                        " AND titlu = '" . $titlu[$i] . "'";

            $result2 = mysqli_query($conn, $query2);

            while($row = mysqli_fetch_array($result2)) {
                array_push($prenume, $row[0]);
                array_push($nume, $row[1]);
                array_push($fisier, $row[2]);
            }

            print '<li><a href="'.$fisier[$i].'">'; 
            print '"' . $titlu[$i] . '" - ';
            for($j = 0; $j < count($nume); $j++) {
                print $prenume[$j] . ' ' . $nume[$j];
                if ($j < count($nume) - 1) {
                    print ', ';
                }
            }
            print '</a></li><br>';
        }
        print '</ol><br>';
    }

    print '</div>'; // inchid prima coloana
    print '<div class="column">';

    for ($nrcat = count($categories) / 2; $nrcat < count($categories); $nrcat++) {
        $titlu = array();
        $prenume = array();
        $nume = array();
        $fisier = array();
        $link = '';

        print '<h2>'.ucfirst(strtolower($categories[$nrcat])).'</h2>';
        print '<ol class="listacarti fictiune">';

        $query2 = "SELECT DISTINCT titlu
                    FROM carte JOIN carte_autor USING (id_carte)
                    JOIN autor USING (id_autor)
                    WHERE tip='digitala' AND id_categorie = '"
                 . $categories_id[$nrcat]."'";

        $result2 = mysqli_query($conn, $query2);

        while($row = mysqli_fetch_array($result2)) {
            array_push($titlu, $row[0]);
        }

        for ($i = 0; $i < count($titlu); $i++) {

            $prenume = array();
            $nume = array();
            $fisier = array();

            $query2 = "SELECT prenume, nume, url_fisier
                        FROM carte JOIN carte_autor USING (id_carte)
                        JOIN autor USING (id_autor)
                        WHERE tip='digitala'
                        AND id_categorie = " . $categories_id[$nrcat] . 
                        " AND titlu = '" . $titlu[$i] . "'";

            $result2 = mysqli_query($conn, $query2);

            while($row = mysqli_fetch_array($result2)) {
                array_push($prenume, $row[0]);
                array_push($nume, $row[1]);
                array_push($fisier, $row[2]);
            }

            print '<li><a href="'.$fisier[$i].'">'; 
            print '"' . $titlu[$i] . '" - ';
            for($j = 0; $j < count($nume); $j++) {
                print $prenume[$j] . ' ' . $nume[$j];
                if ($j < count($nume) - 1) {
                    print ', ';
                }
            }
            print '</a></li><br>';
        }
        print '</ol><br>';
    }
    print '</div></div>';   // inchid a doua coloana si "categorii"
    
?>
