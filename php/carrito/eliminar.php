<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];
$id_producto = $_POST['id_producto'];

/* eliminar producto del carrito */
$stmt = $pdo->prepare("
    DELETE FROM carrito 
    WHERE id_usuario = ? AND id_producto = ?
");
$stmt->execute([$id_usuario, $id_producto]);

/* volver al carrito */
header("Location: ../../carrito.php");
exit();
