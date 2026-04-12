<?php
$css_extra = 'auth.css';
include("php/includes/header.php");

$error = $_GET['error'] ?? '';
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Crear cuenta</h1>
    <p class="auth-subtitle">
      Regístrate para guardar tus datos y hacer tus pedidos más fácilmente.
    </p>

    <?php if ($error === 'campos_vacios'): ?>
      <div class="auth-error">Debes rellenar todos los campos.</div>
    <?php elseif ($error === 'passwords_no_coinciden'): ?>
      <div class="auth-error">Las contraseñas no coinciden.</div>
    <?php elseif ($error === 'email_duplicado'): ?>
      <div class="auth-error">Ya existe una cuenta con ese correo electrónico.</div>
    <?php endif; ?>

    <form action="php/auth/procesar_registro.php" method="POST" class="auth-form">

      <div class="auth-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>

      <div class="auth-group">
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" required>
      </div>

      <div class="auth-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="auth-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="auth-group">
        <label for="confirmar_password">Confirmar contraseña</label>
        <input type="password" id="confirmar_password" name="confirmar_password" required>
      </div>

      <button type="submit" class="auth-btn">Crear cuenta</button>
    </form>

    <p class="auth-footer">
      ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </p>
  </div>
</section>

<?php include("php/includes/footer.php"); ?>


