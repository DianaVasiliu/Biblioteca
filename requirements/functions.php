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




?>