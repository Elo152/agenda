<?php

use models\Mensaje;

require_once '../database/config.php';
require_once '../models/Mensaje.php';
function guardarMensaje($texto, $id_contacto){
    $conexion = conexionBD();
    $sql = "INSERT INTO mensajes (texto, id_contacto) VALUES (?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $texto, $id_contacto);

    if($stmt->execute()) {
        $conexion->close();
        return true;
    } else {
        $conexion->close();
        return "Error al enviar el mensaje";
    }
}
function obtenerMensaje($id_contacto){
    $conexion = conexionBD();
    $sql = "SELECT * FROM mensajes WHERE id_contacto = ? ORDER BY fecha_envio ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_contacto); // "i" es para un entero
    $stmt->execute();
    $resultado = $stmt->get_result();
    $mensajes = [];

    while($row = $resultado->fetch_assoc()){
        $mensajes[] = new Mensaje($row['id'],$row['texto'], $row['fecha_envio'], $row['id_contacto']);
    }
    $conexion->close();
    return $mensajes;
}