<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: pedidos.php");
    exit();
}

include_once '../php/conexion.php';

$id_pedido = $_GET['id'];
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

/* DATOS DEL PEDIDO */
$stmt = $pdo->prepare("
    SELECT p.*, u.nombre, u.email
    FROM pedido p
    JOIN usuario u ON p.id_usuario = u.id_usuario
    WHERE p.id_pedido = ?
");
$stmt->execute([$id_pedido]);
$pedido = $stmt->fetch();

if (!$pedido) {
    header("Location: pedidos.php");
    exit();
}

/* PRODUCTOS DEL PEDIDO */
$stmt = $pdo->prepare("
    SELECT pp.*, pr.nombre, pr.imagen
    FROM pedido_producto pp
    JOIN producto pr ON pp.id_producto = pr.id_producto
    WHERE pp.id_pedido = ?
");
$stmt->execute([$id_pedido]);
$productos = $stmt->fetchAll();

$css_extra = 'auth.css';
include("../php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card admin-form-card">

    <h1>Pedido #<?= htmlspecialchars($pedido['id_pedido']); ?></h1>
    <p class="auth-subtitle">
      Consulta la información del pedido y actualiza su estado.
    </p>

    <?php if ($success === 'estado_ok'): ?>
      <div class="auth-success">Estado del pedido actualizado correctamente.</div>
    <?php endif; ?>

    <?php if ($error === 'estado'): ?>
      <div class="auth-error">El estado seleccionado no es válido.</div>
    <?php elseif ($error === 'update'): ?>
      <div class="auth-error">No se pudo actualizar el estado del pedido.</div>
    <?php endif; ?>

    <div class="pedido-card">
      <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['nombre']); ?> (<?= htmlspecialchars($pedido['email']); ?>)</p>
      <p><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha_pedido']); ?></p>
      <p><strong>Estado actual:</strong> 
        <?= !empty($pedido['estado_pedido']) ? htmlspecialchars($pedido['estado_pedido']) : 'Sin definir'; ?>
      </p>
      <p><strong>Total:</strong> <?= number_format($pedido['total'], 2); ?> €</p>
    </div>

    <h2 class="perfil-subtitle">Actualizar estado</h2>

    <form action="/ProyectoIntermodular/php/admin/procesar_estado_pedido.php" method="POST" class="auth-form">
      <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedido']); ?>">

      <div class="auth-group">
        <label for="estado_pedido">Estado del pedido</label>
        <select id="estado_pedido" name="estado_pedido" required>
          <option value="pendiente" <?= ($pedido['estado_pedido'] === 'pendiente' || empty($pedido['estado_pedido'])) ? 'selected' : ''; ?>>Pendiente</option>
          <option value="pagado" <?= $pedido['estado_pedido'] === 'pagado' ? 'selected' : ''; ?>>Pagado</option>
          <option value="enviado" <?= $pedido['estado_pedido'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
          <option value="entregado" <?= $pedido['estado_pedido'] === 'entregado' ? 'selected' : ''; ?>>Entregado</option>
        </select>
      </div>

      <div class="perfil-acciones">
        <button type="submit" class="auth-btn btn-principal">Guardar estado</button>
        <a href="pedidos.php" class="auth-btn btn-secundario">Volver</a>
      </div>
    </form>

    <h2 class="perfil-subtitle">Productos del pedido</h2>

    <div class="productos-list">
      <?php foreach ($productos as $prod): ?>
        <div class="producto-linea">
          <img src="/ProyectoIntermodular/<?= htmlspecialchars($prod['imagen']); ?>" alt="<?= htmlspecialchars($prod['nombre']); ?>" class="producto-img">

          <div class="producto-info">
            <p><strong><?= htmlspecialchars($prod['nombre']); ?></strong></p>
            <p>Cantidad: <?= htmlspecialchars($prod['cantidad']); ?></p>
            <p>Precio unitario: <?= number_format($prod['precio_unitario'], 2); ?> €</p>
            <p>Subtotal: <?= number_format($prod['cantidad'] * $prod['precio_unitario'], 2); ?> €</p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php include("../php/includes/footer.php"); ?>
