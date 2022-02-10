<?php


class blog extends db_object {

    static protected $table_name = "posts";
    static protected $db_columns = ['id', 'author_id', 'category_id', 'title', 'summary', 
    'content', 'published', 'created_at', 'updated_at', 'image_url'];

    public $id;
    public $author_id;
    public $category_id;
    public $title;
    public $summary;
    public $content;
    public $published;
    public $created_at;
    public $updated_at;
    public $image_url;
    public $user;
    public $username;
    public $joinableColumns = ['username'];

    public function __construct($values=[]) {
        $this->author_id = $values['author_id'] ?? '';
        $this->category_id = $values['category_id'] ?? '1';
        $this->title = $values['title'] ?? '';
        $this->summary = $values['summary'] ?? '';
        $this->content = $values['content'] ?? '';
        $this->published = $values['published'] ?? '0';
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->image_url = $values['image_url'] ?? '';
    }


    public static function limit4_find_published_posts() { 
        $sql = "SELECT posts.*, users.username ";
        $sql .= "FROM " . static::$table_name . " ";
        $sql .= "RIGHT JOIN users ON ";
        $sql .= "posts.author_id=users.id ";
        $sql .= "WHERE published='" . 1 . "' ";
        $sql .= "ORDER BY posts.id DESC ";
        $sql .= "LIMIT 4";
        $result = static::sql_query($sql);
        return $result;
     }

     public static function find_categories() {
         $sql = "SELECT title FROM categories";
         $result = self::$database->query($sql);
         $cats = $result->fetch_assoc();
         return $cats;
     }

     static public function find_by_post_id($id) {
        $sql = "SELECT posts.*, users.username "; 
        $sql .= "FROM " . static::$table_name . " ";
        $sql .= "RIGHT JOIN users ON ";
        $sql .= "posts.author_id=users.id ";
        $sql .= "WHERE posts.id='" . self::$database->escape_string($id) . "'";
        $result = static::sql_query($sql);
        /* Returns an object array - not needed for one result so array_shift used to get the 
        first item/result back */
        if(!empty($result)) {
            return array_shift($result);
         } else {
             return false;
         }
    }

    public static function find_posts_by_category($cat_id) { 
    $sql = "SELECT posts.*, users.username ";
    $sql .= "FROM " . static::$table_name . " ";
    $sql .= "RIGHT JOIN users ON ";
    $sql .= "posts.author_id=users.id ";
    $sql .= "WHERE published='" . 1 . "' AND ";
    $sql .= "category_id='" . self::$database->escape_string($cat_id) . "' ";
    $sql .= "ORDER BY posts.id DESC";
    $result = static::sql_query($sql);
    return $result;
    }

}



    











?>