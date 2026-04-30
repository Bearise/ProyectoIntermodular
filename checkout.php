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
            <p><strong><?= htmlspecialchars($item['nombre']); ?></strong></p>
            <p>Cantidad: <?= htmlspecialchars($item['cantidad']); ?></p>
            <p>Precio: <?= number_format($item['precio'], 2); ?> €</p>
          </div>
        <?php endforeach; ?>
      </div>

      <p><strong>Total: <?= number_format($total, 2); ?> €</strong></p>

      <h2 class="perfil-subtitle">Selecciona dirección</h2>

      <?php if (count($direcciones) === 0): ?>

        <div class="auth-error">
          Para finalizar tu pedido necesitas añadir una dirección de envío. ¡Ve a tu cuenta y añádela!
        </div>

        <div class="perfil-acciones">
          <a href="agregar_direccion.php" class="auth-btn btn-principal">
            Añadir dirección
          </a>

          <a href="carrito.php" class="auth-btn btn-secundario">
            Volver al carrito
          </a>
        </div>

      <?php else: ?>

        <form action="php/pedido/procesar_checkout.php" method="POST" class="auth-form">

          <?php foreach ($direcciones as $dir): ?>
            <label class="checkout-radio-card">
              <input type="radio" name="direccion" value="<?= $dir['id_direccion']; ?>" required>

              <span>
                <?= htmlspecialchars($dir['calle']); ?>, <?= htmlspecialchars($dir['numero']); ?><br>
                <?= htmlspecialchars($dir['codigo_postal']); ?> <?= htmlspecialchars($dir['ciudad']); ?><br>
                <?= htmlspecialchars($dir['provincia']); ?>, <?= htmlspecialchars($dir['pais']); ?>
              </span>
            </label>
          <?php endforeach; ?>

          <button type="submit" class="auth-btn btn-principal">
            Confirmar pedido
          </button>

        </form>

      <?php endif; ?>

    <?php else: ?>

      <p>Tu carrito está vacío.</p>

      <div class="perfil-acciones">
        <a href="productos.php" class="auth-btn btn-principal">
          Ver productos
        </a>
      </div>

    <?php endif; ?>

  </div>
</section>

<?php include("php/includes/footer.php"); ?>
