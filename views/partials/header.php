<?php
require_once '../models/Usuario.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["logueado"]) && basename($_SERVER['PHP_SELF']) != "login.php" && basename($_SERVER['PHP_SELF']) != "registro.php") {
    header("location: ../views/login.php");
}
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<header>
    <div class="header-left">
        <h1>Agenda de contactos</h1>
    </div>
    <div class="header-right">
        <?php if (isset($_SESSION['logueado'])): ?>
            <button class="button">
                <a href="../public/index.php">
                    <i class="fas fa-address-book"></i> Listado de todos los contactos
                </a>
            </button>
            <?php $funcionOnclick = "document.getElementById('openDialog').showModal()"; ?>
            <button onclick="<?= $funcionOnclick ?>" class="button">
                <i class="fas fa-user-plus"></i> Agregar contacto
            </button>
            <dialog id="openDialog">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= htmlspecialchars($_SESSION['logueado']->getId()); ?>" name="id_usuario">
                    <label for="nombre">Nombre del contacto</label>
                    <input type="text" name="nombre" id="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="El nombre no debe contener números" required>
                    <label for="apellidos">Apellidos del contacto</label>
                    <input type="text" name="apellidos" id="apellidos" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="Los apellidos no deben contener números" required>
                    <label for="telefono">Teléfono del contacto</label>
                    <input type="tel" name="telefono" id="telefono" pattern="^\d{9}$" maxlength="9" title="El teléfono debe tener 9 dígitos" required>
                    <input type="file" name="foto" id="foto">
                    <input type="submit" value="Agregar contacto" class="button-dialog-agregar">
                </form>
                <button onclick="document.getElementById('openDialog').close()" class="button-dialog-cerrar">Cerrar sin agregar contacto</button>
            </dialog>
            <div class="dropdown">
                <img src="<?= htmlspecialchars($_SESSION['logueado']->getAvatar()); ?>" alt="Avatar del usuario" class="avatar">
                <div class="dropdown-content">
                    <a href="../views/logout.php">Cerrar sesión</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
