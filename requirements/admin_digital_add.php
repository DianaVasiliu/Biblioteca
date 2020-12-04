<div class="add_pdf">
    <div class="inputs">
    <form action="./requirements/process_insertfile_form.php" method="post" id="uploadform">
        <h2>Adauga un fisier: </h2>
        <input type="text" id="titlu_carte" placeholder="Numele cartii" name="booktitle"><br>
        <input type="text" id="autornume" placeholder="Numele autorilor (separate prin ',')" name="authornames"><br>
        <input type="text" id="filename" placeholder="Calea fisierului" name="filename"><br>
        <textarea id="descriere" placeholder="Descrierea cartii" name="description"></textarea><br>
        Categoria: 
        <?php
            require_once 'dbconnect.php';

            $mysqlconn = connectdb();
            $error = "";

            $query = "SELECT DISTINCT categorie FROM categorie ORDER BY categorie";
            $res = mysqli_query($mysqlconn, $query);

            $categories = array();

        ?>

        <select name="categorie" id="selectcat" autocomplete="off">
            <option>--Alege--</option>

        <?php
            while($row = mysqli_fetch_array($res)) {
        ?>
            <option> <?php echo $row[0]; ?> </option>
        <?php
                array_push($categories, $row[0]);
            }
        ?>
        </select>
        <br>
        <input type="submit" value="Incarca fisierul" id="uploadfile" class="noreset" name="uploadfile">
        <?php echo $error; ?>
    </form>
    </div>
</div>