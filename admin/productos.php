<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include_once '../php/conexion.php';

$stmt = $pdo->query("
    SELECT 
        p.id_producto,
        p.nombre,
        p.descripcion,
        p.precio,
        p.imagen,
        p.seguro_hogar,
        c.nombre AS categoria_nombre
    FROM producto p
    LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
    ORDER BY p.id_producto DESC
");

$productos = $stmt->fetchAll();

$css_extra = 'auth.css';
include("../php/includes/header.php");
?>

<section class="auth-section">
  <div class="admin-wrapper">
    <div class="admin-header-box">
      <h1>Panel de productos</h1>
      <p class="auth-subtitle">
        Desde aquí puedes consultar, crear, editar y eliminar productos del catálogo.
      </p>

<?php if (isset($_GET['success']) && $_GET['success'] === 'eliminado'): ?>
  <div class="auth-success">Producto eliminado correctamente.</div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'delete'): ?>
  <div class="auth-error">No se pudo eliminar el producto.</div>
<?php endif; ?>

      <div class="perfil-acciones">
        <a href="crear_producto.php" class="auth-btn btn-principal">Añadir producto</a>
      </div>
    </div>

    <?php if (count($productos) > 0): ?>
      <div class="admin-productos-list">

        <?php foreach ($productos as $producto): ?>
          <div class="admin-producto-card">

            <div class="admin-producto-img">
              <img src="/ProyectoIntermodular/<?= htmlspecialchars($producto['imagen']); ?>" alt="<?= htmlspecialchars($producto['nombre']); ?>">
            </div>

            <div class="admin-producto-info">
              <p><strong><?= htmlspecialchars($producto['nombre']); ?></strong></p>
              <p>Categoría: <?= htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría'); ?></p>
              <p>Precio: <?= number_format($producto['precio'], 2); ?> €</p>
              <p>Seguro hogar: <?= $producto['seguro_hogar'] ? 'Sí' : 'No'; ?></p>

              <?php if (!empty($producto['descripcion'])): ?>
                <p><?= htmlspecialchars($producto['descripcion']); ?></p>
              <?php endif; ?>
            </div>

            <div class="admin-producto-acciones">
              <a href="editar_producto.php?id=<?= $producto['id_producto']; ?>" class="auth-btn btn-secundario">
                Editar
              </a>

              <a href="eliminar_producto.php?id=<?= $producto['id_producto']; ?>" class="auth-btn btn-logout" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
                Eliminar
              </a>
            </div>

          </div>
        <?php endforeach; ?>

      </div>
    <?php else: ?>
      <p>No hay productos registrados todavía.</p>
    <?php endif; ?>
  </div>
</section>

<?php include("../php/includes/footer.php"); ?>
