<?php
  // o sa fie accesat prin http si avem nevoie de headers
  header('Access-Control-Allow-Origin: *');//sa poata fi accesat de oricine
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Heders: Access-Control-Allow-Heders, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';
  // instantierea si conectarea la baza de date
  $database = new Database();
  $db = $database->connect();
  // instantierea Postului
  $post = new Post($db);

  //raw posted data

  $data = json_decode(file_get_contents('php://input'));
  
  //id-ul postarii ce va fi uptat-ata
  $post->id = $data->id;

  $post->title = $data->title;
  $post->body = $data->body;
  $post->author = $data->author;
  $post->category_id = $data->category_id;

  if($post->update()) {
    echo json_encode(array('message' => 'Post modificat'));
  } else {
    echo json_encode(array('message' => 'Postul nu a fost modificat'));
  }