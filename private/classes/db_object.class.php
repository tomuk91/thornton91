<?php


class db_object {

    static protected $database;
    static protected $table_name = "";
    static protected $columns = [];
    public $errors = [];

    

    static public function setDatabase($database) {
        self::$database = $database;
    }

    static public function sql_query($sql) {
        $result = self::$database->query($sql); 
        if(!$result) {
            echo static::$database->error;
            exit("Failed to query the database correctly.");
        }

        $object_array = [];
        while($record = $result->fetch_assoc()) {
            $object_array[] = static::instantiate($record);
        }

        $result->free();

        return $object_array;
    }

    static public function search_sql() { 
       $sql = "SELECT * FROM " . static::$table_name;
       return static::sql_query($sql);
    }

    static protected function instantiate($record) {
        $object = new static;
        foreach($record as $property => $value) {
            if(property_exists($object, $property)) {
                $object->$property = $value;
            }
         }
        return $object;
    }

    static public function find_all_data() {
        $sql = "SELECT * FROM " . static::$table_name;
        return static::sql_query($sql);
    }

    static public function count_all_data() {
        $sql = "SELECT COUNT(*) FROM " . static::$table_name;
        $result = self::$database->query($sql);
        $row = $result->fetch_array();
        return array_shift($row);
    }

    static public function count_by_cat_id($id) {
        $sql = "SELECT COUNT(*) FROM posts ";
        $sql .= "WHERE category_id='" . self::$database->escape_string($id) . "'";
        $result = self::$database->query($sql);
        $row = $result->fetch_array();
        return array_shift($row);
    }

    static public function find_by_id($id) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
        $result = static::sql_query($sql);
        /* Returns an object array - not needed for one result so array_shift used to get the 
        first item/result back */
        if(!empty($result)) {
            return array_shift($result);
         } else {
             return false;
         }
    }

    protected function validate_data() {
        $this->errors = [];
    
        return $this->errors;
    }

    public function attributes() {
        $attributes = [];
        foreach(static::$db_columns as $column) {
            if($column == 'id') { continue; }
            $attributes[$column] = static::$database->escape_string($this->$column);
            /* $attributes key is name of the column then assigning a value by using the name of column to target
            class properties */
        }
        return $attributes;
    }

    public function update() {
        $attributes = $this->attributes();
        $attribute_pairs = [];
        foreach($attributes as $key => $value) {
        $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(', ', $attribute_pairs);
        $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
    }

    public function save() {
        if(isset($this->id)) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    public function merge_object_values($values=[]) {
        foreach($values as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
      }

    public function delete() {
        $sql = "DELETE FROM " . static::$table_name . " ";
        $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
    }

    public function create() {
        $this->validate_data();
        if(!empty($this->errors)) { return false; }
        
        $attributes = $this->attributes();
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= implode(', ', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= implode("', '", array_values($attributes));
        $sql .= "')";
        $result = self::$database->query($sql);
        return $result;
        if($result) {
            $this->id = $self::$database->insert_id;
        }
    }
   
}



?>