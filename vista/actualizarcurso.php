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
        <h2>Editar un curso</h2>
        <form id="formulariocurso" class="justify-content-center" onsubmit="return actualizarCurso()" method="POST">
        <div class="mb-2">
                <label for="id_curso" class="form-label">Id</label>
                <input type="number" class="form-control" id="id_curso" name="id_curso" required>
            </div>
            <div class="mb-2">
                <label for="nombre_curso" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_curso" name="nombre_curso">
            </div>
            <div class="mb-2">
                <label for="descripcion_curso" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion_curso" name="descripcion_curso">
            </div>
            <div class="mb-2">
                <select name="estado_curso" id="estado_curso">
                    <option value="pendiente">Pendiente</option>
                    <option value="empezado">Empezado</option>
                    <option value="terminado">Terminado</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="aforo_curso" class="form-label">Aforo</label>
                <input type="number" class="form-control" id="aforo_curso" name="aforo_curso">
            </div>
            <div class="mb-2">
                <label for="fecha_inicio_curso" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" id="fecha_inicio_curso" name="fecha_inicio_curso">
            </div>
            <div class="mb-2">
                <label for="fecha_final_curso" class="form-label">Fecha de finalización</label>
                <input type="date" class="form-control" id="fecha_final_curso" name="fecha_final_curso">
            </div>
            <div class="mb-2">
                <label for="horario_curso" class="form-label">Horario del curso</label>
                <input type="text" class="form-control" id="horario_curso" name="horario_curso">
            </div>
            <div class="mb-2">
                <label for="precio_curso" class="form-label">precio</label>
                <input type="number" class="form-control" id="precio_curso" name="precio_curso">
            </div>
            <button type="submit" class="btn btn-primary custom-btn justify-content-center">Actualizar</button>
        </form>
    </div>
    <script src="../js/ajax.js"></script>
</body>
</html>