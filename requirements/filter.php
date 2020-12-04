<?php 
    require_once './dbconnect.php';
    require './functions.php';
    $link = connectdb();

    session_start();

    if (isset($_POST['cauta'])) {
        
        $autorfilter = verify_filter("autor");
        $catfilter = verify_filter("categorie");
        $anfilter = verify_filter("an");
        $editurafilter = verify_filter("editura");

        $query = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte
                FROM carte JOIN categorie USING (id_categorie) 
                JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
                WHERE tip='fizica' 
                AND categorie IN " . mysqli_real_escape_string($link, $catfilter) . 
                " AND an IN " . mysqli_real_escape_string($link, $anfilter) . 
                " AND editura IN " . mysqli_real_escape_string($link, $editurafilter) . 
                " GROUP BY titlu
                ORDER BY id_carte";

        $_SESSION['query'] = $query;
    }

?>