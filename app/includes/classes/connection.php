<?php
class connection
{

    public function con()
    {
        $dsn = "mysql:host=localhost;dbname=chatapp";
        $user = "root";
        $pass = "";
        try {
            $db = new PDO($dsn, $user, $pass);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
