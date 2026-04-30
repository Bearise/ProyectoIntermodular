<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

include_once '../conexion.php';

$id_usuario = $_SESSION['usuario']['id'];
$id_direccion = $_POST['id_direccion'] ?? null;

if (!$id_direccion) {
    header("Location: ../../perfil.php");
    exit();
}

/* Comprobar si la dirección pertenece al usuario */
$stmt = $pdo->prepare("
    SELECT id_direccion
    FROM direccion
    WHERE id_direccion = ? AND id_usuario = ?
");
$stmt->execute([$id_direccion, $id_usuario]);
$direccion = $stmt->fetch();

if (!$direccion) {
    header("Location: ../../perfil.php?error=direccion_no_valida");
    exit();
}

/* Comprobar si la dirección ya está asociada a algún pedido */
$stmt = $pdo->prepare("
    SELECT COUNT(*) AS total
    FROM pedido
    WHERE id_direccion = ? AND id_usuario = ?
");
$stmt->execute([$id_direccion, $id_usuario]);
$resultado = $stmt->fetch();

if ($resultado['total'] > 0) {
    header("Location: ../../perfil.php?error=direccion_con_pedidos");
    exit();
}

/* Si no tiene pedidos asociados, se puede eliminar */
$stmt = $pdo->prepare("
    DELETE FROM direccion
    WHERE id_direccion = ? AND id_usuario = ?
");
$stmt->execute([$id_direccion, $id_usuario]);

header("Location: ../../perfil.php?success=direccion_eliminada");
exit();
