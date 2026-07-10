<?php
session_start();
include("conexion.php");

if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM productos";

$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/menu.css">
    <meta charset="UTF-8">
    <title>Menú de Comidas</title>
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
            <h2>MENU DE COMIDAS</h2>
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
<main class="tabla">
<div class="buscador">

    <input
        type="text"
        id="buscarProducto"
        placeholder="🔍 Buscar producto..."
    >

</div>

<br>
<table>

<thead>

<tr>

<th>Producto</th>

<th>Descripción</th>

<th>Precio Original</th>

<th>Precio Oferta</th>

<th>Acción</th>

</tr>

</thead>

<tbody>
<?php
    while($fila = $resultado->fetch_assoc()){
?>
    <tr>
    <td><?php echo $fila["nombre"]; ?></td>
    <td><?php echo $fila["descripcion"]; ?></td>
    <td>S/. <?php echo $fila["precio_original"]; ?></td>
    <td>S/. <?php echo $fila["precio_oferta"]; ?></td>
    <td>
    <a href="form_pedido.php?producto=<?php echo urlencode($fila["nombre"]); ?>">
    <button>
    Añadir al Pedido
    </button>
    </a>
    </td>
    </tr>
    <?php
    }
    ?>
</tbody>

</table>

</main>

<section class="botones">

<a href="form_pedido.php">

Realizar Pedido

</a>

<a href="index.php">

Volver al Inicio

</a>

</section>

<footer class="footer">

<p>📧 contacto@foodrescue.com</p>

<p>Facebook | Instagram | WhatsApp</p>

<p>© 2026 Food Rescue</p>

</footer>

</div>
<script src="js/menu.js"></script>
</body>
</html>