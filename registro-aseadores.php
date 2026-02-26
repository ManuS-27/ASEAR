<?php
ob_start();
require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre     = $_POST['nombre'];
    $correo     = $_POST['correo'];
    $celular    = $_POST['celular'];
    $ciudad     = $_POST['ciudad'];
    $direccion  = $_POST['direccion'];
  
    $password   = $_POST['password'];
    $confirmar  = $_POST['confirmar'];

    if ($password !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $foto_identificacion = $_FILES['foto_identificacion']['name'];
    $ruta_id = 'uploads-aseadores/' . $foto_identificacion;
    move_uploaded_file($_FILES['foto_identificacion']['tmp_name'], $ruta_id);

$experiencia = $_FILES['experiencia']['name'];
$ruta_pdf = 'uploads-aseadores/' . $experiencia;

move_uploaded_file(
    $_FILES['experiencia']['tmp_name'],
    $ruta_pdf
);

    $foto_rostro = $_FILES['foto_rostro']['name'];
    $ruta_rostro = 'uploads-aseadores/' . $foto_rostro;
    move_uploaded_file($_FILES['foto_rostro']['tmp_name'], $ruta_rostro);

    $dias = $_POST['dias'] ?? [];
    $horarios = $_POST['horarios'] ?? [];

    $disponibilidad = json_encode([
        'dias' => $dias,
        'horarios' => $horarios
    ]);

  try {

$sql = "INSERT INTO aseador
(nombre,password,foto_identificacion,foto_rostro,correo,celular,direccion,ciudad,experiencia,disponibilidad)
VALUES (?,?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $nombre,
    $pass_hash,
    $foto_identificacion,
    $foto_rostro,
    $correo,
    $celular,
    $direccion,
    $ciudad,
    $experiencia,
    $disponibilidad
]);

header("Location: login.php?registro=ok");
exit;

} catch (PDOException $e) {
    echo "Error al registrar: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de aseadores - Asear </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/registro-aseadores.css">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow-lg border-0 rounded-4 p-4 login-card">
<div class="text-center mb-4">
<img src="assets/img/LOGO-ASEAR.png" alt="Logo" width="120">
<h4 class="mt-5" >Crear Cuenta </h4>
</div>
<form id="registroForm" action="" method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label for="nombre" class="form-label">Nombre Completo</label>
<input type="text" class="form-control" id="nombre" name="nombre" required>
</div>
<div class="mb-3">
<label for="email" class="form-label">Correo Electrónico</label>
<input type="email" class="form-control" id="email" name="correo" required>
</div>
<div class="mb-3">
<label for="celular" class="form-label">Celular</label>
<input type="text" class="form-control" id="celular" name="celular" required>
</div>
<div class="mb-3">
<label for="Ciudad" class="form-label">Ciudad</label>
<input type="text" class="form-control" id="Ciudad" name="ciudad">
</div>
<div class="mb-3">
<label for="Direccion" class="form-label">Dirección</label>
<input type="text" class="form-control" id="Direccion" name="direccion">
</div>

<div class="mb-3">
  <label for="fotoIdentificacion" class="form-label">Agrega una foto de tu Identificación</label>
  <small class="text-muted d-block mb-2 texto-italic">
    Debes subir una foto clara por ambos lados de tu documento.
  </small>

  <input 
    type="file" 
    class="form-control" 
    id="fotoIdentificacion" 
    name="foto_identificacion"
    accept="image/*" 
    capture="camera" 
    required>
</div>

<div class="mb-3">
  <label for="documentoPdf" class="form-label">Sube tu hoja de vida en archivo PDF</label>
  <input 
    type="file" 
    class="form-control" 
    id="documentoPdf" 
    name="experiencia"
    accept="application/pdf"
    required>
</div>
<div class="mb-3">
<label for="password" class="form-label">Contraseña</label>
<input type="password" class="form-control" id="password" name="password">
</div>
<div class="mb-3">
<label for="confirmar" class="form-label">Confirmar Contraseña</label>
<input type="password" class="form-control" id="confirmar" name="confirmar" required>
</div>
<div class="mb-3">
  <label for="fotodePerfil" class="form-label">Agrega una foto de perfil</label>
  <small class="text-muted d-block mb-2 texto-italic">
    Sube una foto de tu rostro para tu perfil
  </small>
  <input 
    type="file" 
    class="form-control" 
    id="fotoPerfil" 
    name="foto_rostro"
    accept="image/*" 
    capture="camera" 
    required>
</div>

<label class="form-label fw-medium mt-3">Días disponibles</label>

<div class="d-flex flex-wrap gap-2">

<input type="checkbox" class="btn-check" name="dias[]" id="lunes" value="Lunes">
<label class="btn btn-outline-primary" for="lunes">Lunes</label>

<input type="checkbox" class="btn-check" name="dias[]" id="martes" value="Martes">
<label class="btn btn-outline-primary" for="martes">Martes</label>

<input type="checkbox" class="btn-check" name="dias[]" id="miercoles" value="Miércoles">
<label class="btn btn-outline-primary" for="miercoles">Miércoles</label>

<input type="checkbox" class="btn-check" name="dias[]" id="jueves" value="Jueves">
<label class="btn btn-outline-primary" for="jueves">Jueves</label>

<input type="checkbox" class="btn-check" name="dias[]" id="viernes" value="Viernes">
<label class="btn btn-outline-primary" for="viernes">Viernes</label>

<input type="checkbox" class="btn-check" name="dias[]" id="sabado" value="Sábado">
<label class="btn btn-outline-primary" for="sabado">Sábado</label>

<input type="checkbox" class="btn-check" name="dias[]" id="domingo" value="Domingo">
<label class="btn btn-outline-primary" for="domingo">Domingo</label>

</div>

<label class="form-label fw-medium mt-4">Horarios disponibles</label>

<div class="d-flex flex-wrap gap-2">

<input type="checkbox" class="btn-check" name="horarios[]" id="h1" value="6-10">
<label class="btn btn-outline-primary" for="h1">6:00 am - 10:00 am</label>

<input type="checkbox" class="btn-check" name="horarios[]" id="h2" value="10-14">
<label class="btn btn-outline-primary" for="h2">10:00 am - 2:00 pm</label>

<input type="checkbox" class="btn-check" name="horarios[]" id="h3" value="14-18">
<label class="btn btn-outline-primary" for="h3">2:00 pm - 6:00 pm</label>

</div>
<button type="submit" class="mt-5 btn btn-success w-100">Registrarse</button>
<div class="text-center mt-3">
<small>¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none">Inicia sesión</a></small>
</div>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>