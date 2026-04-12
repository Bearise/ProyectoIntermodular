<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];

/* comprobar si ya existe en carrito */
$stmt = $pdo->prepare("
    SELECT * FROM carrito 
    WHERE id_usuario = ? AND id_producto = ?
");
$stmt->execute([$id_usuario, $id_producto]);
$existe = $stmt->fetch();

if ($existe) {
    /* actualizar cantidad */
    $stmt = $pdo->prepare("
        UPDATE carrito 
        SET cantidad = cantidad + ?
        WHERE id_usuario = ? AND id_producto = ?
    ");
    $stmt->execute([$cantidad, $id_usuario, $id_producto]);
} else {
    /* insertar */
    $stmt = $pdo->prepare("
        INSERT INTO carrito (id_usuario, id_producto, cantidad, fecha_creacion)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$id_usuario, $id_producto, $cantidad]);
}

/* volver al producto */
header("Location: ../../producto.php?id=" . $id_producto);
exit();
