<?php 
    require_once './dbconnect.php';
    require './functions.php';
    $link = connectdb();

    session_start();

    if (isset($_POST['cauta'])) {
        // echo $_SESSION['nrautorfiltru'] . '<br>';
        // echo $_SESSION['nrcategoriefiltru'] . '<br>';
        // echo $_SESSION['nranfiltru'] . '<br>';
        // echo $_SESSION['nrediturafiltru'] . '<br>';
        
        $autorfilter = verify_filter("autor");
        $catfilter = verify_filter("categorie");
        $anfilter = verify_filter("an");
        $editurafilter = verify_filter("editura");

        // echo $autorfilter . "<br>";
        // echo $catfilter . "<br>";
        // echo $anfilter . "<br>";
        // echo $editurafilter . "<br>";

        $query = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte
                    FROM carte JOIN categorie USING (id_categorie) 
                    JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
                    WHERE tip='fizica' 
                    AND categorie IN " . $catfilter . 
                    " AND an IN " . $anfilter . 
                    " AND editura IN " . $editurafilter . 
                    " GROUP BY titlu
                    ORDER BY id_carte";

        $_SESSION['query'] = $query;
    }

?>