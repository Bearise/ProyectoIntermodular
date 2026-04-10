<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Velvia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; font-family: sans-serif; border: 1px solid #eee; padding: 20px; border-radius: 10px;">
        <h2>Iniciar Sesión en Velvia</h2>

        <?php if(isset($_GET['registro']) && $_GET['registro'] == 'exito'): ?>
            <p style="color: green;">¡Registro completado! Ya puedes iniciar sesión.</p>
        <?php endif; ?>

        <form action="php/auth/procesar_login.php" method="POST">
            <p>
                <label>Email:</label><br>
                <input type="email" name="email" required style="width: 100%;">
            </p>
            <p>
                <label>Contraseña:</label><br>
                <input type="password" name="password" required style="width: 100%;">
            </p>
            <button type="submit" style="background: #c58c85; color: white; border: none; padding: 10px; width: 100%; cursor: pointer;">Entrar</button>
        </form>
        <p>¿Aún no tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
