<?php


class comments extends db_object {

    static protected $table_name = "comments";
    static protected $db_columns = ['id', 'user_id', 'post_id', 'content', 'created_at'];

    public $id;
    public $user_id;
    public $post_id;
    public $content;
    public $created_at;
    public $username;

    public function __construct($values=[]) {
        $this->user_id = $values['user_id'] ?? '';
        $this->post_id = $values['post_id'] ?? '';
        $this->content = $values['content'] ?? '';
        $this->created_at = date("Y-m-d H:i:s") ?? '';
    }


    public static function find_comments($post_id) {
        $sql = "SELECT comments.*, users.username ";
        $sql .= "FROM " . static::$table_name . " ";
        $sql .= "RIGHT JOIN users ON ";
        $sql .= "comments.user_id=users.id ";
        $sql .= "WHERE post_id='" . self::$database->escape_string($post_id) . "' ";
        $sql .= "ORDER BY comments.id DESC";
        $result = static::sql_query($sql);
        return $result;
    }



}