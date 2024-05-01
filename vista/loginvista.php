<?php
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/Proyecto_alejandro_vega/assets/bootstrap/css/bootstrap.min.css">
        <title>Login</title>
    </head>
    <body class="text-center">
        <div class="container custom-container">
            <form class="login-form justify-content-center"  onsubmit="return login()" method="POST">
                <h1 class="h3 mb-3 mt-3 font-weight-normal">Inicia Sesión</h1>
                <div>
                    <input type="text" id="usuario" name="username" class="form-control" placeholder="Usuario" required autofocus>
                    <input type="password" id="clave" name="password" class="form-control" placeholder="Clave" required>
                </div>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name= "inicio_sesion" value="Iniciar sesión">
                <p class="mt-5 mb-3 text-muted">&copy; Alejandro Vega</p>
            </form>
        </div>
        <script src="../js/ajax.js"></script>
    </body>
</html>