<?php 
    // ===== conexión base datos =====
require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $nombre = $_POST["nombre"];
    $correo = $_POST["email"];
    $celular = $_POST["celular"];
    $ciudad = $_POST["ciudad"];
    $barrio = $_POST["barrio"];
    $direccion = $_POST["direccion"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);


    $fotoIdentificacion = "";
    if(isset($_FILES["foto_identificacion"])) {
        $nombreArchivo = time() . "_id_" . $_FILES["foto_identificacion"]["name"];
        $rutaDestino = "uploads-hogares/" . $nombreArchivo;
        move_uploaded_file($_FILES["foto_identificacion"]["tmp_name"], $rutaDestino);
        $fotoIdentificacion = $rutaDestino;
    }

    $fotoPerfil = "";
    if(isset($_FILES["foto_perfil"])) {
        $nombreArchivo2 = time() . "_perfil_" . $_FILES["foto_perfil"]["name"];
        $rutaDestino2 = "uploads-hogares/" . $nombreArchivo2;
        move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $rutaDestino2);
        $fotoPerfil = $rutaDestino2;
    }

    try {

        $sql = "INSERT INTO cliente
        (nombre, correo, celular, ciudad, barrio, direccion, password, foto_identificacion, foto_perfil)
        VALUES
        (:nombre, :correo, :celular, :ciudad, :barrio, :direccion, :password, :foto_identificacion, :foto_perfil)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':celular' => $celular,
            ':ciudad' => $ciudad,
            ':barrio' => $barrio,
            ':direccion' => $direccion,
            ':password' => $password,
            ':foto_identificacion' => $fotoIdentificacion,
            ':foto_perfil' => $fotoPerfil
        ]);

        header("Location: login.php?registro=ok");
       exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de hogares - Asear </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/hogares.css">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow-lg border-0 rounded-4 p-4 login-card">
<div class="text-center mb-4">
<img src="assets/img/LOGO-ASEAR.png" alt="Logo" width="120">
<h4 class="mt-5" >Crear Cuenta </h4>
</div>
<form id="registroForm" method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label for="nombre" class="form-label">Nombre Completo</label>
<input type="text" class="form-control" id="nombre" name="nombre" required>
</div>
<div class="mb-3">
<label for="email" class="form-label">Correo Electrónico</label>
<input type="email" class="form-control" id="email" name="email" required>
</div>
<div class="mb-3">
<label for="celular" class="form-label">celular</label>
<input type="text" class="form-control" id="celular" name="celular" required>
</div>
<div class="mb-3">
  <label for="ciudad" class="form-label">Ciudad</label>
  <select id="ciudad" name="ciudad" class="form-control" required>
    <option value="">Selecciona una ciudad</option>
    <option value="Medellín">Medellín</option>
    <option value="Envigado">Envigado</option>
    <option value="Itagüí">Itagüí</option>
    <option value="Sabaneta">Sabaneta</option>
  </select>
</div>

<div class="mb-3">
  <label for="barrio" class="form-label">Barrio</label>
  <select id="barrio" name="barrio" class="form-control" required>
    <option value="">Selecciona un barrio</option>
  </select>
</div>

<div class="mb-3">
<label for="Direccion" class="form-label">Dirección</label>
<input type="text" class="form-control" id="direccion" name="direccion" required>
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
<label for="password" class="form-label">Contraseña</label>
<input type="password" class="form-control" id="password" name="password" required>
</div>

<div class="mb-3">
<label for="confirmar" class="form-label">Confirmar Contraseña</label>
<input type="password" class="form-control" id="confirmar" required>
</div>
<div class="mb-3">
  <label for="fotoPerfil" class="form-label">Agrega una foto de perfil</label>
  <small class="text-muted d-block mb-2 texto-italic">
    Sube una foto de tu rostro para tu perfil
  </small>
  <input 
    type="file" 
    class="form-control" 
    id="fotoPerfil" 
    name="foto_perfil"
    accept="image/*" 
    capture="camera" 
    required>
</div>
<button type="submit" class="mt-5 btn btn-success w-100">Registrarse</button>
<div class="text-center mt-3">
<small>¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none">Inicia sesión</a></small>
</div>
</form>
</div> 
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/hogares.js"></script>
</body>
</html>