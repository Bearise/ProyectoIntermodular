<?php
session_start();
include_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../registro.php');
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar_password = $_POST['confirmar_password'] ?? '';

if (empty($nombre) || empty($apellidos) || empty($email) || empty($password) || empty($confirmar_password)) {
    header('Location: ../../registro.php?error=campos_vacios');
    exit();
}

if ($password !== $confirmar_password) {
    header('Location: ../../registro.php?error=passwords_no_coinciden');
    exit();
}

// Comprobar email existente
$stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
$stmt->execute([$email]);
$usuarioExistente = $stmt->fetch();

if ($usuarioExistente) {
    header('Location: ../../registro.php?error=email_duplicado');
    exit();
}

// Hash contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$stmt = $pdo->prepare("
    INSERT INTO usuario (nombre, apellidos, email, password)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([$nombre, $apellidos, $email, $passwordHash]);

header('Location: ../../login.php?success=registro_ok');
exit();

