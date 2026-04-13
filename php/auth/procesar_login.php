<?php
session_start();
include_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../login.php');
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: ../../login.php?error=campos_vacios');
    exit();
}

// Buscar usuario por email
$stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario['password'])) {
    header('Location: ../../login.php?error=credenciales');
    exit();
}

// Guardar sesión
$_SESSION['usuario'] = [
    'id' => $usuario['id_usuario'],
    'nombre' => $usuario['nombre'],
    'apellidos' => $usuario['apellidos'],
    'email' => $usuario['email'],
    'rol' => $usuario['rol']
];

header('Location: ../../index.php');
exit();

