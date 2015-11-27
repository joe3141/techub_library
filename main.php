<?php 
if(!isset($_SESSION))
	session_start();
?>
<html>
<head>
<title>Library!!!</title>
</head>
<body>


	<?php if(!isset($_SESSION['email'])){   ?>
	<form method = "post" action="">
		<label for="email">Email: </label>
		<input type = "text" name = "email" id = "email">
		<br>
		<label for="password">Password: </label>
		<input type = "password" name = "password" id = "password">
		<br>
		<input type = "submit" value = "Login" name ="login">
	</form>

	<?php }
	//else{
		//header("Location: direct.php");}
		?>
	<form method = "post" action="">
		<label for="name">Name: </label>
		<input type ="text" name="name" id="name">
		<br>
		<label for = "email" >Email: </label>
		<input type ="text" name="email" id="email">
		<br>
		<label for="password">Password: </label>
		<input type ="password" name="password" id="password">
		<br>
		<label for="password2">Confirm Password: </label>
		<input type ="password" name="password2" id="password2">
		<br>
		<input type = "submit" name="register"  value = "Register">
	</form>

</body>

</html>



<?php 



$db  = new mysqli('localhost','root','','Library');

/*if(isset($_POST['logout'])){
	session_destroy();
	header("Location: main.php");
}*/
if(isset($_POST['register']))
{

	include('register.php');
	$r = new Register();

	if($r){ //true if $r is not null
		if($r->register())
			header("Location: succ_reg.html");
	}
}
  if (isset($_POST['login'])) {
  	$email = $_POST['email'];
	# $password = md5($_POST['password']);
	# $password = hash('sha256', $_POST['password']);
	$password = $_POST['password'];

	if(validateLogin($email,$password)){
		header("Location: direct.php");
	}
	else{
		echo 'invalid email/password';
	}
}




function validateLogin($email,$password){
	$db = new mysqli('localhost','root','','Library');
	$result = $db->query("SELECT * FROM Users WHERE email = '{$email}' && password = '{$password}'");
	if($result->num_rows){
		$result = $result->fetch_object();
		$_SESSION['name'] = $result->name;
		$_SESSION['email'] = $result->email;
		return true;
	}
	return false;
}

?>