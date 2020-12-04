<?php 

function verify_filter ($filter) {
    $sfilter = "";

    if ($filter != "an") {
        if(!empty($_POST[$filter])) { 
            $sfilter = "(";
    
            for ($i = 0; $i < count($_POST[$filter]); $i++){
                $_SESSION['filters'][] = $_POST[$filter][$i];

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
                $_SESSION['filters'][] = $_POST[$filter][$i];

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
    for ($j = 0; $j < count($_SESSION['filters']); $j++) {
        if ($_SESSION['filters'][$j] == $value) {
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


?>