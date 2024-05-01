<?php
require 'BD.php';

class Evento {

    private $conn;

    public function __construct() {
        $this->conn = bdconexion::conexion();
    }

    public function obtenerEventos(){ //obtiene los eventos de la base de datos
        try{
            $sql = "SELECT * FROM t_eventos";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $eventos = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $eventos[] = $campos;
                }
                echo json_encode($eventos);
            } else {
                echo json_encode(array('mensaje' => 'No hay eventos'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function obtenerEventoID($id){ //pasando el parámetro obtiene el evento asociado
        try{
            $sql = "SELECT * FROM t_eventos WHERE id = $id";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $evento = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $evento[] = $campos;
                }
                echo json_encode($evento);
            } else {
                echo json_encode(array('mensaje' => 'No hay eventos'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function CrearEvento($nombre, $descripcion, $aforo, $fecha){ //crea el evento con los parámetros pasados
        if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre contiene caracteres inválidos.'));
            return;
        }
        
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-]+$/', $aforo)) {
            echo json_encode(array('error' => 'El aforo contiene caracteres inválidos.'));
            return;
        }
    
        if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
            echo json_encode(array('error' => 'El formato de la fecha es incorrecto. Use YYYY-MM-DD.'));
            return;
        }
        try{
            $sql = "INSERT INTO t_eventos (nombre_evento, descripcion, aforo_max, fecha) VALUES (?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("ssis", $nombre, $descripcion, $aforo, $fecha); 
            $statement->execute();
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Evento creado exitosamente'));
            } else {
                echo json_encode(array('mensaje' => 'Error al crear evento'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function eliminarEventoID($id){ //elimina el evento con el id igual al parámetro pasado
        try{
            $sql = "DELETE FROM t_eventos WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            if ($statement->affected_rows > 0) {
                $dato = "true";
                echo json_encode($dato);
            } else {
                $dato = "false";
                echo json_encode($dato);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function editarEvento($id, $nombre, $descripcion, $aforo_max, $fecha){ //edita el evento con los parámetros pasados
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
            echo json_encode(array('error' => 'ID inválido'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre contiene caracteres inválidos.'));
            return;
        }
        
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }
    
        if (!filter_var($aforo_max, FILTER_VALIDATE_INT) || $aforo_max <= 0) {
            echo json_encode(array('error' => 'El aforo máximo debe ser un número entero positivo'));
            return;
        }
    
        if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
            echo json_encode(array('error' => 'El formato de la fecha es incorrecto. Use YYYY-MM-DD.'));
            return;
        }
        try{
            $sql = "UPDATE t_eventos SET nombre_evento = ?, descripcion=?, aforo_max=?, fecha=? WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("ssisi", $nombre, $descripcion, $aforo_max, $fecha, $id); 
            $statement->execute();
            
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Evento actualizado'));
            } else {
                echo json_encode(array('mensaje' => 'Se ha producido un error al actualizar'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }
}

Class Curso{
    private $conn;

    public function __construct() {
        $this->conn = bdconexion::conexion();
    }

    public function obtenerCursos(){
        try{
            $sql = "SELECT * FROM t_cursos";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $curso = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $curso[] = $campos;
                }
                echo json_encode($curso);
            } else {
                echo json_encode(array('mensaje' => 'No hay cursos'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function obtenerCursoID($id){
        try{
            $sql = "SELECT * FROM t_cursos WHERE id = $id";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $curso = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $curso[] = $campos;
                }
                echo json_encode($curso);
            } else {
                $mensaje = 'No hay cursos';
                echo json_encode($mensaje);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function CrearCurso($nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio){ 

        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }

        if (!preg_match('/^[a-zA-Z0-9\s,.\-]+$/', $aforo)) {
            echo json_encode(array('error' => 'El aforo contiene caracteres inválidos.'));
            return;
        }

        if (!preg_match('/^[a-zA-Z0-9\s,:-]+$/', $horario)) {
            echo json_encode(array('error' => 'El horario contiene caracteres inválidos.'));
            return;
        }
        try{
            $sql = "INSERT INTO t_cursos (nombre_curso, descripcion, estado, aforo_max, fecha_inicio, fecha_final, horario, precio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("sssisssi", $nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio); 
            $statement->execute();
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Curso creado exitosamente'));
            } else {
                echo json_encode(array('mensaje' => 'Imposible crear el curso'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function eliminarCursoID($id){
        try{
            $sql = "DELETE FROM t_cursos WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            if ($statement->affected_rows > 0) {
                $dato = "true";
                echo json_encode($dato);
            } else {
                $dato = "false";
                echo json_encode($dato);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function editarCurso($id, $nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio){
        
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
            echo json_encode(array('error' => 'ID inválido'));
            return;
        }

        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }

        if (!filter_var($aforo, FILTER_VALIDATE_INT) || $aforo <= 0) {
            echo json_encode(array('error' => 'El aforo máximo debe ser un número entero positivo'));
            return;
        }

        if (!preg_match('/^[a-zA-Z0-9\s,:-]+$/', $horario)) {
            echo json_encode(array('error' => 'El horario contiene caracteres inválidos.'));
            return;
        }
        try{
            $sql = "UPDATE t_cursos SET nombre_curso = ?, descripcion=?, estado=?, aforo_max=?, fecha_inicio=?, fecha_final=?, horario=?, precio=? WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("sssisssii", $nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio, $id); 
            $statement->execute();
            
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Curso actualizado'));
            } else {
                echo json_encode(array('mensaje' => 'Se ha producido un error al actualizar'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }
}

Class Taller{

    private $conn;

    public function __construct() {
        $this->conn = bdconexion::conexion();
    }

    public function obtenerTalleres(){
        try {
            $sql = "SELECT * FROM t_talleres";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $taller = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $taller[] = $campos;
                }
                echo json_encode($taller);
            } else {
                echo json_encode(array('mensaje' => 'No hay talleres'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function obtenerTallerID($id){
        try {
            $sql = "SELECT * FROM t_talleres WHERE id = $id";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $taller = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $taller[] = $campos;
                }
                echo json_encode($taller);
            } else {
                $mensaje = 'No hay talleres';
                echo json_encode($mensaje);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function CrearTaller($nombre, $descripcion, $aforo, $fecha, $duracion, $precio){ 
        
        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre del taller contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres no permitidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-]+$/', $aforo)) {
            echo json_encode(array('error' => 'El aforo contiene caracteres inválidos.'));
            return;
        }
        
        if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $duracion)) {
            echo json_encode(array('error' => 'La duración del taller contiene caracteres inválidos.'));
            return;
        }
        try {
            $sql = "INSERT INTO t_talleres (nombre_taller, descripcion, aforo_max, fecha, duracion, precio) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("ssissi", $nombre, $descripcion, $aforo, $fecha, $duracion, $precio); 
            $statement->execute();
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Taller creado exitosamente'));
            } else {
                echo json_encode(array('mensaje' => 'Error al crear el taller'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function eliminarTallerID($id){
        try {
            $sql = "DELETE FROM t_talleres WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            if ($statement->affected_rows > 0) {
                $dato = "true";
                echo json_encode($dato);
            } else {
                $dato = "false";
                echo json_encode($dato);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function editarTaller($id, $nombre, $descripcion, $aforo, $fecha, $duracion, $precio){
        
        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $nombre)) {
            echo json_encode(array('error' => 'El nombre del taller contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres no permitidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-]+$/', $aforo)) {
            echo json_encode(array('error' => 'El aforo contiene caracteres inválidos.'));
            return;
        }
        
        if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑüÜ]+$/', $duracion)) {
            echo json_encode(array('error' => 'La duración del taller contiene caracteres inválidos.'));
            return;
        }
        try {    
            $sql = "UPDATE t_talleres SET nombre_taller = ?, descripcion=?, aforo_max=?, fecha=?, duracion=?, precio=? WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("ssissii", $nombre, $descripcion, $aforo, $fecha, $duracion, $precio, $id); 
            $statement->execute();
            
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Taller actualizado'));
            } else {
                echo json_encode(array('mensaje' => 'Se ha producido un error al actualizar'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

}

Class Proyecto{

    private $conn;

    public function __construct() {
        $this->conn = bdconexion::conexion();
    }

    public function obtenerProyectos(){
        try{
            $sql = "SELECT * FROM t_proyectos";
            $busqueda = $this->conn->query($sql);
            if ($busqueda->num_rows > 0) {
                $proyecto = array();
                while ($campos = $busqueda->fetch_assoc()) {
                    $proyecto[] = $campos;
                }
                echo json_encode($proyecto);
            } else {
                echo json_encode(array('mensaje' => 'No hay proyectos'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function CrearProyecto($titulo, $descripcion, $estado, $tipo){ 
        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $titulo)) {
            echo json_encode(array('error' => 'El título contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }
        try{
            $sql = "INSERT INTO t_proyectos (titulo, descripcion, estado, tipo) VALUES (?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("ssss", $titulo, $descripcion, $estado, $tipo); 
            $statement->execute();
            if ($statement->affected_rows > 0) {
                echo json_encode(array('mensaje' => 'Proyecto creado exitosamente'));
            } else {
                echo json_encode(array('mensaje' => 'Error al crear el proyecto'));
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function eliminarProyectoID($id){
        try {
            $sql = "DELETE FROM t_proyectos WHERE id = ?";
            $statement = $this->conn->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            if ($statement->affected_rows > 0) {
                $dato = "true";
                echo json_encode($dato);
            } else {
                $dato = "false";
                echo json_encode($dato);
            }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

    public function editarProyecto($id, $titulo, $descripcion, $estado, $tipo){
        if (!preg_match('/^[a-zA-Z0-9\s,.\áéíóúÁÉÍÓÚñÑüÜ]+$/', $titulo)) {
            echo json_encode(array('error' => 'El título contiene caracteres inválidos.'));
            return;
        }
    
        if (!preg_match('/^[a-zA-Z0-9\s,.\-áéíóúÁÉÍÓÚñÑüÜ]+$/', $descripcion)) {
            echo json_encode(array('error' => 'La descripción contiene caracteres inválidos.'));
            return;
        }
        try {
        $sql = "UPDATE t_proyectos SET titulo = ?, descripcion=?, estado=?, tipo=? WHERE id = ?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param("ssssi", $titulo, $descripcion, $estado, $tipo, $id); 
        $statement->execute();
        
        if ($statement->affected_rows > 0) {
            echo json_encode(array('mensaje' => 'Proyecto actualizado'));
        } else {
            echo json_encode(array('mensaje' => 'Se ha producido un error al actualizar'));
        }
        } catch (Exception $e) {
            echo "Se ha producido un error: " . $e->getMessage() . "\n";
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/evento') { //obtiene los eventos
        $evento = new Evento();
        $evento->obtenerEventos();
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/curso') { //obtiene los cursos
        $curso = new Curso();
        $curso->obtenerCursos();
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/taller') { //obtiene los talleres
        $taller = new Taller();
        $taller->obtenerTalleres();
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/proyecto') { //obtiene los proyectos
        $proyecto = new Proyecto();
        $proyecto->obtenerProyectos();
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/evento/obtenerEventoID?id='.$_GET['id']  ) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $evento = new Evento();
            $evento->obtenerEventoID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/curso/obtenerCursoID?id='.$_GET['id']  ) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $curso = new Curso();
            $curso->obtenerCursoID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    }  elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/taller/obtenerTallerID?id='.$_GET['id']  ) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $taller = new Taller();
            $taller->obtenerTallerID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/evento/anadirevento') { //añade un evento
        if (isset($_POST['nombre'])) {
            $evento = new Evento();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $aforo = $_POST['aforo'];
            $fecha = $_POST['fecha'];
            $evento->CrearEvento($nombre, $descripcion, $aforo, $fecha);
        } else {
            echo json_encode(array('error' => 'No se puede crear el evento'));
        }
    } elseif($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/curso/anadircurso'){
        if (isset($_POST['nombre'])) {
            $curso = new Curso();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $aforo = $_POST['aforo'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_final = $_POST['fecha_final'];
            $horario = $_POST['horario'];
            $precio = $_POST['precio'];
            $curso->CrearCurso($nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio);
        } else {
            echo json_encode(array('error' => 'No se puede crear el curso'));
        }
    } elseif($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/taller/anadirtaller'){
        if (isset($_POST['nombre'])) {
            $taller = new Taller();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $aforo = $_POST['aforo'];
            $fecha = $_POST['fecha'];
            $duracion = $_POST['duracion'];
            $precio = $_POST['precio'];
            $taller->CrearTaller($nombre, $descripcion, $aforo, $fecha, $duracion, $precio);
        } else {
            echo json_encode(array('error' => 'No se puede crear el taller'));
        }
    } elseif($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/proyecto/anadirproyecto'){ //añadir proyecto
        if (isset($_POST['titulo'])) {
            $proyecto = new Proyecto();
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $tipo = $_POST['tipo'];
            $proyecto->CrearProyecto($titulo, $descripcion, $estado, $tipo);
        } else {
            echo json_encode(array('error' => 'No se puede crear el taller'));
        }
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/evento/actualizarevento') { //actualiza un evento
        if (isset($_POST['id'])) {
            $evento = new Evento();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $aforo_max = $_POST['aforo'];
            $fecha = $_POST['fecha'];
            $evento->editarEvento($id, $nombre, $descripcion, $aforo_max, $fecha);
        } else {
            echo json_encode(array('error' => 'No se puede crear el evento'));
        }
    } elseif ($_SERVER["REQUEST_URI"] === '/proyecto_alejandro_vega/BD/api.php/curso/actualizarCurso') { 
        if (isset($_POST['id'])) {
            $curso = new Curso();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $aforo = $_POST['aforo'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_final = $_POST['fecha_final'];
            $horario = $_POST['horario'];
            $precio = $_POST['precio'];
            $curso->editarCurso($id, $nombre, $descripcion, $estado, $aforo, $fecha_inicio, $fecha_final, $horario, $precio);
        } else {
            echo json_encode(array('error' => 'No se puede editar el curso'));
        }
    } elseif($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/taller/actualizartaller'){
        if (isset($_POST['id'])) {
            $taller = new Taller();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $aforo = $_POST['aforo'];
            $fecha = $_POST['fecha'];
            $duracion = $_POST['duracion'];
            $precio = $_POST['precio'];
            $taller->editarTaller($id, $nombre, $descripcion, $aforo, $fecha, $duracion, $precio);
        } else {
            echo json_encode(array('error' => 'No se puede editar el taller'));
        }
    } elseif ($_SERVER['REQUEST_URI'] === '/proyecto_alejandro_vega/BD/api.php/proyecto/actualizarproyecto') { //actualiza un evento
        if (isset($_POST['id'])) {
            $proyecto = new Proyecto();
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $tipo = $_POST['tipo'];
            $proyecto->editarProyecto($id, $titulo, $descripcion, $estado, $tipo);
        } else {
            echo json_encode(array('error' => 'No se puede crear el proyecto'));
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    if ($_SERVER["REQUEST_URI"] === '/proyecto_alejandro_vega/BD/api.php/evento/eliminarEventoID?id='.$_GET['id']) { //elimina un evento

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $evento = new Evento();
            $evento->eliminarEventoID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    } elseif ($_SERVER["REQUEST_URI"] === '/proyecto_alejandro_vega/BD/api.php/curso/eliminarCursoID?id='.$_GET['id']) { //elimina un evento

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $curso = new Curso();
            $curso->eliminarCursoID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    } elseif ($_SERVER["REQUEST_URI"] === '/proyecto_alejandro_vega/BD/api.php/taller/eliminarTallerID?id='.$_GET['id']) { //elimina un evento

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $taller = new Taller();
            $taller->eliminarTallerID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    } elseif ($_SERVER["REQUEST_URI"] === '/proyecto_alejandro_vega/BD/api.php/proyecto/eliminarProyectoID?id='.$_GET['id']) { //elimina un evento

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $proyecto = new Proyecto();
            $proyecto->eliminarProyectoID($id);
        } else {
            echo json_encode(array('error' => 'No se proporcionó el parámetro "id"'));
        }
    }
}
?>