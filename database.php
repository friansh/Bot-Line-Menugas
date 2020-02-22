<?php

class Database{
    private static $conn,
        $host = 'localhost',
        $user = 'root',
        $password = '',
        $database = '';

    public static function prepare($host, $user, $password, $database){
        self::$host = $host;
        self::$user = $user;
        self::$password = $password;
        self::$database = $database;
    }

    public static function connect(){
        $conn = new mysqli(self::$host, self::$user, self::$password, self::$database);
        if ($conn->connect_error) {
            echo "<h3>Connect failed: " . $conn->connect_errno . "</h3><br>";
            exit();
        }
        self::$conn = $conn;
        return true;
    }

    public function query($query, bool $multi=false){
        $result = self::$conn->query($query);
        if ( !is_bool($result) and !is_array($result)){
            if ( $multi == true ){
                $rows = [];
                while( $row = mysqli_fetch_assoc($result) ){
                    $rows[] = $row;
                }
                return $rows;
            } else return mysqli_fetch_assoc($result);
        }
        return $result;
    }

    public function query_arr($query){
        $result = self::$conn->query($query);
        if ( !is_bool($result) and !is_array($result)){
            $rows = [];
            while( $row = mysqli_fetch_array($result) ){
                $rows[] = $row[0];
            }
            return $rows;
        }
        return $result;
    }

}