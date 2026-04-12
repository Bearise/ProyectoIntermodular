<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include_once 'php/conexion.php';

$id_usuario = $_SESSION['usuario']['id'];

/* ========= CARRITO ========= */
$stmt = $pdo->prepare("
    SELECT c.*, p.nombre, p.precio
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

/* ========= DIRECCIONES ========= */
$stmt = $pdo->prepare("SELECT * FROM direccion WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$direcciones = $stmt->fetchAll();

$css_extra = 'auth.css';
include("php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Checkout</h1>

    <h2 class="perfil-subtitle">Tu carrito</h2>

    <?php if (count($carrito) > 0): ?>

      <div class="pedidos-list">
        <?php foreach ($carrito as $item): ?>
          <div class="pedido-card">
            <p><strong><?= $item['nombre']; ?></strong></p>
            <p>Cantidad: <?= $item['cantidad']; ?></p>
            <p>Precio: <?= $item['precio']; ?> €</p>
          </div>
        <?php endforeach; ?>
      </div>

      <p><strong>Total: <?= number_format($total, 2); ?> €</strong></p>

    <?php else: ?>
      <p>Tu carrito está vacío.</p>
    <?php endif; ?>

    <h2 class="perfil-subtitle">Selecciona dirección</h2>

    <form action="php/pedido/procesar_checkout.php" method="POST">

      <?php foreach ($direcciones as $dir): ?>
        <label style="display:block; margin-bottom:10px;">
          <input type="radio" name="direccion" value="<?= $dir['id_direccion']; ?>" required>

          <?= $dir['calle']; ?>, <?= $dir['numero']; ?>,
          <?= $dir['codigo_postal']; ?> <?= $dir['ciudad']; ?>
        </label>
      <?php endforeach; ?>

      <button type="submit" class="auth-btn btn-principal">
        Confirmar pedido
      </button>

    </form>

  </div>
</section>

<?php include("php/includes/footer.php"); ?>
