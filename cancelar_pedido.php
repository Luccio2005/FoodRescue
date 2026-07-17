<?php

session_start();
include("conexion.php");

if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
    exit();
}

if(isset($_GET["id"])){

    $idPedido = $_GET["id"];
    $idUsuario = $_SESSION["id_usuario"];

    $sql = "UPDATE pedidos
            SET estado='Cancelado'
            WHERE id_pedido='$idPedido'
            AND id_usuario='$idUsuario'
            AND estado='Pendiente'";

    if($conexion->query($sql)){
        header("Location: pedidos.php");
        exit();
    }

}

header("Location: pedidos.php");
exit();

?>