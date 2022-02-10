<?php

class Session {

    private $user_id;
    private $username;
    private $admin = false;

    public function __construct() {
        session_start();
        $this->session_id_check();
    }

    
  public function message($msg="") {
    if(!empty($msg)) {
      // Then this a "Set" message
      $_SESSION['message'] = $msg;
    } else {
      // then this is a get message
      return $_SESSION['message'] ?? '';
    }
  }

  public function clear_session_message() {
    unset($_SESSION['message']);
  }

public function login($user) {
    if($user) {
        session_regenerate_id();
        $_SESSION['username'] = $user->username;
        $_SESSION['user_id'] = $user->id;
        $this->user_id = $user->id;
        $this->username = $user->username;
    }
    if($user->check_admin() == true) {
        $_SESSION['admin'] = true;
        $this->admin = true;
    }
    return true;
}

    public function currently_logged_in() {
        return isset($this->user_id);
    }

    public function is_admin() {
        $this->currently_logged_in();
        if($this->admin == true) {
        return true;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['admin']);
        unset($this->admin);
        unset($this->user_id);
        unset($this->username);
        if(isset($i))
        $_SESSION = array();
        session_destroy();
        return true;
    }

    private function session_id_check() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->username = $_SESSION['username'];
            $this->admin = $_SESSION['admin'] ?? false;
            }
            
        }
    }










?>