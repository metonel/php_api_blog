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
  $result = $post->read();
  $num = $result->rowCount();
  if($num > 0) {
    $posts_arr = array();
    //facem un obiect data in care o sa fie postarile, in caz ca vrem sa facem ulterior si alte informatii, precum paginare, versiune, etc (cum sa si api-ul din laravel)
    $posts_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);//folosind extract vom avea acces la atributele obiectului
      $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),//body-ul poate avea html
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name
      );
      // //punem in 'data'
      array_push($posts_arr['data'], $post_item);
    }
    // transformam array-ul php in json
    echo json_encode($posts_arr);
  } else {
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }