<?php 
class Register{
	private $name;
	private $email;
	private $password;
	private $password2;
	private $encPassword;
	private $errors;

	public function __construct(){
		$this->errors = array();
		$this->name = $_POST['name'];
		$this->email = $_POST['email'];
		$this->password = $_POST['password'];
		$this->password2 = $_POST['password2'];
		# $this->encPassword = md5($this->password);
		# $this->encPassword = hash('sha256', $this->password);
		$this->encPassword = $this->password;
	}	


	public function validateData(){
		if(empty($this->name) || empty($this->email) || empty($this->password) || empty($this->password2))
		{
			$this->errors[] = "Fields cannot be empty";
		}
		if($this->emailExists())
			$this->errors[] = "Email already exists";
		if($this->emailFormatError())
			$this->errors[] = "Email format is wrong";

		if($this->password != $this->password2)
			$this->errors[] = "Passwords mismatch";

	}

	public function emailExists(){
		$db = new mysqli('localhost','root','','Library');
		$email = $db->query("SELECT email FROM Users WHERE email = '{$this->email}'");
		if($email->num_rows){
			return true;
		}
		else
			return false;
	}

	public function emailFormatError(){
		if(!filter_var($this->email,FILTER_VALIDATE_EMAIL))
			return true;
		return false;
	}

	public function register(){	
		$this->validateData();
		if(count($this->errors) == 0){
			//register user here
			$db = new mysqli('localhost','root','','Library');
			$insertUser = $db->prepare("INSERT INTO Users (email, name, password) VALUES (?,?,?)");
			$insertUser->bind_param('sss', $this->email, $this->name, $this->encPassword);
			$insertUser->execute();
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
