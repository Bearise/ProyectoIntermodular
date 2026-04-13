<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include_once '../php/conexion.php';

$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    header("Location: productos.php");
    exit();
}

/* Obtener producto */
$stmt = $pdo->prepare("
    SELECT * FROM producto WHERE id_producto = ?
");
$stmt->execute([$id_producto]);
$producto = $stmt->fetch();

if (!$producto) {
    header("Location: productos.php");
    exit();
}

/* Obtener categorías */
$stmt = $pdo->query("
    SELECT id_categoria, nombre FROM categoria ORDER BY nombre ASC
");
$categorias = $stmt->fetchAll();

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

$css_extra = 'auth.css';
include("../php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card admin-form-card">
    <h1>Editar producto</h1>
    <p class="auth-subtitle">
      Modifica la información del producto seleccionado.
    </p>

    <?php if ($error === 'campos_vacios'): ?>
      <div class="auth-error">Debes rellenar todos los campos obligatorios.</div>
    <?php elseif ($error === 'error_update'): ?>
      <div class="auth-error">No se pudo actualizar el producto. Inténtalo de nuevo.</div>
    <?php endif; ?>

    <?php if ($success === 'ok'): ?>
      <div class="auth-success">Producto actualizado correctamente.</div>
    <?php endif; ?>

    <form action="/ProyectoIntermodular/php/admin/procesar_editar_producto.php" method="POST" class="auth-form">
      <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['id_producto']); ?>">

      <div class="auth-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']); ?>" required>
      </div>

      <div class="auth-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="5" required><?= htmlspecialchars($producto['descripcion']); ?></textarea>
      </div>

      <div class="auth-group">
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?= htmlspecialchars($producto['precio']); ?>" required>
      </div>

      <div class="auth-group">
        <label for="imagen">Ruta de la imagen</label>
        <input type="text" id="imagen" name="imagen" value="<?= htmlspecialchars($producto['imagen']); ?>" required>
      </div>

      <div class="auth-group">
        <label for="id_categoria">Categoría</label>
        <select id="id_categoria" name="id_categoria" required>
          <option value="">Selecciona una categoría</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id_categoria']; ?>"
              <?= ($categoria['id_categoria'] == $producto['id_categoria']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($categoria['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="auth-group">
        <label for="seguro_hogar">¿Seguro en el hogar?</label>
        <select id="seguro_hogar" name="seguro_hogar" required>
          <option value="1" <?= ($producto['seguro_hogar'] == 1) ? 'selected' : ''; ?>>Sí</option>
          <option value="0" <?= ($producto['seguro_hogar'] == 0) ? 'selected' : ''; ?>>No</option>
        </select>
      </div>

      <div class="perfil-acciones">
        <button type="submit" class="auth-btn btn-principal">Guardar cambios</button>
        <a href="productos.php" class="auth-btn btn-secundario">Volver</a>
      </div>
    </form>
  </div>
</section>

<?php include("../php/includes/footer.php"); ?>
