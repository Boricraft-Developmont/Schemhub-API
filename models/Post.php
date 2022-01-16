<?php
    include_once '../config/getAuthor.php';


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

    // Get single post
    public function read_single() {
        // Query
        $query = 'SELECT
            p.category,
            p.id,
            p.name,
            p.description,
            p.author,
            p.images,
            p.version,
            p.created_at,
            p.edited_at
            FROM ' . $this->table . ' p 
            WHERE p.id = ?
            LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(1, $this->id);

        // Execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set props
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->desc = $row['description'];
        $this->author = $row['author'];
        $this->category = $row['category'];
        $this->download = $row['id'];
        $this->images = $row['images'];
        $this->createdAt = $row['created_at'];
        $this->version = $row['version'];

        
    }

    // Create Post
    public function createBase(){
        require('../../config/getAuthor.php');

        //Get token
        $headers = apache_request_headers();
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET author = :author';
           
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags(getAuthor($headers['token'])));
        //check for user
        if($this->author == false) {
            return false;
        }else{
            // Bind data
            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }else{

                printf("Error: %s.\n", $stmt->error);
                
                return false;
            }
        }
    }


    public function create(){
        require('../../config/getAuthor.php');

        //Get token
        $headers = apache_request_headers();
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET name = :name, description = :desc, category = :category, version = :version, images = :images WHERE id = :id AND author = :author';
           
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->author = htmlspecialchars(strip_tags(getAuthor($headers['token'])));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->version = htmlspecialchars(strip_tags($this->version));
        $this->images = htmlspecialchars(strip_tags($this->images));

        if($this->author == false){
            return false;
        }else{

            // Bind data

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':desc', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':version', $this->version);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }else{

                printf("Error: %s.\n", $stmt->error);
                
                return false;
            }
        }
    }

    public function delete(){
        require('../../config/getAuthor.php');

        //Get token
        $headers = apache_request_headers();
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id AND author = :author';
           
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags(getAuthor($headers['token'])));

        if($this->author == false){
            return false;
        }else{

            // Bind data

            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }else{

                printf("Error: %s.\n", $stmt->error);
                
                return false;
            }
        }
    }
}