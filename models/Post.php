<?php
class Post {
    // DB stuff
    private $conn;
    private $table = 'schematics';

    // Post Properties
    public $id;
    public $name;
    public $description;
    public $category;
    public $version;
    public $download;
    public $images;
    public $author;
    public $created_at;
    public $edited_at;



    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts
    public function read() {
        //Create query
        $query = 'SELECT
                p.category,
                p.id,
                p.name,
                p.description,
                p.author,
                p.download,
                p.images,
                p.version,
                p.created_at,
                p.edited_at
                FROM ' . $this->table . ' p 
                ORDER BY
                p.created_at DESC';

                
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Execute
        $stmt->execute();

        return $stmt;

    }
}