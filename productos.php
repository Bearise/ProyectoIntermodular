<?php
include_once 'conexion.php';

// Función auxiliar para obtener productos por categoría
function obtenerProductos($pdo, $id_cat) {
    $stmt = $pdo->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = ?");
    $stmt->execute([$id_cat]);
    return $stmt->fetchAll();
}

// Cargamos las familias (según los IDs)
$velas = obtenerProductos($pdo, 1);
$balsamos = obtenerProductos($pdo, 2);
$jabones = obtenerProductos($pdo, 3);
$brumas = obtenerProductos($pdo, 4);
$aceites = obtenerProductos($pdo, 5);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - Velvia</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/products.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="logo">
      <img src="assets/images/logo/logo.png" alt="Logo Velvia">
    </div>
    <nav class="nav-links">
      <a href="index.html">INICIO</a>
      <a href="productos.php">PRODUCTOS</a>
      <a href="blog.html">BLOG</a>
      <a href="conocenos.html">CONÓCENOS</a>
    </nav>
  </header>

  <!-- SECCIÓN PRODUCTOS -->
  <section class="products" id="productos">

    <div class="products-container">

      <div class="products-header reveal active">
        <h2>Nuestros Productos</h2>
        <p class="lead">
          Descubre nuestras creaciones artesanales, hechas con amor y cuidado. Cada familia de productos tiene su propia esencia.
        </p>
      </div>

          <!-- FAMILIA VELAS -->
          <div class="product-family reveal active">
             <h3>Velas</h3>
             <div class="products-grid">
                 <?php foreach ($velas as $v): ?>
                   <div class="product-card">
                     <img src="<?php echo $v['imagen']; ?>" alt="<?php echo $v['nombre']; ?>">
                     <h4><?php echo $v['nombre']; ?></h4>
                     <p><?php echo $v['precio']; ?>€</p>

                      <?php if ($v['seguro_hogar'] == 0): ?>
                        <small style="color: #8b5c52;">
                          <i class="fas fa-exclamation-triangle"></i> Uso precavido con mascotas
                        </small>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
            </div>


          </div>
        </div>


          <!-- FAMILIA BÁLSAMOS LABIALES -->
          <div class="product-family reveal active">
            <h3>Bálsamos Labiales</h3>
            <div class="products-grid">
              <?php foreach ($balsamos as $b): ?>
                  <div class="product-card">
                       <img src="<?php echo $b['imagen']; ?>" alt="<?php echo $b['nombre']; ?>">
                      <h4><?php echo $b['nombre']; ?></h4>
                       <p><?php echo $b['precio']; ?>€</p>
                
                        <?php if ($b['seguro_hogar'] == 0): ?>
                            <small style="color: #8b5c52;">
                                <i class="fas fa-exclamation-triangle"></i> Uso precavido con mascotas/niños
                            </small>
                       <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
          </div>


          <!-- FAMILIA JABONES -->
         <div class="product-family reveal active">
              <h3>Jabones</h3>
             <div class="products-grid">
                 <?php foreach ($jabones as $j): ?>
                      <div class="product-card">
                         <img src="<?php echo $j['imagen']; ?>" alt="<?php echo $j['nombre']; ?>">
                        <h4><?php echo $j['nombre']; ?></h4>
                         <p><?php echo $j['precio']; ?>€</p>
                
                         <?php if ($j['seguro_hogar'] == 0): ?>
                             <small style="color: #8b5c52;">
                                 <i class="fas fa-exclamation-triangle"></i> Uso precavido con mascotas/niños
                             </small>
                         <?php endif; ?>
                      </div>
                  <?php endforeach; ?>
              </div>
          </div>


          <!-- FAMILIA BRUMAS -->
         <div class="product-family reveal active">
            <h3>Brumas</h3>
             <div class="products-grid">
                <?php foreach ($brumas as $br): ?>
                    <div class="product-card">
                        <img src="<?php echo $br['imagen']; ?>" alt="<?php echo $br['nombre']; ?>">
                          <h4><?php echo $br['nombre']; ?></h4>
                          <p><?php echo $br['precio']; ?>€</p>
                
                          <?php if ($br['seguro_hogar'] == 0): ?>
                             <small style="color: #8b5c52;">
                                  <i class="fas fa-exclamation-triangle"></i> Uso precavido con mascotas/niños
                              </small>
                          <?php endif; ?>
                      </div>
                  <?php endforeach; ?>
              </div>
         </div>

      

          <!-- FAMILIA ACEITES ESENCIALES -->
         <div class="product-family reveal active">
             <h3>Aceites Esenciales</h3>
              <div class="products-grid">
                  <?php foreach ($aceites as $a): ?>
                     <div class="product-card">
                        <img src="<?php echo $a['imagen']; ?>" alt="<?php echo $a['nombre']; ?>">
                        <h4><?php echo $a['nombre']; ?></h4>
                        <p><?php echo $a['precio']; ?>€</p>
                
                        <?php if ($a['seguro_hogar'] == 0): ?>
                              <small style="color: #8b5c52;">
                                 <i class="fas fa-exclamation-triangle"></i> Precaución: No difundir cerca de niños o mascotas.
                            </small>
                        <?php endif; ?>
                     </div>
                 <?php endforeach; ?>
             </div>
          </div>

      

    </div>

  </section>

  
  <script src="js/main.js"></script>


  <!-- POPUP NEWSLETTER -->
<div id="newsletterPopup" class="popup-overlay">
  <div class="popup-content">

    <span class="close-btn">&times;</span>

    <h2>Únete a nuestra comunidad</h2>
    <p>Recibe novedades, promociones y rituales exclusivos.</p>

    <form class="popup-form">
      <input type="email" placeholder="Tu correo electrónico" required>
      <button type="submit">Suscribirme</button>
    </form>

  </div>
</div>

</body>
</html>
