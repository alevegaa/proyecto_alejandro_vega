<?php
require_once 'BD.php';

Class Token {

    private $conexion;

    public function __construct() {
        
        $this->conexion = bdconexion::conexion(); //ejecutamos la conexión con la base de datos
    }

    private function generartoken() {
        return bin2hex(random_bytes(24)); //generamos el token de 24 caracteres 
    }

    public function insertartokenbd($id_usuario) {
        
        $duracion_token = 24 * 60 * 60; //la duración del token será de un día
        $token = $this->generartoken();
        $expiracion_token= date('Y-m-d H:i:s', time() + $duracion_token);
    
        $sql = "INSERT INTO t_token (token, fecha_expiracion, id_usuario) VALUES (?, ?, ?)"; //escribimos la sentencia sql
        $statement = $this->conexion->prepare($sql);
        $statement->bind_param("sss", $token, $expiracion_token, $id_usuario); //vinculamos los parámetros para ejecutar la sentencia
        $statement->execute();
    }

    public function verificarToken($id_usuario) {

        $current_time = date('Y-m-d');
        $query = "SELECT * FROM t_token WHERE id_usuario = ? ORDER BY fecha_expiracion DESC LIMIT 1";
        
        $statement = $this->conexion->prepare($query);
        $statement->bind_param("i", $id_usuario);
        $statement->execute();
        
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $token = $row['token'];
            $expiracion = $row['fecha_expiracion'];
            
            if ($expiracion > $current_time) {
                return true;
            } else {
                echo "token expirado.";
                return false;
            }
            
        } else {
            echo "No hay tokens";
            return false;
        }
    }

    public function eliminarToken($token) {

        $query = "DELETE FROM t_token WHERE token = ?";
        
        $statement = $this->conexion->prepare($query);
        $statement->bind_param("s", $token);
        $statement->execute();
    }
}

class Loginmodelo {

    private $conn;

    public function validarCredenciales($usuario, $clave) {
        
        $this->conn = bdconexion::conexion();

            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $sql = "SELECT * FROM t_usuarios WHERE nombre = ? AND clave = ?"; //escribimos la sentencia sql
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $usuario, $clave); //vinculamos los parámetros
            $stmt->execute(); //ejecutamos la sentencia sql
            $resultado = $stmt->get_result(); //obtenemos el resultado que leeremos para posteriormente crear el token
        
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();//Con el fetch_assoc() podemos acceder a los datos de la fila por el nombre de la columna
                $id_usuario = $fila['id'];    
                $token = new Token(); //creamos un nuevo token, puesto que el inicio de sesión ha sido exitoso
                $token->insertartokenbd($id_usuario); //lo insertamos en la base de datos, en la tabla token, con el id del usuario asociado
                $dato = "true";
                session_start();
                $_SESSION['id_usuario'] = $id_usuario;
                echo json_encode($dato);

            } else{
                $dato = "false";
                echo json_encode($dato);
            }
    }

    public function cerrarsesion() {
        session_start();
        session_unset();
        session_destroy();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/loginmodelo.php') {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $login = new Loginmodelo();
        $login->validarCredenciales($usuario, $clave);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/loginmodelo.php') {
        $logout = new Loginmodelo();
        $logout->cerrarsesion();
    }
}
?>