<?php
session_start();
require_once __DIR__ . "/config/db.php";

// Solo aseadores pueden entrar
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "aseador") {
    header("Location: login.php");
    exit;
}

// ID del aseador logueado
$idAseador = $_SESSION["id_usuario"];

// Traer datos del aseador de la DB
try {
    $sql = "SELECT * FROM aseador WHERE id_aseador = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $idAseador]);
    $aseador = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aseador) {
        die("Usuario no encontrado");
    }
} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}

// Decodificar disponibilidad
$disponibilidad = json_decode($aseador['disponibilidad'], true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Aseador</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
<style>
/* Ajustes rápidos para el menú tipo lista */
.nav-link img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 10px;
}
</style>
</head>
<body class="bg-light">

<!-- Navbar con hamburguesa -->
<!-- Barra superior / franja -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
  <div class="container-fluid justify-content-between align-items-center">
    <!-- Logo a la izquierda -->
   <img src="assets/img/LOGO-ASEAR-blanco.png" width="200">

    <!-- Foto y nombre del aseador alineados horizontal -->
    <div class="d-flex align-items-center text-white">
      <img src="uploads-aseadores/<?php echo htmlspecialchars($aseador['foto_rostro']); ?>" 
           alt="Perfil" 
           class="rounded-circle" 
           width="50" height="50">
      <div class="ms-2">
        <span class="fw-bold"><?php echo htmlspecialchars($aseador['nombre']); ?></span>
      </div>
    </div>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuAseador" aria-controls="menuAseador" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú -->
    <div class="collapse navbar-collapse justify-content-end" id="menuAseador">
      <ul class="navbar-nav text-center mb-2 mb-lg-0">
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="#">Mi Perfil</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="#">Mis Servicios</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="#">Disponibilidad</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="logout.php">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenido principal -->
    <section id="pricing" class="pricing section light-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>¡Bienvenido(a)!</h2>
        <p>No tienes servicios pendientes.
      </div><!-- End Section Title -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>