<?php
require_once '../controllers/contactService.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $foto = $_FILES['foto'];
    $id_usuario = $_POST['id_usuario'];

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)) {
        $mensaje = "El nombre no puede contener números.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $apellidos)) {
        $mensaje = "Los apellidos no pueden contener números.";
    } elseif (!preg_match("/^\d{9}$/", $telefono)) {
        $mensaje = "El teléfono debe tener 9 dígitos.";
    } elseif (isset($nombre) && isset($apellidos) && isset($telefono) && isset($foto) && isset($id_usuario)) {
        $resultado = crearContacto($nombre, $apellidos, $telefono, $foto, $id_usuario);
        if ($resultado === true) {
            $mensaje = "Contacto agregado correctamente";
        } else {
            $mensaje = "Error al agregar contacto";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Agenda de contactos</title>
</head>

<body>
    <?php include '../views/partials/header.php' ?>

    <main class="main-content">
        <section class="search-section">
            <form action="#" method="get">
                <input type="text" name="buscar" placeholder="Buscar contacto por nombre" class="search" required>
                <input type="submit" value="Buscar contacto" class="button">
            </form>
        </section>

        <section class="seccion-contactos">
            <h2>Lista de contactos</h2>
            <?php if (!empty($mensaje)): ?>
                <?php
                $alertClass = ($mensaje === "Contacto agregado correctamente") ? 'alert' : 'alert error';
                ?>
                <div id="alerta" class="<?= $alertClass ?>">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <div class="lista-contactos">
                <?php
                if (isset($_SESSION['logueado'])) {
                    $idUsuario = $_SESSION['logueado']->getID();
                }

                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['buscar'])) {
                    $buscar = $_GET['buscar'];
                    $contactos = filtrarContacto($buscar, $idUsuario);
                } else {
                    $contactos = obtenerContactos($idUsuario);
                }
                if (!empty($contactos)): ?>
                    <?php foreach ($contactos as $contacto): ?>
                        <a href="../views/contacto.php?id_contacto=<?= urlencode($contacto->getId()); ?>">
                            <p>
                                <?= htmlspecialchars($contacto->getNombre() . ' ' . $contacto->getApellidos()); ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay contactos que mostrar</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Agenda de Contactos. Todos los derechos reservados.</p>
    </footer>

    <script>
        window.onload = function () {
            const alerta = document.getElementById('alerta');
            if (alerta) {
                alerta.style.display = 'block';
                setTimeout(function () {
                    alerta.style.display = 'none';
                }, 3000);
            }
        };
    </script>

</body>

</html>