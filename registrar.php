<?php
session_start();
include("conexion.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombres = trim($_POST["nombre"] ?? "");
    $apellidos = trim($_POST["apellido"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";
    $confirmarContrasena = $_POST["contrasena2"] ?? "";
    $soloLetras = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u";
    // Validar nombres
    if($nombres === ""){
        mostrarErrorRegistro("Ingrese sus nombres.");
    }

    if(strlen($nombres) < 2 || strlen($nombres) > 50){
        mostrarErrorRegistro("Los nombres deben tener entre 2 y 50 caracteres.");
    }

    if(!preg_match($soloLetras, $nombres)){
        mostrarErrorRegistro("Los nombres solo pueden contener letras y espacios.");
    }
    // Validar apellidos
    if($apellidos === ""){
        mostrarErrorRegistro("Ingrese sus apellidos.");
    }

    if(strlen($apellidos) < 2 || strlen($apellidos) > 50){
        mostrarErrorRegistro("Los apellidos deben tener entre 2 y 50 caracteres.");
    }

    if(!preg_match($soloLetras, $apellidos)){
        mostrarErrorRegistro("Los apellidos solo pueden contener letras y espacios.");
    }
    // Validar correo
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        mostrarErrorRegistro("Ingrese un correo electrónico válido.");
    }

    if(strlen($correo) > 50){
        mostrarErrorRegistro("El correo no puede superar los 50 caracteres.");
    }
    // Validar usuario
    if($usuario === ""){
        mostrarErrorRegistro("Ingrese un nombre de usuario.");
    }

    if(strlen($usuario) < 4 || strlen($usuario) > 50){
        mostrarErrorRegistro("El usuario debe tener entre 4 y 50 caracteres.");
    }

    if(preg_match("/\s/", $usuario)){
        mostrarErrorRegistro("El usuario no puede contener espacios.");
    }

    if(!preg_match("/^[a-zA-Z0-9._-]+$/", $usuario)){
        mostrarErrorRegistro(
            "El usuario solo puede contener letras, números, punto, guion y guion bajo."
        );
    }
    // Validar contraseña
    if(strlen($contrasena) < 8 || strlen($contrasena) > 50){
        mostrarErrorRegistro("La contraseña debe tener entre 8 y 50 caracteres.");
    }
    if(!preg_match("/[A-Z]/", $contrasena)){
        mostrarErrorRegistro("La contraseña debe contener una letra mayúscula.");
    }
    if(!preg_match("/[a-z]/", $contrasena)){
        mostrarErrorRegistro("La contraseña debe contener una letra minúscula.");
    }

    if(!preg_match("/[0-9]/", $contrasena)){
        mostrarErrorRegistro("La contraseña debe contener al menos un número.");
    }

    if($contrasena !== $confirmarContrasena){
        mostrarErrorRegistro("Las contraseñas no coinciden.");
    }

    // Verificar si el usuario ya existe
    $consultaUsuario = $conexion->prepare(
        "SELECT id_usuario FROM usuarios WHERE usuario = ?"
    );

    $consultaUsuario->bind_param("s", $usuario);
    $consultaUsuario->execute();
    $resultadoUsuario = $consultaUsuario->get_result();

    if($resultadoUsuario->num_rows > 0){
        mostrarErrorRegistro("El nombre de usuario ya está registrado.");
    }

    // Verificar si el correo ya existe
    $consultaCorreo = $conexion->prepare(
        "SELECT id_usuario FROM usuarios WHERE correo = ?"
    );

    $consultaCorreo->bind_param("s", $correo);
    $consultaCorreo->execute();
    $resultadoCorreo = $consultaCorreo->get_result();

    if($resultadoCorreo->num_rows > 0){
        mostrarErrorRegistro("El correo electrónico ya está registrado.");
    }

    // Registrar al usuario
    $sql = $conexion->prepare(
        "INSERT INTO usuarios
        (nombres, apellidos, correo, usuario, contrasena)
        VALUES (?, ?, ?, ?, ?)"
    );

    $sql->bind_param(
        "sssss",
        $nombres,
        $apellidos,
        $correo,
        $usuario,
        $contrasena
    );

    if($sql->execute()){

        echo "<script>
                alert('Usuario registrado correctamente');
                window.location='login.php';
              </script>";

        exit();

    }else{

        mostrarErrorRegistro("Ocurrió un error al registrar el usuario.");

    }
}

function mostrarErrorRegistro($mensaje){

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
            <input type="text" maxlength="50" minlength="2" id="nombre" name="nombre" 
                placeholder="Ingrese sus nombres" autocomplete="given-name" required /><br><br>
            <label for="apellido">Apellidos Completos</label>
            <input type="text" maxlength="50" minlength="2" id="apellido" name="apellido" 
                placeholder="Ingrese sus apellidos" autocomplete="family-name" required /><br><br>
            <label for="correo">Correo Electronico</label>
            <input type="email" maxlength="50" id="correo" name="correo" 
                placeholder="Ingrese su correo" autocomplete="email" required /><br><br>
            <label for="usuario">Crea un usuario</label>
            <input type="text" maxlength="50" minlength="4" id="usuario" name="usuario" 
                placeholder="Ingrese un usuario" autocomplete="username" required /><br><br>
            <label for="contrasena">Crea una Contraseña</label>
            <input type="password" maxlength="50" minlength="8" id="contrasena" name="contrasena" 
                placeholder="Ingrese una contraseña" autocomplete="new-password" required /><br><br>
            <div class="barraSeguridad">
                <div id="nivelPassword"></div>
                </div>
                <p id="textoPassword">Seguridad de la contraseña</p><br>
            <label for="contrasena2">Confirmar Contraseña</label>
            <input type="password" maxlength="50" minlength="8" id="contrasena2" name="contrasena2" 
                placeholder="Vuelva a colocar contraseña" autocomplete="new-password" required /><br><br>
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