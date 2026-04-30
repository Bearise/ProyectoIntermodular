<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

$stmt = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);

header("Location: ../../carrito.php");
exit();
