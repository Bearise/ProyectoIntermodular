<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Velvia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
        <h2>Crear cuenta en Velvia</h2>
        
        <form action="php/auth/procesar_registro.php" method="POST">
            <p>
                <label>Nombre:</label><br>
                <input type="text" name="nombre" required>
            </p>
            <p>
                <label>Apellidos:</label><br>
                <input type="text" name="apellidos" required>
            </p>
            <p>
                <label>Email:</label><br>
                <input type="email" name="email" required>
            </p>
            <p>
                <label>Contraseña:</label><br>
                <input type="password" name="password" required>
            </p>
            <button type="submit">Registrarse</button>
        </form>
        
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
