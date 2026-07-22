<?php
session_start();
include("conexion.php");

if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$sql = "SELECT
p.id_pedido,
p.fecha,
p.nombre_cliente,
pr.nombre AS producto,
d.cantidad,
p.total,
p.estado
FROM pedidos p
INNER JOIN detalle_pedido d
ON p.id_pedido=d.id_pedido
INNER JOIN productos pr
ON d.id_producto=pr.id_producto
WHERE p.id_usuario='$id_usuario'
ORDER BY p.id_pedido DESC";

$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/pedidos.css">
        <meta charset="UTF-8" />
        <title>Tabla de Pedidos Realizados</title>
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
            <h2>MIS PEDIDOS</h2>
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

<?php
if($resultado && $resultado->num_rows > 0){
?>

<div class="herramientas">
    <input
        type="text"
        id="buscarPedido"
        placeholder="🔍 Buscar por número, cliente o producto..."
    >
    <select id="filtroEstado">
        <option value="Todos">Todos los estados</option>
        <option value="Pendiente">Pendiente</option>
        <option value="Entregado">Entregado</option>
        <option value="Cancelado">Cancelado</option>
    </select>
</div>
        <table border="1">
            <thead>
                <tr>
                    <th>N° de Pedido</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Productos Seleccionados</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($fila = $resultado->fetch_assoc()){
            ?>
                <tr>
                    <td>
                        <?php echo $fila["id_pedido"]; ?>
                    </td>
                    <td>
                        <?php echo date("d/m/Y H:i", strtotime($fila["fecha"])); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($fila["nombre_cliente"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($fila["producto"]); ?>
                    </td>
                    <td>
                        <?php echo $fila["cantidad"]; ?>
                    </td>
                    <td>
                        S/. <?php echo number_format($fila["total"], 2); ?>
                    </td>
                    <td>
                        <?php
                        if($fila["estado"] == "Pendiente"){
                            echo "<span class='estado pendiente'>Pendiente</span>";
                        }elseif($fila["estado"] == "Entregado"){
                            echo "<span class='estado entregado'>Entregado</span>";
                        }elseif($fila["estado"] == "Cancelado"){
                            echo "<span class='estado cancelado'>Cancelado</span>";
                        }else{
                            echo "<span class='estado'>".
                                htmlspecialchars($fila["estado"]).
                                "</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($fila["estado"] == "Pendiente"){
                        ?>
                            <a
                                href="form_pedido.php?editar=<?php echo $fila["id_pedido"]; ?>"
                                class="btnEditar">
                                Editar
                            </a>
                            <br><br>
                            <a
                                href="cancelar_pedido.php?id=<?php echo $fila["id_pedido"]; ?>"
                                class="btnCancelar"
                                onclick="return confirm('¿Seguro que deseas cancelar este pedido?');">
                                Cancelar
                            </a>
                        <?php
                        }else{
                            echo "-";
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <?php
        }else{
        ?>
        <div class="sinPedidos">
            <div class="iconoSinPedidos">
                📦
            </div>
            <h2>Aún no has realizado pedidos</h2>
            <p>
                Explora nuestro menú y encuentra alimentos de calidad
                a precios especiales.
            </p>
            <a href="menu.php" class="btnPrimerPedido">
                🍕 Realizar mi primer pedido
            </a>
        </div>
        <?php
        }
        ?>
        </main>
        <section class="botones">
        <a href="menu.php">Menu de Comidas</a><br><br>
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
        <script src="js/pedidos.js"></script>
    </body>
</html>