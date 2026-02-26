<?php
session_start();
require_once __DIR__ . "/config/db.php";
if (isset($_SESSION["id_usuario"]) && $_SERVER["REQUEST_METHOD"] !== "POST") {

    if ($_SESSION["rol"] === "aseador") {
        header("Location: dashboard-aseadores.php");
        exit;
    }

    if ($_SESSION["rol"] === "hogar") {
        header("Location: dashboard-hogares.php");
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = $_POST["email"];
    $password = $_POST["password"];

    try {

        /* =========================
           1️⃣ BUSCAR EN CLIENTES
        ==========================*/
        $sqlCliente = "SELECT * FROM cliente WHERE correo = :correo LIMIT 1";
        $stmt = $pdo->prepare($sqlCliente);
        $stmt->execute([':correo' => $correo]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($password, $cliente["password"])) {

            $_SESSION["id_usuario"] = $cliente["id_cliente"];
            $_SESSION["nombre"] = $cliente["nombre"];
            $_SESSION["rol"] = "hogar";

            header("Location: dashboard-hogares.php");
            exit;
        }

        /* =========================
           2️⃣ BUSCAR EN ASEADORES
        ==========================*/
        $sqlAseador = "SELECT * FROM aseador WHERE correo = :correo LIMIT 1";
        $stmt = $pdo->prepare($sqlAseador);
        $stmt->execute([':correo' => $correo]);
        $aseador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aseador && password_verify($password, $aseador["password"])) {

            $_SESSION["id_usuario"] = $aseador["id_aseador"];
            $_SESSION["nombre"] = $aseador["nombre"];
            $_SESSION["rol"] = "aseador";

            header("Location: dashboard-aseadores.php");
            exit;
        }

        $error = "Correo o contraseña incorrectos";

    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión - Asear</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow-lg border-0 rounded-4 p-4 login-card">
<?php if(isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
    <small class="d-block text-primary text-center mb-3">
        ✔ Registro exitoso. Inicia sesión para continuar.
    </small>
<?php endif; ?>

<div class="text-center mb-4">
<img src="assets/img/LOGO-ASEAR.png" alt="Logo" width="120">
<h4 class="mt-3 fw-bold text-dark">Iniciar Sesión</h4>
</div>

<form method="POST">

<div class="mb-3">
<label class="form-label">Correo Electrónico</label>
<input type="email"
       class="form-control"
       name="email"
       placeholder="tucorreo@ejemplo.com"
       required>
</div>

<div class="mb-3">
<label class="form-label">Contraseña</label>
<input type="password"
       class="form-control"
       name="password"
       placeholder="********"
       required>
</div>

<button type="submit" class="btn btn-primary w-100">
Ingresar
</button>

<div class="text-center mt-3">
<small>
¿No tienes cuenta?
<a href="rol-registro.php" class="text-decoration-none">
Regístrate aquí
</a>
</small>
</div>

</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>