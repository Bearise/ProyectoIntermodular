<?php
include_once 'php/conexion.php';

$css_extra = 'products.css';

// Obtener categorías
$stmt = $pdo->query("SELECT * FROM categoria");
$categorias = $stmt->fetchAll();

// Función productos por categoría
function obtenerProductos($pdo, $id_cat) {
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE id_categoria = ?");
    $stmt->execute([$id_cat]);
    return $stmt->fetchAll();
}

// Función para generar ids tipo ancla
function generarIdCategoria($nombre) {
    $id = mb_strtolower(trim($nombre), 'UTF-8');
    $id = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ', ' '],
        ['a', 'e', 'i', 'o', 'u', 'n', '-'],
        $id
    );
    return $id;
}
?>

<?php include("php/includes/header.php"); ?>

<section class="products" id="productos">

  <div class="products-container">

    <div class="products-header reveal active">
      <h2>Nuestros Productos</h2>
      <p class="lead">
        Descubre nuestras creaciones artesanales, hechas con amor y cuidado. Cada familia tiene su propia esencia.
      </p>
    </div>

    <?php foreach ($categorias as $cat): ?>
      <div class="product-family reveal active" id="<?= generarIdCategoria($cat['nombre']); ?>">
        <h3><?= htmlspecialchars($cat['nombre']); ?></h3>

        <?php if (!empty($cat['descripcion'])): ?>
          <p class="categoria-desc"><?= htmlspecialchars($cat['descripcion']); ?></p>
        <?php endif; ?>

        <div class="products-grid">
          <?php $productos = obtenerProductos($pdo, $cat['id_categoria']); ?>

          <?php foreach ($productos as $p): ?>
            <div class="product-card">
              <a href="producto.php?id=<?= $p['id_producto']; ?>">
                <img src="<?= htmlspecialchars($p['imagen']); ?>" alt="<?= htmlspecialchars($p['nombre']); ?>">
              </a>

              <h4>
                <a href="producto.php?id=<?= $p['id_producto']; ?>">
                  <?= htmlspecialchars($p['nombre']); ?>
                </a>
              </h4>

              <p class="precio"><?= number_format($p['precio'], 2); ?>€</p>

              <?php if ($p['seguro_hogar'] == 0): ?>
                <small class="warning">⚠ Uso con precaución</small>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

</section>

<?php include("php/includes/footer.php"); ?>

