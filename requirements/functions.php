<?php 

function verify_filter ($filter) {
    $sfilter = "";

    if ($filter != "an") {
        if(!empty($_POST[$filter])) {
            $sfilter = "(";
    
            for ($i = 0; $i < count($_POST[$filter]); $i++){
                array_push($_SESSION['filters'][$filter], $_POST[$filter][$i]);

                $sfilter = $sfilter . "'" . trim($_POST[$filter][$i]) . "'";
                if ($i < count($_POST[$filter]) - 1) {
                    $sfilter = $sfilter . ",";
                }
            }
            $sfilter = $sfilter . ")";
        }
    }
    else {
        if(!empty($_POST[$filter])) { 
            $sfilter = "(";
    
            for ($i = 0; $i < count($_POST[$filter]); $i++){
                array_push($_SESSION['filters'][$filter], $_POST[$filter][$i]);

                $sfilter = $sfilter . trim($_POST[$filter][$i]);
                if ($i < count($_POST[$filter]) - 1) {
                    $sfilter = $sfilter . ",";
                }
            }
            $sfilter = $sfilter . ")";
        }
    }

    return $sfilter;

}


function check_filters ($value) {    
    for ($j = 0; $j < count($_SESSION['filters']['autor']); $j++) {
        if ($_SESSION['filters']['autor'][$j] == $value) {
            return 'checked';
        }
    }
    
    for ($j = 0; $j < count($_SESSION['filters']['categorie']); $j++) {
        if ($_SESSION['filters']['categorie'][$j] == $value) {
            return 'checked';
        }
    }
    
    for ($j = 0; $j < count($_SESSION['filters']['an']); $j++) {
        if ($_SESSION['filters']['an'][$j] == $value) {
            return 'checked';
        }
    }
    
    for ($j = 0; $j < count($_SESSION['filters']['editura']); $j++) {
        if ($_SESSION['filters']['editura'][$j] == $value) {
            return 'checked';
        }
    }
    return '';
}

function update_rating($link, $query, $bookid) {
    $res = mysqli_query($link, $query);

    $query = "SELECT ROUND(AVG(nota), 2)
              FROM reviews
              WHERE id_carte = " . $bookid;

    $res = mysqli_query($link, $query);

    $average = 0;
    while ($row = mysqli_fetch_array($res)) {
        $average = $row[0];
    }

    $query = "UPDATE carte
              SET nota = " . $average .
            " WHERE id_carte = " . $bookid;

    $res = mysqli_query($link, $query);
}

function make_mysql_filter_list ($tip) {
    $filter = "(";

    if ($tip != 'an') {
        for ($i = 0; $i < count($_SESSION['filters'][$tip]); $i++) {
            $filter .= "'" . $_SESSION['filters'][$tip][$i] . "'";
            if ($i < count($_SESSION['filters'][$tip]) - 1) {
                $filter .= ", ";
            }
        }
    }
    else {
        for ($i = 0; $i < count($_SESSION['filters'][$tip]); $i++) {
            $filter .= $_SESSION['filters'][$tip][$i];
            if ($i < count($_SESSION['filters'][$tip]) - 1) {
                $filter .= ", ";
            }
        }
    }

    $filter .= ")";

    return $filter;
}

function cauta($mod) {
    if ($mod == 0) {
        $autorfilter = verify_filter("autor");
        $catfilter = verify_filter("categorie");
        $anfilter = verify_filter("an");
        $editurafilter = verify_filter("editura");
    }
    else {
        $autorfilter = make_mysql_filter_list("autor");
        $catfilter = make_mysql_filter_list("categorie");
        $anfilter = make_mysql_filter_list("an");
        $editurafilter = make_mysql_filter_list("editura");
    }

    $query = "SELECT DISTINCT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte, prenume, nume
                FROM carte 
                JOIN categorie USING (id_categorie) 
                JOIN carte_autor USING (id_carte) 
                JOIN autor USING (id_autor)
                WHERE tip='fizica'
                AND id_carte IN (
                    SELECT id_carte
                    FROM carte_autor
                    WHERE 1 = 1
                ";

    if (!empty(trim($autorfilter, "()"))) {
        $query = $query . " AND id_autor IN (
                                SELECT id_autor
                                FROM autor
                                WHERE id_autor IN (
                                    SELECT id_autor
                                    FROM autor
                                    WHERE BINARY CONCAT(prenume, ' ', nume) IN " . $autorfilter . "
                                )
                            )";
    }

    $query .= ")";
    
    if (!empty(trim($catfilter, "()"))) {
        $query = $query . " AND categorie IN (
                                SELECT categorie
                                FROM categorie
                                WHERE lower(categorie) IN " . $catfilter . "
                            )";
    }
    if (!empty(trim($anfilter, "()"))) {
        $query = $query . " AND an IN (
                                SELECT an
                                FROM carte
                                WHERE an IN " . $anfilter . "
                            )";
    }
    if (!empty(trim($editurafilter, "()"))) {
        $query = $query . " AND lower(editura) IN (
                                SELECT lower(editura)
                                FROM carte
                                WHERE BINARY lower(editura) IN " . $editurafilter . "
                            )";
    }

    if (isset($_SESSION['my_filter']) && $_SESSION['my_filter'] != '') {
        $filter = $_SESSION['my_filter'];
        $query = $query . " AND (   lower(titlu) LIKE BINARY '%" . strtolower($filter) . "%'
                                    OR 
                                    lower(categorie) LIKE BINARY '%" . strtolower($filter) . "%'
                                    OR 
                                    lower(nume) LIKE BINARY '%" . strtolower($filter) . "%'
                                    OR 
                                    lower(prenume) LIKE BINARY '%" . strtolower($filter) . "%'
                                )";
    }
    
    $query = $query . " GROUP BY titlu";
    
    if (isset($_SESSION['order_by'])) {
        $query .= " ORDER BY " . $_SESSION['order_by'];
    }

    $_SESSION['query'] = $query;
}

function reset_filters() {    
    $_SESSION['filters']['autor'] = array();
    $_SESSION['filters']['categorie'] = array();
    $_SESSION['filters']['an'] = array();
    $_SESSION['filters']['editura'] = array();
}

?>