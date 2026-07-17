<?php

session_start();
include("conexion.php");

if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
    exit();
}

$sqlProductos = "SELECT nombre, precio_oferta FROM productos";
$resultadoProductos = $conexion->query($sqlProductos);
$modoEditar = false;
$idPedido = "";
$nombreCliente = "";
$direccionCliente = "";
$telefonoCliente = "";
$productoSeleccionado = "";
$cantidadSeleccionada = "";

if(isset($_GET["editar"])){
    $modoEditar = true;
    $idPedido = $_GET["editar"];
    $sqlEditar = "SELECT
                    p.id_pedido,
                    p.nombre_cliente,
                    p.direccion,
                    p.telefono,
                    d.cantidad,
                    pr.nombre
                FROM pedidos p
                INNER JOIN detalle_pedido d
                ON p.id_pedido=d.id_pedido
                INNER JOIN productos pr
                ON d.id_producto=pr.id_producto
                WHERE p.id_pedido='$idPedido'
                AND p.id_usuario='".$_SESSION["id_usuario"]."'";
    $resultadoEditar = $conexion->query($sqlEditar);
    if($resultadoEditar->num_rows>0){
        $pedido = $resultadoEditar->fetch_assoc();
        $nombreCliente = $pedido["nombre_cliente"];
        $direccionCliente = $pedido["direccion"];
        $telefonoCliente = $pedido["telefono"];
        $productoSeleccionado = $pedido["nombre"];
        $cantidadSeleccionada = $pedido["cantidad"];
    }

}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $id_usuario = $_SESSION["id_usuario"];
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];

    $nombre = trim($nombre);
    $direccion = trim($direccion);
    $telefono = trim($telefono);

    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)){
        die("<script>
                alert('Nombre inválido.');
                window.history.back();
            </script>");
    }

    if(strlen($direccion) < 5){
        die("<script>
                alert('La dirección es demasiado corta.');
                window.history.back();
            </script>");
    }

    if(!preg_match("/^[0-9]{9}$/", $telefono)){
        die("<script>
                alert('El teléfono debe tener exactamente 9 dígitos.');
                window.history.back();
            </script>");
    }

    if($cantidad < 1 || $cantidad > 20){
        die("<script>
                alert('Cantidad inválida.');
                window.history.back();
            </script>");
    }
    // Buscar el producto en la BD
    $consulta = "SELECT * FROM productos WHERE nombre='$producto'";
    $resultado = $conexion->query($consulta);

    if($resultado->num_rows > 0){

        $fila = $resultado->fetch_assoc();

        $id_producto = $fila["id_producto"];
        $precio = $fila["precio_oferta"];

        $subtotal = $precio * $cantidad;

        // Guardar pedido
        $sqlPedido = "INSERT INTO pedidos(id_usuario,nombre_cliente,direccion,telefono,producto,cantidad,total,estado)
                    VALUES('$id_usuario','$nombre','$direccion','$telefono','$producto','$cantidad','$subtotal','Pendiente')";

        if($conexion->query($sqlPedido)){

            $id_pedido = $conexion->insert_id;

            // Guardar detalle
            $sqlDetalle = "INSERT INTO detalle_pedido(id_pedido,id_producto,cantidad,subtotal)
                           VALUES('$id_pedido','$id_producto','$cantidad','$subtotal')";

            $conexion->query($sqlDetalle);

            echo "<script>
                alert('Pedido registrado correctamente');
                window.location='pedidos.php';
            </script>";
        }

    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/pedido.css">
    <meta charset="UTF-8">
    <title>Formulario de Pedido</title>
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
            <h2>
            <?php
                if($modoEditar){
                    echo "EDITAR PEDIDO";

                }else{
                    echo "REALIZAR PEDIDO";
                }
            ?>
            </h2>

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

<form action="<?php echo $modoEditar ? 'actualizar_pedido.php' : ''; ?>" 
    method="POST" id="formPedido">
    <?php
        if($modoEditar){
    ?>
        <input type="hidden" name="id_pedido"
        value="<?php echo $idPedido; ?>"> <?php
        }
    ?>
<label>Nombre del cliente</label>
<input type="text" name="nombre" id="nombre" placeholder="Ingrese su nombre" 
    value="<?php echo $nombreCliente; ?>"required>

<br>

<label>Dirección</label>
<input type="text" name="direccion" id="direccion" placeholder="Ingrese su dirección" 
    value="<?php echo $direccionCliente; ?>"required>

<br>

<label>Teléfono</label>
<input type="tel" name="telefono" id="telefono" placeholder="999999999" 
value="<?php echo $telefonoCliente; ?>"required>

<br>

<label>Seleccione un producto</label>

<select name="producto" id="producto">
    <?php
        while($productoBD = $resultadoProductos->fetch_assoc()){
    ?>
<option
    value="<?php echo $productoBD["nombre"]; ?>"
    data-precio="<?php echo $productoBD["precio_oferta"]; ?>"
    <?php
        if(
        (isset($_GET["producto"]) && $_GET["producto"]==$productoBD["nombre"])
        ||
        ($modoEditar && $productoSeleccionado==$productoBD["nombre"])
        ){
            echo "selected";
        }
        ?>
>
    <?php echo $productoBD["nombre"]; ?>
</option>
    <?php
        }
    ?>
</select>
<br>

<label>Precio</label>
<input
    type="text"
    id="precio"
    readonly>
<br>
<label>Total</label>
<input
    type="text"
    id="total"
    readonly>
<br>

<label>Cantidad</label>

<input type="number" name="cantidad" id="cantidad" min="1" max="20" 
    value="<?php echo $cantidadSeleccionada; ?>"required>
<br>
<button type="submit">
<?php
if($modoEditar){
    echo "Guardar Cambios";
}else{
    echo "Enviar Pedido";
}
?>

</button>

<div class="botones">

<a href="<?php echo $modoEditar ? 'pedidos.php' : 'menu.php'; ?>">
<?php
if($modoEditar){
    echo "← Volver a Mis Pedidos";
}else{
    echo "← Volver al Menú";
}

?>
</a>
<a href="index.php">

🏠 Inicio

</a>

</div>

</form>

</main>

<footer class="footer">

<p>📧 contacto@foodrescue.com</p>

<p>Facebook | Instagram | WhatsApp</p>

<p>© 2026 Food Rescue</p>

</footer>

</div>
<script src="js/pedido.js"></script>
</body>
</html>