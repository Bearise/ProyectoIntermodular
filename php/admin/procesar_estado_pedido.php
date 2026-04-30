<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../admin/pedidos.php");
    exit();
}

$id_pedido = trim($_POST['id_pedido'] ?? '');
$estado_pedido = trim($_POST['estado_pedido'] ?? '');

$estados_validos = ['pendiente', 'pagado', 'enviado', 'entregado'];

if ($id_pedido === '' || !in_array($estado_pedido, $estados_validos, true)) {
    header("Location: ../../admin/detalle_pedido.php?id=" . urlencode($id_pedido) . "&error=estado");
    exit();
}

try {
    $stmt = $pdo->prepare("
        UPDATE pedido
        SET estado_pedido = ?
        WHERE id_pedido = ?
    ");
    $stmt->execute([$estado_pedido, $id_pedido]);

    header("Location: ../../admin/detalle_pedido.php?id=" . urlencode($id_pedido) . "&success=estado_ok");
    exit();

} catch (PDOException $e) {
    header("Location: ../../admin/detalle_pedido.php?id=" . urlencode($id_pedido) . "&error=update");
    exit();
}
