<?php

class dBase {
    protected function connect() {
        try {
            $host = "localhost";
            $user = "root";
            $password = "";
            $dbName = "alegriya2";
            $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }
}
