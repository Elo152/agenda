<?php
require_once '../controllers/contactService.php';
require_once '../controllers/messageService.php';

$confirmacion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensaje'], $_POST['id_contacto'])) {
    $texto = $_POST['mensaje'];
    $id_contacto = $_POST['id_contacto'];
    $resultado = guardarMensaje($texto, $id_contacto);
    if($resultado === true){
        $confirmacion = 'Mensaje enviado correctamente';
    } else {
        $confirmacion = $resultado;
    }
}

if (isset($_GET['id_contacto'])) {
    $id_contacto = $_GET["id_contacto"];
}

$contacto = detalleContacto($id_contacto);
$mensajes = obtenerMensaje($id_contacto);
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
    <title>Detalles del contacto</title>
</head>
<body>
<?php include 'partials/header.php'; ?>
<main>
    <?php if ($contacto != null): ?>
        <section class="contact-details">
            <img src="<?= htmlspecialchars($contacto->getFoto()) ?>"
                 alt="Foto de <?= htmlspecialchars($contacto->getNombre()) ?>" class="contact-photo">
            <h1><?= htmlspecialchars($contacto->getNombre() . ' ' . $contacto->getApellidos()) ?></h1>
        </section>
        <?php if (!empty($confirmacion)): ?>
            <?php
            $alertClass = ($confirmacion === "Mensaje enviado correctamente") ? 'alert' : 'alert error';
            ?>
            <div id="alerta" class="<?= $alertClass ?>">
                <?= htmlspecialchars($confirmacion) ?>
            </div>
        <?php endif; ?>
        <section class="message-form">
            <form action="" method="post">
                <input type="hidden" name="id_contacto" value="<?= htmlspecialchars($contacto->getId()) ?>">
                <textarea name="mensaje" rows="4"
                          placeholder="Escribe tu mensaje a <?= htmlspecialchars($contacto->getNombre()) ?> aquí..."
                          required></textarea>
                <button type="submit" class="button-dialog-agregar">Enviar mensaje</button>
            </form>
        </section>

        <section class="sent-messages">
            <h2>Mensajes enviados a <?= htmlspecialchars($contacto->getNombre()) ?></h2>
            <?php if (!empty($mensajes)): ?>
                <div class="messages-list">
                    <?php foreach ($mensajes as $mensaje): ?>
                        <p class="message"><?= htmlspecialchars($mensaje->getTexto()) ?></p>
                        <p class="date"> 📱Enviado el <?= htmlspecialchars($mensaje->getFechaEnvio()) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No se han enviado mensajes a este contacto aún.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
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