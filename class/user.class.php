<?php 
	include "db_config.php";
	class User{
		protected $db;
		public function __construct(){
			$this->db = new DB_con();
			$this->db = $this->db->ret_obj();
		}
		
		/*** for registration process ***/
		
		public function reg_user($firstname, $lastname, $address, $phonenumber, $email, $username, $password){
			//echo "k";
			
			$password = md5($password);
		


			//checking if the username or email is available in db
			$query = "SELECT * FROM user_detail WHERE username='$username' OR email='$email'";
			
			$result = $this->db->query($query) or die($this->db->error);
			
			$count_row = $result->num_rows;
			
			//if the username is not in db then insert to the table
			
			if($count_row == 0){
				$query = "INSERT INTO user_detail SET firstname='$firstname', lastname='$lastname', address='$address', phonenumber='$phonenumber', email='$email', username='$username', password='$password'";
				
				$result = $this->db->query($query) or die($this->db->error);
				
				return true;
			}
			else{return false;}
			
			
			}
			
			
	/*** for login process ***/
		public function check_login($emailusername, $password){
        $password = md5($password);
		
		$query = "SELECT id from user_detail WHERE email='$emailusername' or username='$emailusername' and password='$password'";
		
		$result = $this->db->query($query) or die($this->db->error);

		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		$count_row = $result->num_rows;
		
		if ($count_row == 1) {
	            $_SESSION['login'] = true; // this login var will use for the session thing
	            $_SESSION['id'] = $user_data['id'];
	            return true;
	        }
			
		else{return false;}
		

	}
	
	
	public function get_fullname($id){
		$query = "SELECT firstname FROM user_detail WHERE id = $id";
		
		$result = $this->db->query($query) or die($this->db->error);
		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		echo $user_data['firstname'];
		
	}
	
	/*** starting the session ***/
	public function get_session(){
	    return $_SESSION['login'];
	    }

	public function user_logout() {
	    $_SESSION['login'] = FALSE;
		unset($_SESSION);
	    session_destroy();
	    }
	
	
	
	
	
	
	
	
	
}