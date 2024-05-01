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
    <title>crear proyecto</title>
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
        <h2>Añadir un Proyecto</h2>
        <form id="formularioproyecto" class="justify-content-center" onsubmit="return anadirproyecto()" method="POST">
            <div class="mb-2">
                <label for="titulo_proyecto" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo_proyecto" name="titulo_proyecto" required autofocus>
            </div>
            <div class="mb-2">
                <label for="descripcion_proyecto" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion_proyecto" name="descripcion_proyecto" required>
            </div>
            <div class="mb-2">
                <select name="estado_proyecto" id="estado_proyecto" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en curso">En curso</option>
                    <option value="terminado">Terminado</option>
                </select>
            </div>
            <div class="mb-2">
                <select name="tipo_proyecto" id="tipo_proyecto" required>
                    <option value="transliteracion">Transliteración</option>
                    <option value="Entrevistas sociolingüisticas">Entrevistas sociolingüisticas</option>
                    <option value="Edición y corrección de textos">Edición y corrección de textos</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary custom-btn justify-content-center">Añadir Proyecto</button>
        </form>
    </div>
    <script src="../js/ajax.js" defer></script>
</body>
</html>