<?php
    class Database {
        private $host ='localhost';
        private $db_name ='myblog';
        private $username = 'root';
        private $password = '';
        private $conn;

        //conectare

        public function connect() {
            $this->conn = null;

            //conectare prin pdo la baza de date

            try {
                 $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $err) {
                echo 'eroare la conectare ' . $err->getMessage();
            }

            return $this->conn;
        }
    }