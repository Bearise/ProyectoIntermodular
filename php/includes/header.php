<?php
/**
 * HEADER GLOBAL - VELVIA
 * 
 * Este archivo se incluye en todas las páginas.
 * Contiene la cabecera principal, navegación, usuario y carrito.
 * Permite reutilizar estructura y mantener coherencia en toda la web.
 */

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">

  <!-- Responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Velvia</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="/ProyectoIntermodular/assets/images/logo/favicon.png">

  <!-- Estilos globales -->
  <link rel="stylesheet" href="/ProyectoIntermodular/css/styles.css?v=11">

  <!-- Estilos específicos de cada página -->
  <?php if (isset($css_extra)): ?>
    <link rel="stylesheet" href="/ProyectoIntermodular/css/<?php echo $css_extra; ?>">
  <?php endif; ?>

  <!-- Iconos (Font Awesome) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<header class="header">

  <!-- ==========================
       SECCIÓN IZQUIERDA (MENÚ + NAVEGACIÓN)
  =========================== -->
  <div class="left-section">

    <!-- Botón menú lateral -->
    <i class="fa-solid fa-bars menu-icon" id="menuBtn"></i>

    <!-- Navegación principal -->
    <nav class="nav-links">
      <a href="/ProyectoIntermodular/conocenos.php">CONÓCENOS</a>
      <a href="/ProyectoIntermodular/productos.php">PRODUCTOS</a>
      <a href="/ProyectoIntermodular/blog.php">BLOG</a>
    </nav>
  </div>

  <!-- ==========================
       LOGO CENTRAL
  =========================== -->
  <div class="logo">
    <a href="/ProyectoIntermodular/index.php">
      <img src="/ProyectoIntermodular/assets/images/logo/logo.png" alt="Logo Velvia">
    </a>
  </div>

  <!-- ==========================
       SECCIÓN DERECHA (BUSCADOR, USUARIO, CARRITO)
  =========================== -->
  <div class="right-section">

    <!-- Buscador -->
    <form class="search-box" action="/ProyectoIntermodular/buscar.php" method="GET">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" name="q" placeholder="Buscar productos..." required>
    </form>

    <!-- ==========================
         MENÚ USUARIO
    =========================== -->
    <?php if (isset($_SESSION['usuario'])): ?>
      
      <!-- Usuario logueado -->
      <div class="user-menu">

        <!-- Botón que despliega el menú -->
        <button class="user-menu-btn" id="userMenuBtn" type="button">
          <span class="user-name">
            <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?>
          </span>
          <i class="fa-regular fa-user icon"></i>
        </button>

        <!-- Dropdown del usuario -->
        <div class="user-dropdown" id="userDropdown">

          <!-- Opciones básicas -->
          <a href="/ProyectoIntermodular/perfil.php">Mi cuenta</a>
          <a href="/ProyectoIntermodular/mis_pedidos.php">Mis pedidos</a>

          <!-- Opciones solo visibles para administradores -->
          <?php if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
            <a href="/ProyectoIntermodular/admin/productos.php">Admin productos</a>
            <a href="/ProyectoIntermodular/admin/pedidos.php">Admin pedidos</a>
          <?php endif; ?>

          <!-- Logout -->
          <a href="/ProyectoIntermodular/php/auth/logout.php">Cerrar sesión</a>
        </div>
      </div>

    <?php else: ?>

      <!-- Usuario no logueado -->
      <a href="/ProyectoIntermodular/login.php">
        <i class="fa-regular fa-user icon"></i>
      </a>

    <?php endif; ?>

    <!-- ==========================
         ICONO CARRITO
    =========================== -->
    <div class="cart-icon">
      <a href="/ProyectoIntermodular/carrito.php">
        <i class="fa-solid fa-bag-shopping icon"></i>

        <?php
        /**
         * Mostrar número total de productos en el carrito
         * Solo si el usuario está logueado
         */
        if (isset($_SESSION['usuario'])) {

            // Conexión a base de datos
            include_once __DIR__ . '/../conexion.php';

            // Sumar cantidades del carrito del usuario
            $stmt = $pdo->prepare("
                SELECT SUM(cantidad) as total
                FROM carrito
                WHERE id_usuario = ?
            ");
            $stmt->execute([$_SESSION['usuario']['id']]);
            $resultado = $stmt->fetch();

            // Mostrar contador solo si hay productos
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

<!-- ==========================
     MENÚ LATERAL (CATEGORÍAS)
========================== -->
<aside class="side-menu" id="sideMenu">
  <ul>
    <!-- Navegación principal para versión móvil -->
    <li><a href="/ProyectoIntermodular/conocenos.php">Conócenos</a></li>
    <li><a href="/ProyectoIntermodular/productos.php">Productos</a></li>
    <li><a href="/ProyectoIntermodular/blog.php">Blog</a></li>

    <li class="side-menu-separator"></li>

    <!-- Familias de productos -->
    <li><a href="/ProyectoIntermodular/productos.php#velas">Velas</a></li>
    <li><a href="/ProyectoIntermodular/productos.php#balsamos">Bálsamos</a></li>
    <li><a href="/ProyectoIntermodular/productos.php#jabones">Jabones</a></li>
    <li><a href="/ProyectoIntermodular/productos.php#brumas">Brumas</a></li>
    <li><a href="/ProyectoIntermodular/productos.php#aceites-esenciales">Aceites esenciales</a></li>
    <li><a href="/ProyectoIntermodular/productos.php#packs">Packs</a></li>
  </ul>
</aside>


