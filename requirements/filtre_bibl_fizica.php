<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h3>
<?php
    if (isset($_SESSION['my_filter']) && $_SESSION['my_filter'] != '') {
        echo "Filtru suplimentar: '" . $_SESSION['my_filter'] . "'";
    }
?>
    </h3>
    <div class="filtru">
        <div class="header">
            <h3>Autor</h3>
        </div>

        <div class="options">
<?php
        $query = "SELECT DISTINCT prenume, nume 
                    FROM autor
                    JOIN carte_autor USING (id_autor)
                    JOIN carte USING (id_carte)
                    WHERE tip = 'fizica'";
        $res = mysqli_query($link, $query);

        $checkbox = array();
        while ($row = mysqli_fetch_array($res)) {
            array_push($checkbox, $row[0] . ' ' . $row[1]);
        }

        for ($i = 0; $i < count($checkbox); $i++) {
?>
            <input type="checkbox" name="autor[]" value="<?php echo $checkbox[$i]; ?>"
<?php
            echo check_filters($checkbox[$i]);
?>     
            >
            <label for="autor[]">
<?php 
            echo $checkbox[$i]; 
?>
            </label>  
            <br>
<?php
        }
?>
        </div>      <!-- end options -->
    </div><!-- end filtru -->
    
    <br>

    <div class="filtru">
        <div class="header">
            <h3>Categorie</h3>
        </div>

        <div class="options">
<?php
        $query = "SELECT DISTINCT categorie 
                    FROM categorie
                    JOIN carte USING (id_categorie)
                    WHERE tip = 'fizica'";
        $res = mysqli_query($link, $query);

        $checkbox = array();

        while($row = mysqli_fetch_array($res)) {
            array_push($checkbox, $row[0]);
        }

        for ($i = 0; $i < count($checkbox); $i++) {
?>
            <input type="checkbox" name="categorie[]" value="<?php echo $checkbox[$i]; ?>"
<?php
            echo check_filters($checkbox[$i]);
?> 
            >
            <label for="categorie[]">
<?php 
            echo $checkbox[$i]; 
?>
            </label>
            <br>
<?php
        }
?>
        </div><!-- end options -->
    </div><!-- end filtru -->

    <br>

    <div class="filtru">
        <div class="header">
            <h3>Anul publicarii</h3>
        </div>

        <div class="options">
<?php
        $query = "SELECT DISTINCT an FROM carte WHERE tip='fizica' ORDER BY an";
        $res = mysqli_query($link, $query);

        $checkbox = array();

        while($row = mysqli_fetch_array($res)) {
            array_push($checkbox, $row[0]);
        }

        $_SESSION['nranfiltru'] = count($checkbox);

        for ($i = 0; $i < count($checkbox); $i++) {
?>
            <input type="checkbox" name="an[]" value="<?php echo $checkbox[$i];?>"
<?php
            echo check_filters($checkbox[$i]);
?> 
            >
            <label for="an[]">
<?php 
            echo $checkbox[$i];?>
            </label>
            <br>
<?php
        }
?>
        </div><!-- end options -->
    </div><!-- end filtru -->

    <br>

    <div class="filtru">
        <div class="header">
            <h3>Editura</h3>
        </div>

        <div class="options">
<?php
        $query = "SELECT DISTINCT editura FROM carte WHERE tip='fizica' ORDER BY editura";
        $res = mysqli_query($link, $query);

        $checkbox = array();

        while($row = mysqli_fetch_array($res)) {
            array_push($checkbox, $row[0]);
        }

        $_SESSION['nrediturafiltru'] = count($checkbox);

        for ($i = 0; $i < count($checkbox); $i++) {
?>
            <input type="checkbox" name="editura[]" value="<?php echo $checkbox[$i]; ?>"
<?php
            echo check_filters($checkbox[$i]);
?> 
            >
            <label for="editura[]">
<?php 
            echo $checkbox[$i]; 
?>
            </label>
            <br>
<?php
        }
?>
    
        </div><!-- end options -->
    </div><!-- end filtru -->

    <br>
    
    <input type="submit" name="cauta" value="Cauta" class="cauta">
</form>