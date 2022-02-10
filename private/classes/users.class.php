<?php

class users extends blog {

    static protected  $table_name = 'users';
    static protected  $db_columns = ['id', 'username', 'first_name', 'last_name', 'email', 
    'hashed_password', 'registered', 'is_admin'];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $registered;
    protected $is_admin;
    public $password;
    public $confirm_password;
    protected $hashed_password;

    public function __construct($values=[]) {
        $this->username = $values['username'] ?? '';
        $this->first_name = $values['first_name'] ?? '';
        $this->last_name = $values['last_name'] ?? '';
        $this->email = $values['email'] ?? '';
        $this->registered = date("Y-m-d H:i:s");    
        $this->password = $values['password'] ?? '';
        $this->confirm_password = $values['confirm_password'] ?? '';
    }

    public static function list_admins() {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE is_admin='" . 1 . "'";
        return static::sql_query($sql);
    }

    public function set_hashed_password() {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password) {
        return password_verify($password, $this->hashed_password);
    }

    public function validate_data() {
        $this->errors = [];
        
        if(empty($this->username)) {
            $this->errors[] = "Username cannot be blank";
        } elseif (strlen($this->username) < 3) {
            $this->errors[] = "Username must be more than 3 charcters";
        } elseif (strlen($this->username) > 20 ) {
            $this->errors[] = "Username cannot be more than 20 charcters";
        } elseif (has_unique_username($this->username) === false) {
            $this->errors[] = "Username cannot be used, please try another";
        }

        if(empty($this->first_name)) {
            $this->errors[] = "First name cannot be blank.";
        } elseif (strlen($this->first_name) < 3) {
            $this->errors[] = "First name must be between 2 and 20 characters.";
        } elseif (strlen($this->first_name) > 20) {
            $this->errors[] = "First name cannot be more than 20 characters.";
        }
    
        if(empty($this->last_name)) {
            $this->errors[] = "Last name cannot be blank.";
        } elseif (strlen($this->last_name) < 3) {
            $this->errors[] = "Last name must be between 2 and 255 characters.";
        } elseif (strlen($this->last_name) > 20) {
            $this->errors[] = "Last name cannot be more than 20 characters.";
        }
    
        if(empty($this->email)) {
            $this->errors[] = "Email cannot be blank.";
        } elseif (strlen($this->email) > 50) {
            $this->errors[] = "Last name must be less than 50 characters.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email must be a valid format.";
        }
    
        
        if(empty($this->password)) {
            $this->errors[] = "Password cannot be blank.";
        } elseif (strlen($this->password) < 8) {
            $this->errors[] = "Password must contain 8 or more characters";
        } elseif (!preg_match('/[A-Z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 symbol";
        }

        if(empty($this->confirm_password)) {
            $this->errors[] = "Confirm password cannot be blank.";
        } elseif ($this->password !== $this->confirm_password) {
            $this->errors[] = "Password and confirm password must match.";
        }

        return $this->errors;
    }

    static public function find_by_username($username) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
        $result = static::sql_query($sql);
        /* Returns an object array - not needed for one result so array_shift used to get the 
        first item/result back */
        if(!empty($result)) {
            return array_shift($result);
        } else {
            return false;
        }
    }    

    public function check_admin() {
        if($this->is_admin == true) {
            return true;
        } else {
            return false;
        }
    }

    public function count_users() {
        $sql = "SELECT COUNT(*) FROM " . static::$table_name . " ";
        $result = static::$database->query($sql);
        return $result;
    }
}




?>