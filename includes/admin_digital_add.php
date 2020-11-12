<div class="add_pdf">
    <div class="inputs">
    <form action="./includes/process_insertfile_form.php" method="post" id="uploadform">
        Adauga fisierul: 
        <input type="file" id="browse" name="uploadedfile"><br>
        <input type="text" id="titlu_carte" placeholder="Numele cartii" name="booktitle"><br>
        <input type="text" id="autornume" placeholder="Numele autorului" name="authorlastname"><br>
        <input type="text" id="autorprenume" placeholder="Prenumele autorului" name="authorfirstname"><br>
        <input type="text" id="filename" placeholder="Numele fisierului" name="filename"><br>
        <textarea id="descriere" placeholder="Descrierea cartii" name="description"></textarea><br>
        Categoria: 
        <?php
            require_once 'dbconnect.php';

            $mysqlconn = connectdb();
            $error = "";

            $query = "SELECT DISTINCT categorie FROM carte ORDER BY categorie";

            $categories = array();
            $options = "";

            $res = mysqli_query($mysqlconn, $query);
            while($row = mysqli_fetch_array($res)) {
                $options = $options."<option>".$row[0]."</option>";
                array_push($categories, $row[0]);
            }

            
        ?>

        <select name="categorie" id="selectcat" autocomplete="off">
            <option>--Alege--</option>
                <?php
                    echo $options;
                ?>
        </select>
        <br>
        <input type="submit" value="Incarca fisierul" id="uploadfile" class="noreset" name="uploadfile">
        <?php echo $error; ?>
    </form>
    </div>
</div>