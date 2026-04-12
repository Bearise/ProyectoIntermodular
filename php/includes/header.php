<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvia</title>

  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo/favicon.png">
  <link rel="stylesheet" href="/ProyectoIntermodular/css/styles.css">

  <?php if (isset($css_extra)): ?>
    <link rel="stylesheet" href="css/<?php echo $css_extra; ?>">
  <?php endif; ?>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<header class="header">

  <div class="left-section">
    <i class="fa-solid fa-bars menu-icon" id="menuBtn"></i>

    <nav class="nav-links">
      <a href="conocenos.php">CONÓCENOS</a>
      <a href="productos.php">PRODUCTOS</a>
      <a href="blog.php">BLOG</a>
    </nav>
  </div>

  <div class="logo">
    <a href="index.php">
      <img src="assets/images/logo/logo.png" alt="Logo Velvia">
    </a>
  </div>

  <div class="right-section">

  <div class="search-box">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" placeholder="Search">
  </div>

  <?php if (isset($_SESSION['usuario'])): ?>
  <div class="user-menu">
    <button class="user-menu-btn" id="userMenuBtn" type="button">
      <span class="user-name">
        <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?>
      </span>
      <i class="fa-regular fa-user icon"></i>
    </button>

    <div class="user-dropdown" id="userDropdown">
      <a href="perfil.php">Mi cuenta</a>
      <a href="mis_pedidos.php">Mis pedidos</a>
      <a href="php/auth/logout.php">Cerrar sesión</a>
    </div>
  </div>
<?php else: ?>
  <a href="login.php">
    <i class="fa-regular fa-user icon"></i>
  </a>
<?php endif; ?>

  <div class="cart-icon">
  <a href="carrito.php">
    <i class="fa-solid fa-bag-shopping icon"></i>

    <?php
    if (isset($_SESSION['usuario'])) {
        include_once 'php/conexion.php';

        $stmt = $pdo->prepare("
            SELECT SUM(cantidad) as total
            FROM carrito
            WHERE id_usuario = ?
        ");
        $stmt->execute([$_SESSION['usuario']['id']]);
        $resultado = $stmt->fetch();

        if ($resultado['total'] > 0):
    ?>
        <span class="cart-count"><?= $resultado['total']; ?></span>
    <?php
        endif;
    }
    ?>
  </a>
</div>

 </div>

</header>
