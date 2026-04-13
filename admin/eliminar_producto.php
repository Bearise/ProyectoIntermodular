<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include_once '../php/conexion.php';

$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    header("Location: productos.php");
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM producto WHERE id_producto = ?");
    $stmt->execute([$id_producto]);

    header("Location: productos.php?success=eliminado");
    exit();

} catch (PDOException $e) {
    header("Location: productos.php?error=delete");
    exit();
}
