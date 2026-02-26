<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Solo ingresan aseadores*/
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== "hogar") {
    header("Location: login.php");
    exit;
}

/* CLIENTE Registrado*/
$idcliente = $_SESSION["id_usuario"];

try {

    $sql = "SELECT * FROM cliente WHERE id_cliente = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $idcliente]);

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        die("Usuario no encontrado");
    }

} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel-hogares</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
<style>
/* menú tipo lista */
.nav-link img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 10px;
}
</style>
</head>

<body>
<!-- Menú -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
  <div class="container-fluid justify-content-between align-items-center">
   <img src="assets/img/LOGO-ASEAR-blanco.png" width="200">

    <div class="d-flex align-items-center text-white">
      <img src="uploads-hogares/<?php echo htmlspecialchars($cliente['foto_rostro']); ?>" 
           alt="Perfil" 
           class="rounded-circle" 
           width="50" height="50">
      <div class="ms-2">
        <span class="fw-bold"><?php echo htmlspecialchars($cliente['nombre']); ?></span>
      </div>
    </div>

    <!-- Botón menú -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuCliente" aria-controls="menuCliente" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido menú -->
    <div class="collapse navbar-collapse justify-content-end" id="menuAseador">
      <ul class="navbar-nav text-center mb-2 mb-lg-0">
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="#">Mi Perfil</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="#">Mis Servicios</a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white" href="logout.php">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Pricing Section -->
    <section id="pricing" class="pricing section light-background">
<div class="text-center mb-4">
<img src="assets/img/LOGO-ASEAR.png" alt="Logo" width="200">
</div>
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>¡Bienvenido(a)!</h2>
        <p>Antes de solicitar tu servicio verifica que tipo de limpieza incluye.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 justify-content-center">

          <!-- Basic Plan -->
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="pricing-card">
              <h3>Limpieza Express</h3>
              <p class="description">Ideal para mantener el orden y la limpieza diaria del hogar.
Nos enfocamos en las áreas de mayor uso para que tu espacio se vea y se sienta limpio rápidamente.</p>

              <h4>Incluye:</h4>
              <ul class="features-list">
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                  Barrido y trapeado de pisos.

                </li>
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                Limpieza superficial de muebles y mesas.

                </li>
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                  Limpieza de cocina (lavado de platos si son pocos, mesones, estufa).

                </li>

                <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Limpieza rápida de baño (lavamanos, inodoro y espejo).
                </li>

                  <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Sacudir polvo de superficies visibles.
                </li>

                  <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Vaciado de basureros.
                </li>
                
                   <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Organización ligera de espacios (camas, cojines, etc.)
                </li>
              </ul>

              <a href="solicitar-servicio.php?servicio=express" class="btn btn-primary">
               Solicitar limpieza express
              </a> 
            </div>
          </div>

          <!-- Standard Plan -->
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="pricing-card popular">
              <h3>Limpieza profunda</h3>
              <p class="description">Servicio completo y detallado para una limpieza a fondo del hogar. Incluye zonas visibles y no visibles, garantizando un espacio higiénico y renovado.</p>

              <h4>Incluye:</h4>
              <ul class="features-list">
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                  Desinfección profunda de baños y cocina (grifería, azulejos, duchas, lavamanos, etc.)

                </li>
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Limpieza interior y exterior de electrodomésticos (nevera, microondas, horno según necesidad.)
                </li>
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Limpieza profunda de pisos (incluye rincones y áreas escondidas.)
                </li>
                <li>
                  <i class="bi bi-check-circle-fill"></i>
                  Limpieza de rodapiés, marcos de puertas y ventanas.

                </li>

                <li>
                  <i class="bi bi-check-circle-fill"></i>
                  Limpieza de muebles a profundidad (superiores, inferiores, detrás.)
                </li>

                <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Retiro de polvo en zonas altas y bajas.

                </li>

                <li>
                  <i class="bi bi-check-circle-fill"></i>
                 Lavado y desinfección de canecas y áreas de basura.

                </li>
              </ul>

              <a href="solicitar-servicio.php?servicio=profunda" class="btn btn-primary">
              Solicitar limpieza profunda
              </a>
            </div>
          </div>
         
    </section><!-- /Pricing Section -->
</body>
</html>
 