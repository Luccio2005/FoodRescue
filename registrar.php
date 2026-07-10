<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = $_POST["nombre"];
    $apellidos = $_POST["apellido"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    $sql = "INSERT INTO usuarios(nombres, apellidos, correo, usuario, contrasena)
            VALUES('$nombres','$apellidos','$correo','$usuario','$contrasena')";

    if($conexion->query($sql)){
        echo "<script>
            alert('Usuario registrado correctamente');
            window.location='login.php';
            </script>";
    }else{
        echo "<script>alert('Error al registrar usuario');</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/registrar.css">
        <meta charset="UTF-8" />
        <title>Registrar Usuario</title>
    </head>
    <body>
        <div class="container">
        <header class="header">
            <div class="logo">
                <a href="index.php">
                    <img src="imagenes/logo.png" alt="Logo">
                </a>
            <div>
                <a href="index.php" class="tituloLogo">
                    <h1>Food Rescue</h1>
                </a>
            </div>
            </div>
            <h2>REGISTRAR USUARIO</h2>
            <div class="usuario">
            <?php
                if(isset($_SESSION["usuario"])){
            ?>
            <a class="botonSesion" href="logout.php">
                🚪 Cerrar sesión
            </a>
            <?php
                }else{
            ?>
            <a class="botonSesion" href="login.php">
                👤 Iniciar sesión
            </a>
            <?php
                }
            ?>
            </div>
        </header>
        <main class="formulario">
        <form action="" method="POST" id="formRegistro">
            <label for="nombre">Nombres Completos</label>
            <input type="text" maxlength="50" id="nombre" name="nombre" placeholder="Ingrese sus nombres" required /><br><br>
            <label for="apellido">Apellidos Completos</label>
            <input type="text" maxlength="50" id="apellido" name="apellido" placeholder="Ingrese sus apellidos" required /><br><br>
            <label for="correo">Correo Electronico</label>
            <input type="email" maxlength="50" id="correo" name="correo" placeholder="Ingrese su correo"required /><br><br>
            <label for="usuario">Crea un usuario</label>
            <input type="text" maxlength="50" id="usuario" name="usuario" placeholder="Ingrese un usuario" required /><br><br>
            <label for="contrasena">Crea una Contraseña</label>
            <input type="password" maxlength="50" id="contrasena" name="contrasena" placeholder="Ingrese una contraseña" required /><br><br>
            <div class="barraSeguridad">
                <div id="nivelPassword"></div>
                </div>
                <p id="textoPassword">Seguridad de la contraseña</p><br>
            <label for="contrasena2">Confirmar Contraseña</label>
            <input type="password" maxlength="50" id="contrasena2" name="contrasena2" placeholder="Vuelva a colocar contraseña" required /><br><br>
            <input type="submit" value="Registrar" /><br>
            <a href="login.php">Volver al inicio de sesion</a>
        </form>
        </main>
        <footer class="footer">
            <p>
            📧 contacto@foodrescue.com
            </p>
            <p>
            Facebook |
            Instagram |
            WhatsApp
            </p>
            <p>
            © 2026 Food Rescue
            </p>
        </footer>
        </div>
    <script src="js/registro.js"></script>
    </body>
</html>