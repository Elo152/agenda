<?php
require_once '../controllers/usuarioService.php';
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = htmlspecialchars($_POST['telefono']);
    $password = htmlspecialchars($_POST['password']);
    $avatar = $_FILES['avatar'];
    if (isset($telefono) && isset($password) && isset($avatar)) {
        if (!preg_match('/^[0-9]{9}$/', $telefono)) {
            $mensajeError = "El número de teléfono debe tener 9 dígitos.";
        } elseif (strlen($password) < 6) {
            $mensajeError = "La contraseña debe tener al menos 6 caracteres.";
        } else {
            $resultado = registro($telefono, $password, $avatar);
            if ($resultado === true) {
                header('Location: login.php');
                exit;
            } else {
                $mensajeError = $resultado;
            }
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Registro</title>
</head>
<body>
<?php include 'partials/header.php'; ?>
<main class="registro">
    <div class="form-container">
        <form action="?" method="post" enctype="multipart/form-data" class="form-login">
            <h2>Registro de usuario</h2>
            <label for="telefono">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" pattern="^\d{9}$" required>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            <input type="file" name="avatar" accept="image/*" id="avatar" required>
            <input type="submit" value="Registrarse" class="button">
            <p>¿Ya tienes cuenta? <a href="login.php" class="a-form">Inicia sesión</a></p>
            <?php if (!empty($mensajeError)): ?>
                <p class="error"><?= htmlspecialchars($mensajeError); ?></p>
            <?php endif; ?>
        </form>
    </div>
</main>
<footer></footer>
</body>
</html>
