<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include_once 'php/conexion.php';

$id_usuario = $_SESSION['usuario']['id'];

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
    WHERE p.id_usuario = ?
    ORDER BY p.fecha_pedido DESC
");

$stmt->execute([$id_usuario]);
$pedidos = $stmt->fetchAll();

$css_extra = 'auth.css';
include("php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Mis pedidos</h1>
    <p class="auth-subtitle">
      Aquí puedes consultar el historial de tus pedidos.
    </p>

    <?php if (count($pedidos) > 0): ?>
      <div class="pedidos-list">

        <?php foreach ($pedidos as $pedido): ?>
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
        <?php endforeach; ?>

      </div>
    <?php else: ?>
      <p>No tienes pedidos todavía.</p>
    <?php endif; ?>

  </div>
</section>

<?php include("php/includes/footer.php"); ?>
