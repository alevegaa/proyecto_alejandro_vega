<?php
require_once 'loginmodelo.php';

class LoginController {
    private $model;

    public function __construct($conn) {
        $this->model = new Loginmodelo($conn);
    }

    public function login($username, $password) {
        // Validar datos para prevenir SQL injection
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        $usuarioValido = $this->model->validarCredenciales($username, $password);
        if ($usuarioValido) {
            // Autenticación exitosa
            $token = $this->model->crearToken($username);
            echo $token;
        } else {
            // Usuario o contraseña incorrectos
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    }

    public function verificarToken($token) {
        // Verificar token en el modelo
        return $this->model->verificarToken($token);
    }
}

// Crear instancia del controlador
$controller = new LoginController($conn);

// Verificar si se está enviando el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $controller->login($username, $password);
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];
    $resultado = $controller->verificarToken($token);
    if ($resultado) {
        echo "Token válido. Acceso permitido.";
    } else {
        echo "Token inválido. Acceso denegado.";
    }
}
?>