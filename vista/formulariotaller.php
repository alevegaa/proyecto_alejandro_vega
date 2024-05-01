<?php
require_once '../BD/loginmodelo.php';
$token = new Token();
session_start();
if ($token->verificarToken($_SESSION['id_usuario'])) {
} else {
    header("Location: loginvista.php");
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crear un taller</title>
    <link rel="stylesheet" href="/Proyecto_alejandro_vega/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Proyecto_alejandro_vega/assets/css/estilo.css">
    
</head>
<body>
    <header id="cabecera" class="navbar navbar-light" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand" href="principal.php">
                <h3>Gestion <small class="text-muted">Cultural</small></h3>
            </a>
            <div>
                <button class="btn btn-info justify-content-end" name="logout" onclick="logout()">Cerrar sesión</button>
                <button class="btn btn-success justify-content-end" onclick="volver()">volver</button>
            </div>
        </div>
    </header>
    <div class="container custom-container">
        <h2>Añadir un Taller</h2>
        <form id="formulariotaller" class="justify-content-center" onsubmit="return anadirtaller()" method="POST">
            <div class="mb-2">
                <label for="nombre_taller" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_taller" name="nombre_taller" required autofocus>
            </div>
            <div class="mb-2">
                <label for="descripcion_taller" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion_taller" name="descripcion_taller" required>
            </div>
            <div class="mb-2">
                <label for="aforo_taller" class="form-label">Aforo</label>
                <input type="number" class="form-control" id="aforo_taller" name="aforo_taller" required>
            </div>
            <div class="mb-2">
                <label for="fecha_taller" class="form-label">Fecha del curso</label>
                <input type="date" class="form-control" id="fecha_taller" name="fecha_taller" required>
            </div>
            <div class="mb-2">
                <label for="duracion_taller" class="form-label">Duración</label>
                <input type="text" class="form-control" id="duracion_taller" name="duracion_taller" required>
            </div>
            <div class="mb-2">
                <label for="precio_taller" class="form-label">precio</label>
                <input type="number" class="form-control" id="precio_taller" name="precio_taller" required>
            </div>
            <button type="submit" class="btn btn-primary custom-btn justify-content-center">Añadir Taller</button>
        </form>
    </div>
    <script src="../js/ajax.js" defer></script>
</body>
</html>