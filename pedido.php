<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include_once 'php/conexion.php';

$id_usuario = $_SESSION['usuario']['id'];
$id_pedido = $_GET['id'] ?? null;

if (!$id_pedido) {
    header("Location: mis_pedidos.php");
    exit();
}

/* ===== Obtener pedido ===== */
$stmt = $pdo->prepare("
    SELECT 
        p.id_pedido,
        p.fecha_pedido,
        p.estado_pedido,
        p.total,
        d.calle,
        d.numero,
        d.ciudad,
        d.provincia,
        d.codigo_postal,
        d.pais
    FROM pedido p
    LEFT JOIN direccion d ON p.id_direccion = d.id_direccion
    WHERE p.id_pedido = ? AND p.id_usuario = ?
");
$stmt->execute([$id_pedido, $id_usuario]);
$pedido = $stmt->fetch();

if (!$pedido) {
    header("Location: mis_pedidos.php");
    exit();
}

/* ===== Obtener productos del pedido ===== */
$stmt = $pdo->prepare("
    SELECT 
        pp.cantidad,
        pp.precio_unitario,
        pr.nombre,
        pr.imagen
    FROM pedido_producto pp
    JOIN producto pr ON pp.id_producto = pr.id_producto
    WHERE pp.id_pedido = ?
");
$stmt->execute([$id_pedido]);
$productos = $stmt->fetchAll();

$css_extra = 'auth.css';
include("php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Detalle del pedido</h1>
    <p class="auth-subtitle">
      Información completa de tu pedido #<?= htmlspecialchars($pedido['id_pedido']); ?>
    </p>

    <div class="pedido-card">
      <p><strong>Pedido #<?= htmlspecialchars($pedido['id_pedido']); ?></strong></p>
      <p>Fecha: <?= htmlspecialchars($pedido['fecha_pedido']); ?></p>
      <p>Estado: <?= htmlspecialchars($pedido['estado_pedido']); ?></p>
      <p>Total: <?= number_format($pedido['total'], 2); ?> €</p>

      <?php if (!empty($pedido['calle'])): ?>
        <p>
          Dirección:
          <?= htmlspecialchars($pedido['calle']); ?>, <?= htmlspecialchars($pedido['numero']); ?>,
          <?= htmlspecialchars($pedido['codigo_postal']); ?> <?= htmlspecialchars($pedido['ciudad']); ?>,
          <?= htmlspecialchars($pedido['provincia']); ?>, <?= htmlspecialchars($pedido['pais']); ?>
        </p>
      <?php endif; ?>
    </div>

    <h2 class="perfil-subtitle">Productos del pedido</h2>

    <div class="productos-list">

  <?php foreach ($productos as $producto): ?>
    <div class="producto-linea">

      <img src="<?= $producto['imagen']; ?>" class="producto-img">

      <div class="producto-info">
        <p><strong><?= htmlspecialchars($producto['nombre']); ?></strong></p>
        <p>Cantidad: <?= $producto['cantidad']; ?></p>
        <p>Precio unitario: <?= number_format($producto['precio_unitario'], 2); ?> €</p>
        <p>Subtotal: <?= number_format($producto['precio_unitario'] * $producto['cantidad'], 2); ?> €</p>
      </div>

    </div>
  <?php endforeach; ?>

</div>

    <div class="perfil-acciones">
      <a href="mis_pedidos.php" class="auth-btn btn-secundario">Volver a mis pedidos</a>
    </div>
  </div>
</section>

<?php include("php/includes/footer.php"); ?>
