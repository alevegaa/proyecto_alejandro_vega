<?php

class bdconexion{

    static public function conexion(){
        $servername = "localhost";
        $database = "proyecto_alejandro";
        $username = "root";
        $password = "";
        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
        mysqli_close($conn);
        
    }
}

?>