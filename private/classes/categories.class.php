<?php

class categories extends blog {

    static protected $table_name = "categories";
    static protected $db_columns = ['id', 'title', 'metaTitle', 'content'];

    public $id;
    public $title;
    public $metaTitle;
    public $content;

    public function __construct($values=[]) {
        $this->title = $values['title'] ?? '';
        $this->metaTitle = $values['metaTitle'] ?? '';
        $this->content = $values['content'] ?? '';
    }

}

?>