<?php

	class Account{

		private $con;
		private $errorArray;

		public function __construct($con){
			$this->con = $con;
			$this->errorArray = array();
		}

		public function register($un , $fn , $ln, $em, $em2, $pw, $pw2){
			$this->validateUsername($un);
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em , $em2);
			$this->validatePasswords($pw , $pw2);

			if(empty($this->errorArray)){ // No error messages were inserted after checking the data.
				//Insert into DB
				return $this->insertUserDetails($un , $fn , $ln , $em , $pw);
			}
			else{
				return false;
			}
		}

		public function login($un , $pw){
			$pw = md5($pw);

			$stmt = $this->con->prepare("SELECT* FROM users where username = ? AND password = ?");
			$stmt->bind_param("ss" , $un , $pw);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows == 1){	
				return true;
			}
			else{
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function getError($error){
			if(!in_array($error, $this->errorArray)){
				$error= "";
			}
			return "<span class = 'errorMessage'>$error</span>";
		}

		private function insertUserDetails($un , $fn , $ln , $em , $pw){

			$encryptedPw = md5($pw);
			$profilePic = "Assets/Images/ProfilePictures/head_emerald.png";
			$date = date("Y-m-d");

			$stmt = $this->con->prepare("INSERT INTO users (username,firstName,lastName,email,password,signUpDate,profilePic) VALUES(?,?,?,?,?,'$date',?)");
			$stmt->bind_param("ssssss" , $un,$fn,$ln,$em,$encryptedPw,$profilePic);

			return $stmt->execute(); 
		}

		private function validateUsername($un){
			if(strlen($un) > 25 || strlen($un) < 5)
			{
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}
			//check if username exists.

			$stmt = $this->con->prepare("SELECT username FROM users where username = ?");
			$stmt->bind_param("s" , $un);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows != 0){
				array_push($this->errorArray , Constants::$usernameTaken);
				return;
			}
		}

		private function validateFirstName($fn){
			if(strlen($fn) > 25 || strlen($fn) < 2)
			{
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($ln){
			if(strlen($ln) > 25 || strlen($ln) < 2)
			{
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}
		private function validateEmails($em , $em2){
			if($em != $em2)
				{
					array_push($this->errorArray, Constants::$emailsDontMatch);
					return;
				}
			if(!filter_var($em , FILTER_VALIDATE_EMAIL)){  //checks if it's in the correct format.
					array_push($this->errorArray, Constants::$invalidEmail);
					return;
			}

			$stmt = $this->con->prepare("SELECT email FROM users where email = ?");
			$stmt->bind_param("s" , $em);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows != 0){
				array_push($this->errorArray , Constants::$emailTaken);
				return;
			}
		}
		private function validatePasswords($pw , $pw2){
			if($pw != $pw2)
				{
					array_push($this->errorArray, Constants::$passwordsDoNotMatch);
					return;
				}
			if(preg_match('/[^A-Za-z0-9]/', $pw)){
					array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
					return;
				}
			if(strlen($pw) > 30 || strlen($pw) < 5)
				{
					array_push($this->errorArray, Constants::$passwordCharacters);
					return;
				}

		}

	}
	

?>