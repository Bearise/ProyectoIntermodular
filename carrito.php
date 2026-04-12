<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include_once 'php/conexion.php';

$id_usuario = $_SESSION['usuario']['id'];

/* ========= OBTENER CARRITO ========= */
$stmt = $pdo->prepare("
    SELECT c.*, p.nombre, p.precio, p.imagen
    FROM carrito c
    JOIN producto p ON c.id_producto = p.id_producto
    WHERE c.id_usuario = ?
");
$stmt->execute([$id_usuario]);
$carrito = $stmt->fetchAll();

/* ========= TOTAL ========= */
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

$css_extra = 'auth.css';
include("php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Tu carrito</h1>

    <?php if (count($carrito) > 0): ?>

      <div class="pedidos-list">

        <?php foreach ($carrito as $item): ?>
          <div class="pedido-card">

            <p><strong><?= htmlspecialchars($item['nombre']); ?></strong></p>
            <p>Cantidad: <?= htmlspecialchars($item['cantidad']); ?></p>
            <p>Precio: <?= number_format($item['precio'], 2); ?> €</p>

            <form action="php/carrito/eliminar.php" method="POST" class="form-eliminar">
              <input type="hidden" name="id_producto" value="<?= $item['id_producto']; ?>">
              <button type="submit" class="btn-eliminar">
                Eliminar
              </button>
            </form>

          </div>
        <?php endforeach; ?>

      </div>

      <p><strong>Total: <?= number_format($total, 2); ?> €</strong></p>

      <a href="checkout.php" class="auth-btn btn-principal">
        Ir a checkout
      </a>

    <?php else: ?>

      <p>Tu carrito está vacío.</p>

    <?php endif; ?>

  </div>
</section>

<?php include("php/includes/footer.php"); ?>
