<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once '../php/conexion.php';

$stmt = $pdo->query("
    SELECT 
        p.id_pedido,
        p.fecha_pedido,
        p.estado_pedido,
        p.total,
        u.nombre,
        u.email
    FROM pedido p
    JOIN usuario u ON p.id_usuario = u.id_usuario
    ORDER BY p.fecha_pedido DESC
");

$pedidos = $stmt->fetchAll();

$css_extra = 'auth.css';
include("../php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Pedidos</h1>

    <?php if (count($pedidos) > 0): ?>

      <div class="pedidos-list">

        <?php foreach ($pedidos as $pedido): ?>
          <div class="pedido-card">

            <p><strong>Pedido #<?= $pedido['id_pedido']; ?></strong></p>
            <p>Cliente: <?= htmlspecialchars($pedido['nombre']); ?> (<?= htmlspecialchars($pedido['email']); ?>)</p>
            <p>Fecha: <?= $pedido['fecha_pedido']; ?></p>
            <p>Total: <?= number_format($pedido['total'], 2); ?> €</p>
            <p>Estado: <?= $pedido['estado_pedido']; ?></p>

            <a href="detalle_pedido.php?id=<?= $pedido['id_pedido']; ?>" class="auth-btn btn-principal">
              Ver detalle
            </a>

          </div>
        <?php endforeach; ?>

      </div>

    <?php else: ?>
      <p>No hay pedidos.</p>
    <?php endif; ?>

  </div>
</section>

<?php include("../php/includes/footer.php"); ?>
