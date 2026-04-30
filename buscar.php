<?php
include_once 'php/conexion.php';

$css_extra = 'products.css';

$busqueda = trim($_GET['q'] ?? '');

$resultados = [];

if ($busqueda !== '') {
    $stmt = $pdo->prepare("
        SELECT *
        FROM producto
        WHERE nombre LIKE ?
           OR descripcion LIKE ?
        ORDER BY nombre ASC
    ");

    $termino = '%' . $busqueda . '%';
    $stmt->execute([$termino, $termino]);
    $resultados = $stmt->fetchAll();
}

include("php/includes/header.php");
?>

<section class="products search-mode">

  <div class="products-container">

    <div class="products-header reveal active">
      <h2>Resultados de búsqueda</h2>

      <?php if ($busqueda !== ''): ?>
        <p class="lead">
          Resultados para: <span class="search-highlight"><?= htmlspecialchars($busqueda); ?></span>
        </p>
      <?php else: ?>
        <p class="lead">
          Introduce un término de búsqueda.
        </p>
      <?php endif; ?>
    </div>

    <?php if ($busqueda !== '' && count($resultados) > 0): ?>

      <div class="products-grid">

        <?php foreach ($resultados as $p): ?>
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

    <?php elseif ($busqueda !== ''): ?>

      <p class="lead" style="text-align:center;">
        No se han encontrado productos relacionados con tu búsqueda.
      </p>

    <?php endif; ?>

  </div>

</section>

<?php include("php/includes/footer.php"); ?>
