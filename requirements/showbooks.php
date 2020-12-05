<?php

    require_once 'dbconnect.php';

    $link = connectdb();

    $query = "SELECT DISTINCT id_categorie, categorie
                FROM carte 
                JOIN categorie USING (id_categorie)
                WHERE tip = 'digitala'
                ORDER BY categorie";

    $categories = array();
    $categories_id = array();
    $titlu = array();
    $prenume = array();
    $nume = array();

    $res = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($res)) {
        array_push($categories_id, $row[0]);
        array_push($categories, $row[1]);
    }
?>

    <div id="categorii"><div class="column">

<?php
    for ($nrcat = 0; $nrcat <= count($categories) / 2; $nrcat++) {
        $titlu = array();
        $fisier = array();
?>

    <h2><?php echo ucfirst(strtolower($categories[$nrcat])); ?></h2>
    <ol class="listacarti fictiune">

<?php
        $query = "SELECT DISTINCT titlu
                  FROM carte 
                  JOIN carte_autor USING (id_carte)
                  JOIN autor USING (id_autor) 
                  WHERE tip = 'digitala' AND id_categorie = "
                 . $categories_id[$nrcat];

        $res = mysqli_query($link, $query);

        while($row = mysqli_fetch_array($res)) {
            array_push($titlu, $row[0]);
        }

        for ($i = 0; $i < count($titlu); $i++) {
            
            $prenume = array();
            $nume = array();
            
            $query = "SELECT prenume, nume, url_fisier
                        FROM carte JOIN carte_autor USING (id_carte)
                        JOIN autor USING (id_autor)
                        WHERE BINARY tip = 'digitala'
                        AND id_categorie = " . $categories_id[$nrcat] . 
                        " AND BINARY titlu = '" . $titlu[$i] . "'";

            $res = mysqli_query($link, $query);

            while($row = mysqli_fetch_array($res)) {
                array_push($prenume, $row[0]);
                array_push($nume, $row[1]);
                array_push($fisier, $row[2]);
            }
?>

        <li><a target="_blank" href="<?php echo $fisier[$i]; ?>">

<?php  
            echo '"' . $titlu[$i] . '" - ';
            for($j = 0; $j < count($nume); $j++) {
                echo $prenume[$j] . ' ' . $nume[$j];
                if ($j < count($nume) - 1) {
                    echo ', ';
                }
            }
?>
            </a>
        </li>
        <br>
<?php
        }
?>
    </ol>
    <br>
<?php
    }
?>

</div> <!-- inchid prima coloana -->
<div class="column">

<?php
    for ($nrcat = count($categories) / 2 + 1; $nrcat < count($categories); $nrcat++) {
        $titlu = array();
        $prenume = array();
        $nume = array();
        $fisier = array();
?>
        <h2><?php echo ucfirst(strtolower($categories[$nrcat])); ?></h2>
        <ol class="listacarti <?php echo $categories[$nrcat]; ?>">
<?php

        $query = "SELECT DISTINCT titlu
                    FROM carte JOIN carte_autor USING (id_carte)
                    JOIN autor USING (id_autor)
                    WHERE BINARY tip = 'digitala' AND id_categorie = '"
                 . $categories_id[$nrcat]."'";

        $res = mysqli_query($link, $query);

        while($row = mysqli_fetch_array($res)) {
            array_push($titlu, $row[0]);
        }

        for ($i = 0; $i < count($titlu); $i++) {

            $prenume = array();
            $nume = array();
            $fisier = array();

            $query = "SELECT prenume, nume, url_fisier
                        FROM carte JOIN carte_autor USING (id_carte)
                        JOIN autor USING (id_autor)
                        WHERE BINARY tip = 'digitala'
                        AND id_categorie = " . $categories_id[$nrcat] . 
                        " AND BINARY titlu = '" . $titlu[$i] . "'";

            $res = mysqli_query($link, $query);

            while($row = mysqli_fetch_array($res)) {
                array_push($prenume, $row[0]);
                array_push($nume, $row[1]);
                array_push($fisier, $row[2]);
            }
?>
            <li><a target="_blank" href="<?php echo $fisier[$i]; ?>">
<?php
            echo '"' . $titlu[$i] . '" - ';
            for($j = 0; $j < count($nume); $j++) {
                echo $prenume[$j] . ' ' . $nume[$j];
                if ($j < count($nume) - 1) {
                    echo ', ';
                }
            }
?>
            </a></li><br>
<?php
        }
?>
        </ol><br>
<?php
    }
?>
    </div></div>  <!-- inchid a doua coloana si "categorii" -->
