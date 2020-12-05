<?php
  include('reset_password.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resetare parola</title>
	<link rel="stylesheet" href="../../css/main.css">
</head>

<body>
	<form class="login-form" action="new_pass.php" method="post">
    <h2 class="form-title">Resetare parola</h2>
    
		<!-- form validation messages -->
    <?php include('messages.php'); ?>
    
		<div class="form-group">
			<label>Parola noua</label>
			<input type="password" name="new_pass">
    </div>
    
		<div class="form-group">
			<label>Confirma parola noua</label>
			<input type="password" name="new_pass_c">
    </div>
    
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
    </div>
    
  </form>
  
</body>
</html>