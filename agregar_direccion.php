<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$css_extra = 'auth.css';
include("php/includes/header.php");

$error = $_GET['error'] ?? '';
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Añadir dirección</h1>
    <p class="auth-subtitle">
      Guarda una nueva dirección para usarla en tus pedidos.
    </p>

    <?php if ($error === 'campos_vacios'): ?>
      <div class="auth-error">Debes rellenar todos los campos.</div>
    <?php elseif ($error === 'error_insert'): ?>
      <div class="auth-error">No se pudo guardar la dirección. Inténtalo de nuevo.</div>
    <?php endif; ?>

    <form action="php/direcciones/procesar_agregar.php" method="POST" class="auth-form">
      <div class="auth-group">
        <label for="calle">Calle</label>
        <input type="text" id="calle" name="calle" required>
      </div>

      <div class="auth-group">
        <label for="numero">Número</label>
        <input type="text" id="numero" name="numero" required>
      </div>

      <div class="auth-group">
        <label for="ciudad">Ciudad</label>
        <input type="text" id="ciudad" name="ciudad" required>
      </div>

      <div class="auth-group">
        <label for="provincia">Provincia</label>
        <input type="text" id="provincia" name="provincia" required>
      </div>

      <div class="auth-group">
        <label for="codigo_postal">Código postal</label>
        <input type="text" id="codigo_postal" name="codigo_postal" required>
      </div>

      <div class="auth-group">
        <label for="pais">País</label>
        <input type="text" id="pais" name="pais" value="España" required>
      </div>

      <button type="submit" class="auth-btn">Guardar dirección</button>
    </form>

    <p class="auth-footer">
      <a href="perfil.php">Volver a mi cuenta</a>
    </p>
  </div>
</section>

<?php include("php/includes/footer.php"); ?>
