<?php

use models\Contacto;

require_once '../database/config.php';
require_once '../models/Contacto.php';
function crearContacto($nombre, $apellidos, $telefono, $foto, $id_usuario){
    $nombreArchivo = $foto['name'];
    $fotoTmp = $foto['tmp_name'];
    $rutaCarpeta = "../public/images";
    $rutaArchivo = "$rutaCarpeta/$nombreArchivo";

    if ($foto['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0755, true);
        }
        if (!move_uploaded_file($foto['tmp_name'], $rutaArchivo)) {
            return "Error al mover el archivo.";
        }
    } else {
        return "Error al subir el archivo.";
    }

    $conexion = conexionBD();

    $sql = "SELECT * FROM contactos WHERE nombre = ? AND apellidos = ? AND telefono = ?";
    $query = $conexion->prepare($sql);
    $query->bind_param("sss", $nombre, $apellidos, $telefono);
    if ($query->execute()) {
        $resultado = $query->get_result();
        if ($resultado->num_rows > 0) {
            $conexion->close();
            return 'Contacto ya registrado';
        }
    } else {
        $conexion->close();
        return 'Error en la consulta SELECT';
    }

    $sql = "INSERT INTO contactos (nombre, apellidos, telefono, foto, id_usuario) VALUES (?,?,?,?,?)";
    $query = $conexion->prepare($sql);
    $query->bind_param("ssssi", $nombre, $apellidos, $telefono, $rutaArchivo, $id_usuario);
    if ($query->execute()) {
        $conexion->close();
        return true;
    } else {
        $conexion->close();
        return 'Error al insertar el contacto';
    }
}
function obtenerContactos($id_usuario){
    $conexion = conexionBD();
    $sql = "SELECT * FROM contactos WHERE id_usuario = $id_usuario";
    $resultado = $conexion->query($sql);
    $contactos = [];

    while ($row = $resultado->fetch_assoc()) {
        $contactos [] = new Contacto($row['id'], $row['nombre'], $row['apellidos'], $row['telefono'], $row['foto'], $row['id_usuario']);
    }
    $conexion->close();
    return $contactos;
}
function detalleContacto($id_contacto){
    $conexion = conexionBD();
    $sql = "SELECT * FROM contactos WHERE id = $id_contacto";
    $resultado = $conexion->query($sql);

    while ($row = $resultado->fetch_assoc()) {
        $contacto = new Contacto($row['id'], $row['nombre'], $row['apellidos'], $row['telefono'], $row['foto'], $row['id_usuario']);
    }
    $conexion->close();
    return $contacto;
}
function filtrarContacto($nombre, $id_usuario){
    $conexion = conexionBD();
    $sql = "SELECT * FROM contactos WHERE nombre LIKE ? AND id_usuario = ?";
    $query= $conexion->prepare($sql);
    $bucarNombre = "%$nombre%";
    $query->bind_param("si", $bucarNombre, $id_usuario);

    if ($query->execute()) {
        $resultado = $query->get_result();
        $contactos = [];


        while ($row = $resultado->fetch_assoc()) {
            $contactos[] = new Contacto($row['id'], $row['nombre'], $row['apellidos'], $row['telefono'], $row['foto'], $row['id_usuario']);
        }

        $query->close();
        $conexion->close();

        return $contactos;
    } else {
        $query->close();
        $conexion->close();
        return 'Error al filtrar los contactos';
    }
}