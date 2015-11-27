<?php
	if(!isset($_SESSION))
	session_start();
	echo 'Hello'.' '.$_SESSION['name'];
?>

<h3><a href = "add_book.php">Add a book</a></h3>
<br>
<form method = "post" action="">
			<input type = "submit" value = "Logout" name ="logout">
		</form>
<br><br>

<h3>Available books</h3>
<br>
<?php

if(isset($_POST['logout'])){
	session_destroy();
	header("Location: main.php");
}


$db = new mysqli('localhost','root','','Library') or die(mysqli_error($db));
//$available = mysql_query("SELECT DISTINCT c.isbn, b.name, b.author FROM Books b, Copies c WHERE b.isbn = c.isbn AND 
//	c.id NOT IN (SELECT bo.c_id FROM Borrows )  ");

$available = $db->query("SELECT DISTINCT c.isbn, b.name, b.author, c.id FROM Books b, Copies c WHERE b.isbn = c.isbn AND c.borrower is null") 
or die(mysqli_error($db));

if (mysqli_num_rows($available) > 0) {
?>
<form method = "get" action="">
<table>
<?php
while ($row = mysqli_fetch_assoc($available)) {
	$is = $row['id'];
	?>
	<tr><td><input type="checkbox" name="book[]" id="book" value=" <?php echo $is; ?>"></td> 
	<?php echo "<td>" . $row['name'] . "</td><td>" . $row['isbn'] . "</td><td>" .$row['author']. "</td></tr>";
}?>
</table>
<input type = "submit" value = "borrow" name ="borrow">
</form>
<?php
}else{
	echo "<h4> No available books</h4>";
}

echo "<br> <br>";
echo "<h3> Borrowed Books</h3>";




$borrowed = $db->query("SELECT DISTINCT c.isbn, b.name, b.author, c.id FROM Books b, Copies c WHERE b.isbn = c.isbn AND c.borrower 
	is not null")
 or die(mysqli_error($db));


if (mysqli_num_rows($borrowed) > 0) {

?>
<form method = "get" action="">
<table>
<?php
while ($row = mysqli_fetch_assoc($borrowed)) {
	$is = $row['id'];?>
	<tr><td><input type="checkbox" name="book[]" id="book" value=" <?php echo $is; ?>"></td> 
	<?php echo "<tr><td>" . $row['name'] . "</td><td>" . $row['isbn'] . "</td><td>" .$row['author']. "</td></tr>";
}?>

</table>
<input type = "submit" value = "return" name ="return">
</form>
<?php
}else{
	echo "<h4>No Borrowed Books";
}

if(isset($_GET['borrow'])){

	$arr = $_GET['book'];
	foreach ($arr as $item) {
		$val = substr($item, 1);
		$email = $_SESSION['email'];
		$db->query("UPDATE Copies SET borrower = '{$email}' WHERE id = '{$item}'")
		or die(mysqli_error($db));
		header("Location: direct.php");
	}
}


if(isset($_GET['return'])){

	$arr = $_GET['book'];
	foreach ($arr as $item) {
		$val = substr($item, 1);
		$email = $_SESSION['email'];
		$db->query("UPDATE Copies SET borrower = null WHERE id = '{$item}' AND borrower = '{$email}'")
		or die(mysqli_error($db));
		header("Location: direct.php");
	}
}

?>

