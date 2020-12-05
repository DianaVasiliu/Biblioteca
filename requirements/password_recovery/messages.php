<?php  

  if (isset($errors) && count($errors) > 0) { 

?>

  <div class="msg">
    <?php foreach ($errors as $error) { ?>
      
      <span><?php echo $error ?></span>
      
    <?php } ?>
    
  </div>

<?php  } ?>