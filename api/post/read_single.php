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

    // Get id from URL
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get post

    $post->read_single();

    // Create array

    $post_arr = array(
        'id' => $post->id,
        'title' => $post->name,
        'desc' => $post->desc,
        'author' => $post->author,
        'category' => $post->category,
        'download' => $post->id,
        'images' => $post->images,
        'createdAt' => $post->createdAt,
        'version' => $post->version
    );

    // Create JSON
    print_r(json_encode($post_arr));