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
    <title>editar</title>
    <link rel="stylesheet" href="/Proyecto_alejandro_vega/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Proyecto_alejandro_vega/assets/css/estilo.css">
    
</head>
<body>
        <noscript>
            <div style="color: red; text-align: center; background: yellow; padding: 10px;">
                ¡Advertencia! JavaScript está desactivado o no es compatible con tu navegador.
                Para usar esta aplicación, debes activar JavaScript.
            </div>
        </noscript>
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
        <h2>Editar un evento</h2>
        <form id="formularioevento" onsubmit="return actualizarEvento()" method="POST" >
            <div class="mb-2">
                <label for="id_evento" class="form-label">ID del evento</label>
                <input type="number" class="form-control" id="id_evento" name="id_evento" required>
            </div>
            <div class="mb-2">
                <label for="nombre_evento" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_evento" name="nombre_evento" required>
            </div>
            <div class="mb-2">
                <label for="descripcion_evento" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion_evento" name="descripcion_evento" required>
            </div>
            <div class="mb-2">
                <label for="aforo_evento" class="form-label">aforo</label>
                <input type="number" class="form-control" id="aforo_evento" name="aforo_evento" required>
            </div>
            <div class="mb-2">
                <label for="fecha_evento" class="form-label">fecha del evento</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <button type="submit" class="btn btn-primary custom-btn justify-content-center">Actualizar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/ajax.js"></script>
</body>
</html>