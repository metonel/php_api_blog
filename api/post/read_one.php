<?php 
  // o sa fie accesat prin http si avem nevoie de headers
  header('Access-Control-Allow-Origin: *');//sa poata fi accesat de oricine
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';
  // instantierea si conectarea la baza de date
  $database = new Database();
  $db = $database->connect();
  // instantierea Postului
  $post = new Post($db);

  //ia id-ul din url

  $post->id = isset($_GET['id']) ? $_GET['id'] : die();

  $post->read_one();

  //array

  $post_arr = array(
      'id' => $post->id,
      'title' => $post->title,
      'body' => $post->body,
      'author' => $post->author,
      'category_id' => $post->category_id,
      'category_name' => $post->category_name
  );

  //print_r afiseaza un array
  print_r(json_encode($post_arr));