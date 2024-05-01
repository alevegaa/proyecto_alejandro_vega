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
    <title>Gestion Cultural</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="obtenereventos()">Eventos</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="obtenercursos()">Cursos</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="obtenertalleres()">Talleres</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="obtenerproyectos()">Proyectos</a>
                </li>
            </ul>
                <button class="btn btn-info justify-content-end" name="logout" onclick="logout()">Cerrar sesión</button>
        </div>
    </header>
    <div id="principal" class="container">
        <br>
        <h2 class='text-center'>¿Qué es la Gestión Cultural?</h2>
        <br>
        <p class="text-center">El sector cultural es un ámbito amplio que abarca diversas manifestaciones, instituciones y actividades relacionadas con el consumo de bienes y servicios. Este sector resulta de gran importancia en el desarrollo sociocultural de los países. Además, implica la participación de diferentes individuos como artistas, creadores de contenido, gestores culturales y cualquier persona dedicada al fomento de la cultura. Dentro de este ámbito se encuentra el área de la literatura, donde la actuación de la gestión cultural comprende la realización de diferentes eventos como puede ser la organización de clubes de lecturas, las ferias del libro, coloquios literarios, así como un largo número de actividades. Desde este trabajo se entiende la cultura como un compendio de proyectos creativos que generan los individuos o grupos para expresar sus ideas y creencias mediante su creatividad.
        </p>
        <br>
        <div class="d-flex justify-content-center">
            <img src="../img/feriadellibro.jpeg" class="text-center"><img>
        </div>
    </div>
    <script src="../js/ajax.js"></script>
</body>
