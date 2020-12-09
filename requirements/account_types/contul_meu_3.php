<!-- introducere -->
<div class="dreapta">
    <div class="info formular_admin">  

      <form action="requirements/admin/admin_insert.php" method="post" id="insert_form" class="admin_form">
          <h3>Selecteaza tabelul in care vrei sa introduci date:</h3>
          <select name="table_select_insert" id="table_select_insert" class="admin_select">
            <option value="0">--Alege--</option>
            <option value="Autor">Autor</option>
            <option value="Carte">Carte</option>
            <option value="Coduri_utilizatori">Coduri_utilizatori</option>
          </select>
      
          <input type="submit" name="admin_insert" id="submit_insert" value="Insereaza" class="admin_submit">
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
          $_SESSION['admin_insert_err'] = '';
?>
          </p>          
          <p style="color: rgb(0, 164, 33); font-weight: bold;">
<?php
          echo $_SESSION['admin_insert'];
          $_SESSION['admin_insert'] = '';
?>
          </p>
      </form>

    </div>
</div>

<!-- actualizare -->
<div class="dreapta">
    <div class="info formular_admin">    
      <form action="requirements/admin/admin_update.php" method="post" id="update_form" class="admin_form">
          <h3>Selecteaza tabelul in care vrei sa modifici date:</h3>
          <select name="table_select_update" id="table_select_update" class="admin_select">
            <option value="0">--Alege--</option>
            <option value="Carte">Carte</option>
          </select>
      
          <input type="submit" name="admin_update" id="submit_update" value="Actualizeaza" class="admin_submit">

<?php
          if (!isset($_SESSION['admin_update_err'])) {
            $_SESSION['admin_update_err'] = '';
          }
          if (!isset($_SESSION['admin_update'])) {
            $_SESSION['admin_update'] = '';
          }
?>
          <p style="color: red; font-weight: bold;">
<?php
          echo $_SESSION['admin_update_err'];
          $_SESSION['admin_update_err'] = '';
?>
          </p>
          <p style="color: rgb(0, 164, 33); font-weight: bold;">
<?php
          echo $_SESSION['admin_update'];
          $_SESSION['admin_update'] = '';
?>
          </p>
        </form>
    </div>
</div>

<!-- stergere -->
<div class="dreapta">    
    <div class="info formular_admin">    
        <form action="requirements/admin/admin_delete.php" method="post" id="delete_form" class="admin_form">
            <h3>Selecteaza tabelul din care vrei sa stergi date:</h3>
            <select name="table_select_delete" id="table_select_delete" class="admin_select">
              <option value="0">--Alege--</option>
              <option value="Autor">Autor</option>
              <option value="Carte">Carte</option>
            </select>
      
            <input type="submit" name="admin_delete" id="submit_delete" value="Sterge" class="admin_submit">

<?php
          if (!isset($_SESSION['admin_delete_err'])) {
            $_SESSION['admin_delete_err'] = '';
          }
          if (!isset($_SESSION['admin_delete'])) {
            $_SESSION['admin_delete'] = '';
          }
?>
          <p style="color: red; font-weight: bold;">
<?php
          echo $_SESSION['admin_delete_err'];
          $_SESSION['admin_delete_err'] = '';
?>
          </p>          
          <p style="color: rgb(0, 164, 33); font-weight: bold;">
<?php
          echo $_SESSION['admin_delete'];
          $_SESSION['admin_delete'] = '';
?>
          </p>
        </form>
  </div>
</div>
