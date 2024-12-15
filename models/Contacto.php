<?php

namespace models;
class Contacto
{
    private $id;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $foto;
    private $idUsuario;

    function __construct($id, $nombre, $apellidos, $telefono, $foto, $idUsuario)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->foto = $foto;
        $this->idUsuario = $idUsuario;
    }

    public function getId()
    {
        return $this->id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getApellidos()
    {
        return $this->apellidos;
    }

    function getTelefono()
    {
        return $this->telefono;
    }

    function getFoto()
    {
        return $this->foto;
    }

    function getIdUsuario()
    {
        return $this->idUsuario;
    }
}