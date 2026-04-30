<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../carrito.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];
$id_producto = $_POST['id_producto'] ?? null;
$cantidad = $_POST['cantidad'] ?? 1;

$cantidad = (int)$cantidad;

if (!$id_producto || $cantidad < 1) {
    header("Location: ../../carrito.php");
    exit();
}

$stmt = $pdo->prepare("
    UPDATE carrito
    SET cantidad = ?
    WHERE id_usuario = ? AND id_producto = ?
");

$stmt->execute([$cantidad, $id_usuario, $id_producto]);

header("Location: ../../carrito.php");
exit();
