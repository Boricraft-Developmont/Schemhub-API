<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,X-Requested-With,token');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate schematic post object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $postid = $post->createBase();
    if($postid > 0) {
        echo json_encode(
            array(
                'message' => 'Post Created',
                'id' => $postid
            )
        );
    }else{
        echo json_encode(
            array('message' => 'Post not Created')
        );
    }
