<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <title>Food Rescue - Inicio</title>
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
        <p>Rescatando alimentos y reduciendo el desperdicio.</p>
    </div>
    </div>
    <nav class="menu">
        <a href="index.php">Inicio</a>
        <a href="menu.php">Menú</a>
        <a href="form_pedido.php">Pedido</a>
        <a href="ofertas.php">Ofertas</a>
        <a href="pedidos.php">Mis pedidos</a>
    </nav>
    <div class="usuario">
    <?php
    if(isset($_SESSION["usuario"])){
    ?>
    <span>
        👤 <?php echo $_SESSION["usuario"]; ?>
    </span>
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

<main class="main">

<section>

<h2>
    <?php
        if(isset($_SESSION["usuario"])){
            echo "Bienvenido, ".$_SESSION["usuario"];
        }else{
            echo "Bienvenido";
        }
    ?>
</h2>
<p id="fechaHora"></p>
<p>
    Bienvenido a <strong>Food Rescue</strong>, una plataforma dedicada al rescate de alimentos en buen estado provenientes de restaurantes y negocios.
    Nuestro objetivo es reducir el desperdicio de comida mientras ofrecemos productos de calidad a precios accesibles para todos.
</p>
</section>

<section>

<h2>¿Quiénes somos?</h2>

<p>
Food Rescue conecta establecimientos de comida con personas interesadas en adquirir alimentos próximos a vencer, promoviendo el ahorro económico y el cuidado del medio ambiente mediante un consumo responsable.
</p>
<h3 id="contador">0</h3>
<p>Alimentos rescatados hasta hoy.</p>
</section>

<section>

<h2>Accesos rápidos</h2>

<p>

Explora nuestros productos, descubre las mejores ofertas o realiza tu pedido en pocos pasos.

</p>

<div class="accesos">

<a class="boton" href="menu.php">
🍕 Ver Menú
</a>

<a class="boton" href="form_pedido.php">
🛒 Realizar Pedido
</a>

<a class="boton" href="ofertas.php">
🔥 Ver Ofertas
</a>

</div>

</section>

</main>

<footer class="footer">

<p>📧 contacto@foodrescue.com</p>

<p>Facebook | Instagram | WhatsApp</p>

<p>© 2026 Food Rescue</p>

</footer>

</div>
<button id="btnSubir">
    ↑
</button>
<script src="js/index.js"></script>
</body>
</html>