<?php
class Book
{	
	private $name;
	private $isbn;
	private $author;
	private $email;
	private $errors;
	private $copies;
	
	function __construct()
	{
		$this->errors = array();
		$this->name = $_POST['name'];
		$this->isbn = (int) $_POST['isbn'];
		$this->author = $_POST['author'];
		$this->email = $_SESSION['email'];
		$this->copies = $_POST['copies'];
	}

	public function validateData(){
		if(empty($this->name) || empty($this->isbn) || empty($this->author))
		{
			$this->errors[] = "Fields cannot be empty";
		}
		if($this->bookExists())
			$this->errors[] = "Book already exists";
	}



	public function bookExists(){
		$db = new mysqli('localhost','root','','Library');
		$book = $db->query("SELECT b.isbn FROM Books b WHERE b.isbn = '{$this->isbn}'") or die(mysqli_error($db))	;
		if($book->num_rows){
			return true;
		}
	else{
			return false;
	}
}




public function add_book(){
		$this->validateData();
		if(count($this->errors) == 0){
			//register user here
			$db = new mysqli('localhost','root','','Library');
			$count = (int) $this->copies;
			//echo $count;
			//echo $this->isbn;
			$date = date('Y-m-d');
			$insertBook = $db->prepare("INSERT INTO Books (isbn, name, author, add_date, added_by) VALUES (?,?,?,?,?)")
			or die(mysqli_error($db));
			$insertBook->bind_param('sssss', $this->isbn, $this->name, $this->author, $date, $this->email);
			$insertBook->execute();
			for($i = 0; $i<$count; $i++){
				$insertCopy = $db->prepare("INSERT INTO Copies (isbn) VALUES (?)")or die(mysqli_error($db));
				$insertCopy->bind_param('s', $this->isbn);
				$insertCopy	->execute();
			}
			return true;
		}
		else{
			$this->showErrors();
			return false;
		}
	}

	public function showErrors(){
		foreach ($this->errors as $error) {
			echo $error.'<br>';
		}
	}
}


?>