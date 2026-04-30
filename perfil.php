<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include_once 'php/conexion.php';

$id_usuario = $_SESSION['usuario']['id'];
$usuario = $_SESSION['usuario'];

// Obtener direcciones del usuario
$stmt = $pdo->prepare("SELECT * FROM direccion WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$direcciones = $stmt->fetchAll();

$css_extra = 'auth.css';
include("php/includes/header.php");
?>

<section class="auth-section">
  <div class="auth-card">
    <h1>Mi cuenta</h1>
    <p class="auth-subtitle">
      Aquí puedes consultar los datos básicos de tu perfil.
    </p>

    <div class="perfil-datos">
      <div class="perfil-item">
        <span class="perfil-label">Nombre</span>
        <p><?= htmlspecialchars($usuario['nombre']); ?></p>
      </div>

      <div class="perfil-item">
        <span class="perfil-label">Apellidos</span>
        <p><?= htmlspecialchars($usuario['apellidos']); ?></p>
      </div>

      <div class="perfil-item">
        <span class="perfil-label">Correo electrónico</span>
        <p><?= htmlspecialchars($usuario['email']); ?></p>
      </div>
    </div>

    <h2 class="perfil-subtitle">Mis direcciones</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'direccion_con_pedidos'): ?>
          <div class="auth-error">
             No puedes eliminar esta dirección porque ya está asociada a un pedido.
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'direccion_eliminada'): ?>
          <div class="auth-success">
            Dirección eliminada correctamente.
          </div>
<?php endif; ?>
    <div class="perfil-direcciones">

      <?php if (count($direcciones) > 0): ?>

        <?php foreach ($direcciones as $dir): ?>
          <div class="direccion-card">
            <p>
              <strong>
                <?= htmlspecialchars($dir['calle']); ?>, <?= htmlspecialchars($dir['numero']); ?>
              </strong>
            </p>

            <p>
              <?= htmlspecialchars($dir['codigo_postal']); ?>
              <?= htmlspecialchars($dir['ciudad']); ?>
            </p>

            <p><?= htmlspecialchars($dir['provincia']); ?></p>
            <p><?= htmlspecialchars($dir['pais']); ?></p>

            <form 
              action="php/direcciones/eliminar.php" 
              method="POST" 
              class="form-eliminar"
              onsubmit="return confirm('¿Seguro que quieres eliminar esta dirección?');"
            >
              <input type="hidden" name="id_direccion" value="<?= $dir['id_direccion']; ?>">
              <button type="submit" class="btn-eliminar">
                Eliminar dirección
              </button>
            </form>
          </div>
        <?php endforeach; ?>

      <?php else: ?>

        <p class="no-direcciones">
          Aún no tienes direcciones guardadas.
        </p>

      <?php endif; ?>

    </div>

    <div class="perfil-acciones">

      <a href="agregar_direccion.php" class="auth-btn btn-secundario">
        Añadir dirección
      </a>

      <a href="mis_pedidos.php" class="auth-btn btn-principal">
        Mis pedidos
      </a>

      <a href="php/auth/logout.php" class="auth-btn btn-logout">
        Cerrar sesión
      </a>

    </div>
  </div>
</section>

<?php include("php/includes/footer.php"); ?>
