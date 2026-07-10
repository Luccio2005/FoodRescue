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
        <link rel="stylesheet" href="css/ofertas.css">
        <meta charset="UTF-8" />
        <title>Ofertas Especiales</title>
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
            <h2>OFERTAS ESPECIALES</h2>
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
        <?php
            $contador=1;
            while($fila=$resultado->fetch_assoc()){
        ?>
        <section class="oferta<?php echo $contador; ?>">
        <?php
            $imagen="";
            switch($fila["nombre"]){
                case "Pizza Familiar":
                    $imagen="imagenes/pizza.jpg";
                    break;
                case "Pollo a la Brasa":
                    $imagen="imagenes/pollo.webp";
                    break;
                case "Hamburguesa + Papas":
                    $imagen="imagenes/hamburguesa.webp";
                    break;
                case "Lasaña":
                    $imagen="imagenes/lasagna.webp";
                    break;
                case "Ensalada César":
                    $imagen="imagenes/ensalada.avif";
                    break;
            }
        ?>
        <img src="<?php echo $imagen; ?>" width="200">
        <h3><?php echo $fila["nombre"]; ?></h3>
        <span class="etiqueta"></span>
        <p>
        Precio Original:
        <del>S/. <?php echo $fila["precio_original"]; ?></del>
        </p>
        <p>
        <strong>
        Precio Oferta:
        S/. <?php echo $fila["precio_oferta"]; ?>
        </strong>
        <p>
            ⏰ Oferta termina en
        <span class="contador"></span>
        </p>
        </p>
        <p>🔥 Oferta Especial</p>
        <a href="form_pedido.php?producto=<?php echo urlencode($fila["nombre"]); ?>">
        <button>
            Comprar
        </button>
        </a>
        </section>
        <?php
        $contador++;
        }
        ?>
        <section class="botones">
        <a href="menu.php">Ver Menu</a>
        <a href="index.php">Volver al Inicio</a>
        </section>
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
        <script src="js/ofertas.js"></script>
    </body>
</html>