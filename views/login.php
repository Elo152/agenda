<?php
require_once '../controllers/usuarioService.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    if (isset($telefono) && isset($password)) {
        $usuarioLogueado = login($telefono, $password);
        if ($usuarioLogueado) {
            $_SESSION['logueado'] = $usuarioLogueado;
            header('Location: ../public/index.php');
        } else {
            $_SESSION['error_login'] = "Teléfono o contraseña incorrectos.";
            header('Location: login.php');
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
    <title>Login</title>
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <?php
    $error = null;
    if (isset($_SESSION['error_login'])) {
        $error = $_SESSION['error_login'];
    }
    ?>
    <main class="login">
        <div class="form-container">
            <form action="" method="post" class="form-login">
                <h2>Inicio de sesión</h2>
                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" required>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Iniciar sesión" class="button-login">
                <?php if ($error): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <p>¿No tienes cuenta? <a href="registro.php" class="a-form">Regístrate</a></p>
            </form>
        </div>
    </main>
    <footer></footer>
</body>

</html>