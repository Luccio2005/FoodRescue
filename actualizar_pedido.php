<?php
session_start();
include("conexion.php");
if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id_usuario = $_SESSION["id_usuario"];
    $id_pedido = $_POST["id_pedido"];
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

    if(strlen($direccion) < 8){
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
            /script>");
    }
    // Buscar el producto seleccionado
    $sqlProducto = "SELECT * FROM productos
                    WHERE nombre='$producto'";
    $resultadoProducto = $conexion->query($sqlProducto);
    if($resultadoProducto->num_rows>0){
        $filaProducto = $resultadoProducto->fetch_assoc();
        $id_producto = $filaProducto["id_producto"];
        $precio = $filaProducto["precio_oferta"];
        $subtotal = $precio * $cantidad;

        // Actualizar pedido
        $sqlPedido = "UPDATE pedidos SET
                        nombre_cliente='$nombre',
                        direccion='$direccion',
                        telefono='$telefono',
                        producto='$producto',
                        cantidad='$cantidad',
                        total='$subtotal'
                        WHERE id_pedido='$id_pedido'
                        AND id_usuario='$id_usuario'
                        AND estado='Pendiente'";
        if($conexion->query($sqlPedido)){

            // Actualizar detalle
            $sqlDetalle = "UPDATE detalle_pedido SET
                            id_producto='$id_producto',
                            cantidad='$cantidad',
                            subtotal='$subtotal'
                            WHERE id_pedido='$id_pedido'";
            $conexion->query($sqlDetalle);
            echo "<script>
                    alert('Pedido actualizado correctamente');
                    window.location='pedidos.php';
                  </script>";
        }
    }
}
?>