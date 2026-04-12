<?php
session_start();
include_once '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../agregar_direccion.php');
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

$calle = trim($_POST['calle'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$provincia = trim($_POST['provincia'] ?? '');
$codigo_postal = trim($_POST['codigo_postal'] ?? '');
$pais = trim($_POST['pais'] ?? '');

if (
    empty($calle) ||
    empty($numero) ||
    empty($ciudad) ||
    empty($provincia) ||
    empty($codigo_postal) ||
    empty($pais)
) {
    header('Location: ../../agregar_direccion.php?error=campos_vacios');
    exit();
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO direccion (
            id_usuario,
            calle,
            numero,
            ciudad,
            provincia,
            codigo_postal,
            pais
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $id_usuario,
        $calle,
        $numero,
        $ciudad,
        $provincia,
        $codigo_postal,
        $pais
    ]);

    header('Location: ../../perfil.php');
    exit();

} catch (PDOException $e) {
    header('Location: ../../agregar_direccion.php?error=error_insert');
    exit();
}

