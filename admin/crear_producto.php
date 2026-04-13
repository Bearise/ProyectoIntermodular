<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include_once '../php/conexion.php';

/* Obtener categorías para el select */
$stmt = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre ASC");
$categorias = $stmt->fetchAll();

$css_extra = 'auth.css';
include("../php/includes/header.php");

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<section class="auth-section">
  <div class="auth-card admin-form-card">
    <h1>Crear producto</h1>
    <p class="auth-subtitle">
      Añade un nuevo producto al catálogo de Velvia.
    </p>

    <?php if ($error === 'campos_vacios'): ?>
      <div class="auth-error">Debes rellenar todos los campos obligatorios.</div>
    <?php elseif ($error === 'error_insert'): ?>
      <div class="auth-error">No se pudo crear el producto. Inténtalo de nuevo.</div>
    <?php endif; ?>

    <?php if ($success === 'ok'): ?>
      <div class="auth-success">Producto creado correctamente.</div>
    <?php endif; ?>

    <form action="/ProyectoIntermodular/php/admin/procesar_crear_producto.php" method="POST" class="auth-form">

      <div class="auth-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>

      <div class="auth-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
      </div>

      <div class="auth-group">
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required>
      </div>

      <div class="auth-group">
        <label for="imagen">Ruta de la imagen</label>
        <input type="text" id="imagen" name="imagen" placeholder="assets/images/productos/mi-producto.png" required>
      </div>

      <div class="auth-group">
        <label for="id_categoria">Categoría</label>
        <select id="id_categoria" name="id_categoria" required>
          <option value="">Selecciona una categoría</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id_categoria']; ?>">
              <?= htmlspecialchars($categoria['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="auth-group">
        <label for="seguro_hogar">¿Seguro en el hogar?</label>
        <select id="seguro_hogar" name="seguro_hogar" required>
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
      </div>

      <div class="perfil-acciones">
        <button type="submit" class="auth-btn btn-principal">Guardar producto</button>
        <a href="productos.php" class="auth-btn btn-secundario">Volver</a>
      </div>

    </form>
  </div>
</section>

<?php include("../php/includes/footer.php"); ?>
