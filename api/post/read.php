<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate schematic post object
    $post = new Post($db);

    // schematic post query
    $result = $post->read();
    //Get row count
    $num = $result->rowCount();

    // Check if post present
    if($num > 0) {
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $name,
                'desc' => $description,
                'author' => $author,
                'category' => $category,
                'download' => $id,
                'images' => $images,
                'createdAt' => $created_at,
                'version' => $version
            );

            // Push to "data"
            array_push($posts_arr['data'], $post_item);


        }

        // Turn to JSON & output
        echo json_encode($posts_arr);


    } else {
        // No posts
        echo json_encode(
            array('message' => 'No Posts Found')
        );
    }

