<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../admin/crear_producto.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$imagen = trim($_POST['imagen'] ?? '');
$id_categoria = trim($_POST['id_categoria'] ?? '');
$seguro_hogar = trim($_POST['seguro_hogar'] ?? '');

if (
    $nombre === '' ||
    $descripcion === '' ||
    $precio === '' ||
    $imagen === '' ||
    $id_categoria === '' ||
    $seguro_hogar === ''
) {
    header("Location: ../../admin/crear_producto.php?error=campos_vacios");
    exit();
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO producto (nombre, descripcion, precio, imagen, id_categoria, seguro_hogar)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $nombre,
        $descripcion,
        $precio,
        $imagen,
        $id_categoria,
        $seguro_hogar
    ]);

    header("Location: ../../admin/crear_producto.php?success=ok");
    exit();

} catch (PDOException $e) {
    header("Location: ../../admin/crear_producto.php?error=error_insert");
    exit();
}
