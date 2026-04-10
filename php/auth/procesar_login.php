<?php
session_start(); // Fundamental para que la web "recuerde" al usuario
include_once '../conexion.php'; // Ruta: sube un nivel para encontrarlo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Buscamos al usuario por su email
        $sql = "SELECT * FROM USUARIO WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        // Si existe el usuario y la contraseña coincide (usando password_verify)
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Guardamos datos importantes en la sesión
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol']; // Para saber si es admin o cliente

            // Redirigimos a la página de inicio
            header("Location: ../../index.php");
            exit();
        } else {
            // Error: credenciales incorrectas
            header("Location: ../../login.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error en el login: " . $e->getMessage();
    }
}
