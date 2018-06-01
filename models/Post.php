<?php
class Post {
    //pt baza de date
    private $conn;
    private $table = 'posts';
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //cititu posturilor

    public function read() {
        //folosim alias-uri, p si c, care le definim dupa
        $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM 
                    ' . $this->table . ' p
                    LEFT JOIN
                        categories as c ON p.category_id = c.id
                    ORDER BY
                        p.created_at DESC
                ';
    //prepared statement, $stmt ii conventia pt statement
    $stmt = $this->conn->prepare($query);
    //executarea quer-iului
    $stmt->execute();

    return $stmt; 

    }
    //citirea unui post

    public function read_one(){
        $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM 
                    ' . $this->table . ' p
                    LEFT JOIN
                        categories as c ON p.category_id = c.id
                    WHERE
                        p.id =?
                    LIMIT 0,1
                '; //? ii positional, :id ae fi fost named parameter
        $stmt = $this->conn->prepare($query);

        //bind id-ul

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        
    }

    //crearea unui post

    public function create() {
        $query = 'INSERT INTO ' . 
            $this->table . '
          SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';
  
        $stmt = $this->conn->prepare($query);

        //curatarea datelor
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //legatu datelor
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        if($stmt->execute()) {
            return true;
        } else {
            // am setat error mode exception sa putem trimite erori
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

    }
//update post

public function update() {
    // Create query
    $query = 'UPDATE ' . 
        $this->table . '
      SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
      WHERE
        id = :id';//puteam folosi si ? in loc de :id

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
        return true;
    } else {
        // am setat error mode exception sa putem trimite erori
        printf('Error: %s.\n', $stmt->error);
        return false;
    }
  }

  public function delete() {
      //$query = 'DELETE FROM ' . $this->table . 'WHERE id = :id';
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $stmt->bindParam(':id', $this->id);

      if($stmt->execute()) {
        return true;
    } else {
        // am setat error mode exception sa putem trimite erori
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

  }
    
}