<?php

class Auth{

	private $username_cookie="intranet_auth_username";
	private $session_cookie="intranet_auth_session"; 
	private $id_cookie="intranet_auth_id";
	private $cookie_expiration="7";
	public $basepath;
	private $db;

	public function __construct($basepath, $db){
		if(session_id() == '' || !isset($_SESSION)) {
			if (isset($_COOKIE[$this->session_cookie]))
				session_id ($_COOKIE[$this->session_cookie]);
			session_start();
		}
		$this->basepath=$basepath;
		$this->db= new PDO('sqlite:'.$db);
	}
	
	public function authenticated(){
		if (isset($_COOKIE[$this->username_cookie]) &&  $this->sessionCheck()) {
			return true;
		} 
		else {
			return false;
		}
	}
	
	public function forceAuthentication() {
		if (!$this->authenticated()) {
		$this->redirectToLogin();
		}
	}

	public function getUsername() {
		if ($this->authenticated())
		return $_COOKIE[$this->username_cookie];
		return false;
	}

	public function getUid() {
		if ($this->authenticated())
		return $_COOKIE[$this->id_cookie];
		return false;
	}

	private function sessionCheck(){
		if(session_id() == '' || !isset($_SESSION) || !isset($_SESSION['address'])) return false;
		return ($_SESSION['address']==$_SERVER['REMOTE_ADDR'] && $_SESSION['username']==$_COOKIE[$this->username_cookie] );
	}

	public function logout() {
			setcookie($this->username_cookie, "", time() - 3600, "/");
			setcookie($this->session_cookie, "", time() - 3600, "/");
			setcookie($this->id_cookie, "", time() - 3600, "/");
			$_SESSION = array();
			session_destroy();
			$this->redirectToLogin($url);
	}
	private function redirectToLogin() {
		$oldloc=$_SERVER['REQUEST_URI'];
		$locstr = "Location: ".$this->basepath."/login.php?l=".urlencode($oldloc);
		header($locstr);
		exit;
	}
	public function login($username, $password) {
		$logged_in=$this->loginAction($username, $password);
	   
		if ($logged_in) {
			$_SESSION['address']=$_SERVER['REMOTE_ADDR'];
			$_SESSION['username']=$username;
			//set the cookie, 86400=24*24*60
			setcookie($this->username_cookie, $username, time() + 86400 * $this->cookie_expiration, $this->basepath);
			setcookie($this->session_cookie, session_id(), time() + 86400 * $this->cookie_expiration, $this->basepath);
			setcookie($this->id_cookie, $logged_in, time() + 86400 * $this->cookie_expiration, $this->basepath);
		} else {
			// unset session and cookie
			$_SESSION = array();
			session_destroy();
			setcookie($this->username_cookie, "", time() - 3600, "/");
			setcookie($this->session_cookie, "", time() - 3600, "/");
			setcookie($this->id_cookie, "", time() - 3600, "/");
		}
		return $logged_in;
	}

	public function loginAction($username, $password) {
		$pdo=$this->db->query("SELECT * FROM user WHERE username = '$username'");
		$user=$pdo->fetch();
		if($user==false) return -1;
		$password = md5($password);
		if($password === $user['password']){ 
			$logged_in = $user['id'];
		} else {
			$logged_in = false;
		}
		var_dump($logged_in);
		return $logged_in;
	}	
	
	public function getUsernameById($id){
		$pdo=$this->db->query("SELECT * FROM user WHERE id = '$id'");
		$user=$pdo->fetch();
		if($user)
		return $user['username'];
	}
	
	public function pswCheck($password){
		return $this->loginAction($this->getUsername(), $password);
	}

	public function getEventsByUser($id){
		$pdo=$this->db->query("SELECT event.id AS id, event.name AS name FROM gr_user,event WHERE  gr_user.event_id=event.id AND  gr_user.user_id=$id");
		$events=$pdo->fetchAll();
		return $events;
	}

	public function setEvent($id,$event_id){
		$pdo=$this->db->query("SELECT name FROM event WHERE id=$event_id ");
		$event = $pdo->fetch();
		$_SESSION['event_id']=$event_id;
		$_SESSION['event_name']=$event['name'];

		return $event['name'];
	}
}
?>
