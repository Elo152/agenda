<?php
require_once '../controllers/usuarioService.php';
session_start();
session_destroy();
header('Location: login.php');