<div class="dreapta">
    <div class="info formular_admin">    <!-- introducere -->

      <form action="requirements/admin/admin_insert.php" method="post" id="insert_form">
          <h3>Selecteaza tabelul in care vrei sa introduci date:</h3>
          <select name="table_select" id="table_select">
            <option value="0">--Alege--</option>
            <option value="Autor">Autor</option>
            <option value="Carte">Carte</option>
            <option value="Coduri_utilizatori">Coduri_utilizatori</option>
          </select>
      
          <input type="submit" name="admin_insert" id="submit_insert" value="Insereaza">
<?php
          if (!isset($_SESSION['admin_insert_err'])) {
            $_SESSION['admin_insert_err'] = '';
          }
          if (!isset($_SESSION['admin_insert'])) {
            $_SESSION['admin_insert'] = '';
          }
?>
          <p style="color: red; font-weight: bold;">
<?php
          echo $_SESSION['admin_insert_err'];
?>
          </p>          
          <p style="color: rgb(0, 164, 33); font-weight: bold;">
<?php
          echo $_SESSION['admin_insert'];
?>
          </p>
      </form>

    </div>
</div>

<div class="dreapta">
    <div class="info">    <!-- actualizare -->

    
    </div>
</div>

<div class="dreapta">    
  <div class="info">    <!-- stergere -->

  </div>
</div>
