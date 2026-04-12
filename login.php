<?php
$css_extra = 'auth.css';
include("php/includes/header.php");

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Iniciar sesión</h1>
    <p class="auth-subtitle">
      Accede a tu cuenta para continuar con tu ritual de compra.
    </p>

    <?php if ($error === 'campos_vacios'): ?>
      <div class="auth-error">Debes rellenar todos los campos.</div>
    <?php elseif ($error === 'credenciales'): ?>
      <div class="auth-error">Correo o contraseña incorrectos.</div>
    <?php endif; ?>

    <?php if ($success === 'registro_ok'): ?>
      <div class="auth-success">Tu cuenta se ha creado correctamente. Ya puedes iniciar sesión.</div>
    <?php endif; ?>

    <form action="php/auth/procesar_login.php" method="POST" class="auth-form">
      <div class="auth-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="auth-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit" class="auth-btn">Entrar</button>
    </form>

    <p class="auth-footer">
      ¿No tienes cuenta? <a href="registro.php">Créala aquí</a>
    </p>
  </div>
</section>

<?php include("php/includes/footer.php"); ?>


