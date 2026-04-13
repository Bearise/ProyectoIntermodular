<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../admin/productos.php");
    exit();
}

$id_producto = trim($_POST['id_producto'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$imagen = trim($_POST['imagen'] ?? '');
$id_categoria = trim($_POST['id_categoria'] ?? '');
$seguro_hogar = trim($_POST['seguro_hogar'] ?? '');

if (
    $id_producto === '' ||
    $nombre === '' ||
    $descripcion === '' ||
    $precio === '' ||
    $imagen === '' ||
    $id_categoria === '' ||
    $seguro_hogar === ''
) {
    header("Location: ../../admin/editar_producto.php?id=" . urlencode($id_producto) . "&error=campos_vacios");
    exit();
}

try {
    $stmt = $pdo->prepare("
        UPDATE producto
        SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, id_categoria = ?, seguro_hogar = ?
        WHERE id_producto = ?
    ");

    $stmt->execute([
        $nombre,
        $descripcion,
        $precio,
        $imagen,
        $id_categoria,
        $seguro_hogar,
        $id_producto
    ]);

    header("Location: ../../admin/editar_producto.php?id=" . urlencode($id_producto) . "&success=ok");
    exit();

} catch (PDOException $e) {
    header("Location: ../../admin/editar_producto.php?id=" . urlencode($id_producto) . "&error=error_update");
    exit();
}
