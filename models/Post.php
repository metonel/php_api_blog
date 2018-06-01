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
}