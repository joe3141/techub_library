<?php
	if(!isset($_SESSION))
	session_start();	
?>

<form method = "post" action="">
		<label for="name">Name: </label>
		<input type ="text" name="name" id="name">
		<br>
		<label for = "isbn" >isbn: </label>
		<input type ="text" name="isbn" id="isbn">
		<br>
		<label for="author">author: </label>
		<input type ="text" name="author" id="author">
		<br>
		<label for= "copies">Number of copies: </label>
		<input type="text" name="copies" id="copies">
		<br>
		<input type = "submit" name="add"  value = "Add">
	</form>

	<h4>Back to <a href="direct.php"> books</a>.</h4>

<?php

if(isset($_POST['add'])){

	include('book.php');
	$r = new Book();

	if($r){ //true if $r is not null
		if($r->add_book())
			echo "<p> Book Added </p>";
	}
}



?>