<?php

use models\Usuario;

require_once '../database/config.php';
require_once '../models/Usuario.php';
function login($telefono, $password){
    $conexion = conexionBD();
    $sql = "SELECT * FROM usuarios WHERE telefono = ?";
    $query = $conexion->prepare($sql);
    $query->bind_param("s", $telefono);
    $ejecutada = $query->execute();
    $result = $query->get_result();

    if($result->num_rows == 1){
        $usuarioBD= $result->fetch_assoc();
        if(password_verify($password, $usuarioBD['password'])){
            $usuario = new Usuario (
                $usuarioBD['id'],
                $usuarioBD['telefono'],
                $usuarioBD['password'],
                $usuarioBD['avatar']
            );
            $conexion->close();
            return $usuario;
        }
    }
    $conexion->close();
    return false;

}
function registro($telefono, $password, $avatar) {
    $nombreArchivo = $avatar['name'];
    $avatarTmp = $avatar['tmp_name'];
    $rutaCarpeta = "../public/images";
    $rutaArchivo = "$rutaCarpeta/$nombreArchivo";

    if ($avatar['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0755, true);
        }
        if (!move_uploaded_file($avatar['tmp_name'], $rutaArchivo)) {
            return "Error al mover el archivo.";
        }
    } else {
        return "Error al subir el archivo.";
    }

    $conexion = conexionBD();

    $sql = "SELECT * FROM usuarios WHERE telefono = ?";
    $query = $conexion->prepare($sql);
    $query->bind_param("s", $telefono);
    $ejecutada = $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 1) {
        return "Teléfono ya registrado";
    } else {
        $sql = "INSERT INTO usuarios (telefono, password, avatar) VALUES (?, ?, ?)";
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        $query = $conexion->prepare($sql);
        $query->bind_param("sss", $telefono, $passwordHashed, $rutaArchivo);
        $query->execute();

        if ($query->affected_rows > 0) {
            $conexion->close();
            return true;
        } else {
            $conexion->close();
            return "Teléfono ya registrado";
        }
    }
}
