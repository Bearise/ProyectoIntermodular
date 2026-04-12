<?php
include_once 'php/conexion.php';

// CSS extra de esta página
$css_extra = 'products.css';

// Validar ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: productos.php");
    exit();
}

$id = $_GET['id'];

// Obtener producto
$stmt = $pdo->prepare("
    SELECT p.*, c.nombre AS categoria_nombre
    FROM producto p
    JOIN categoria c ON p.id_categoria = c.id_categoria
    WHERE p.id_producto = ?
");

$stmt->execute([$id]);
$producto = $stmt->fetch();

// Si no existe
if (!$producto) {
    echo "Producto no encontrado";
    exit();
}
?>

<?php include("php/includes/header.php"); ?>

<section class="producto-detalle">

  <div class="producto-container">

    <div class="producto-img">
      <img src="<?= $producto['imagen']; ?>" alt="<?= $producto['nombre']; ?>">
    </div>

    <div class="producto-info">

      <span class="categoria">
        <?= $producto['categoria_nombre']; ?>
      </span>

      <h1><?= $producto['nombre']; ?></h1>

      <p class="precio"><?= number_format($producto['precio'], 2); ?>€</p>

      <?php if (!empty($producto['descripcion'])): ?>
        <p class="descripcion"><?= $producto['descripcion']; ?></p>
      <?php endif; ?>

      <?php if ($producto['seguro_hogar'] == 0): ?>
        <p class="warning">
          ⚠ Uso con precaución en hogares con mascotas o niños.
        </p>
      <?php endif; ?>

      <form action="php/carrito/agregar.php" method="POST">
        <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="1" min="1">

        <button type="submit" class="btn-carrito">
          Añadir al carrito
        </button>
      </form>

    </div>

  </div>

</section>

<?php include("php/includes/footer.php"); ?>
