<?php
session_start();
include("conexion.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $usuario=$_POST["usuario"];
    $contrasena=$_POST["contrasena"];

    $sql="SELECT * FROM usuarios
          WHERE usuario='$usuario'
          AND contrasena='$contrasena'";

    $resultado=$conexion->query($sql);

    if($resultado->num_rows>0){

        $fila = $resultado->fetch_assoc();
        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["usuario"] = $fila["usuario"];

        header("Location: index.php");
        exit();

    }else{

        echo "<script>alert('Usuario o contraseña incorrectos');</script>";

    }

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
            <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required /> <br><br>
            <label for="contrasena">Contraseña</label>

                <div class="contenedorPassword">
                    <input
                        type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
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