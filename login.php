<?php

session_start();
include("conexion.php");

if(isset($_SESSION["id_usuario"])){
    header("Location: index.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $usuario = trim($_POST["usuario"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";

    if($usuario === ""){
        mostrarErrorLogin("Ingrese su usuario.");
    }

    if($contrasena === ""){
        mostrarErrorLogin("Ingrese su contraseña.");
    }

    if(strlen($usuario) < 4 || strlen($usuario) > 50){
        mostrarErrorLogin("El usuario ingresado no es válido.");
    }

    if(preg_match("/\s/", $usuario)){
        mostrarErrorLogin("El usuario no puede contener espacios.");
    }

    $sql = $conexion->prepare(
        "SELECT id_usuario, usuario, contrasena
         FROM usuarios
         WHERE usuario = ?"
    );

    $sql->bind_param("s", $usuario);
    $sql->execute();
    $resultado = $sql->get_result();

    if($resultado->num_rows === 0){
        mostrarErrorLogin("El usuario no existe.");
    }
    $fila = $resultado->fetch_assoc();
    if($contrasena !== $fila["contrasena"]){
        mostrarErrorLogin("La contraseña es incorrecta.");
    }
    $_SESSION["id_usuario"] = $fila["id_usuario"];
    $_SESSION["usuario"] = $fila["usuario"];
    header("Location: index.php");
    exit();
}

function mostrarErrorLogin($mensaje){
    $mensajeSeguro = json_encode($mensaje);
    echo "<script>
            alert($mensajeSeguro);
            window.history.back();
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/login.css">
        <meta charset="UTF-8" />
        <title>Iniciar Sesion</title>
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
            <h2>INICIAR SESIÓN</h2>
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
        <form action="" method="POST" id="formLogin">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" minlength="4" maxlength="50" 
                placeholder="Ingrese su usuario" autocomplete="username" required /> <br><br>
            <label for="contrasena">Contraseña</label>

                <div class="contenedorPassword">
                    <input
                        type="password" id="contrasena" name="contrasena" maxlength="50"
                        placeholder="Ingrese su contraseña" autocomplete="current-password" required>
                <button
                    type="button"
                    id="mostrarPassword">
                    👁
                </button>
                </div> <br><br>
            <label>
                <input type="checkbox" name="recordarme" />
                Recordarme
            </label><br>
            <input type="submit" value="Ingresar" />
            <p>¿No tienes cuenta?
            <a href="registrar.php">Registrate aqui</a>
            </p>
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
    <script src="js/login.js"></script>    
    </body>
</html>