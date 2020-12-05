<?php include('reset_password.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="../../css/main.css">
</head>

<body>

	<form class="login-form" action="../../login.php" method="post" style="text-align: center;">
		<p>
			Am trimis un email catre <b><?php echo $_GET['email'] ?></b> pentru a te ajuta sa iti recuperezi parola. 
		</p>
	    <p>Te rugam autentifica-te in contul de email si acceseaza link-ul pe care ti l-am trimis pentru a-ti reseta parola.</p>
	</form>
		
</body>
</html>