<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];
$id_direccion = $_POST['direccion'];

/* ========= OBTENER CARRITO ========= */
$stmt = $pdo->prepare("
    SELECT c.*, p.precio
    FROM carrito c
    JOIN producto p ON c.id_producto = p.id_producto
    WHERE c.id_usuario = ?
");
$stmt->execute([$id_usuario]);
$carrito = $stmt->fetchAll();

/* ========= CALCULAR TOTAL ========= */
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

/* ========= CREAR PEDIDO ========= */
$stmt = $pdo->prepare("
    INSERT INTO pedido (fecha_pedido, estado_pedido, total, id_direccion, id_usuario)
    VALUES (NOW(), 'pendiente', ?, ?, ?)
");
$stmt->execute([$total, $id_direccion, $id_usuario]);

$id_pedido = $pdo->lastInsertId();

/* ========= INSERTAR PRODUCTOS ========= */
$stmt = $pdo->prepare("
    INSERT INTO pedido_producto (id_pedido, id_producto, cantidad, precio_unitario)
    VALUES (?, ?, ?, ?)
");

foreach ($carrito as $item) {
    $stmt->execute([
        $id_pedido,
        $item['id_producto'],
        $item['cantidad'],
        $item['precio']
    ]);
}

/* ========= VACIAR CARRITO ========= */
$stmt = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);

/* ========= REDIRIGIR ========= */
header("Location: ../../mis_pedidos.php");
exit();
