<?php
namespace App\Models;
class Credenciales
{
    private $puedeVer;
    private $puedeRegistrar;
    private $puedeEditar;
    private $puedeEliminar;

    public function __construct($puedeVer, $puedeRegistrar, $puedeEditar, $puedeEliminar)
    {
        $this->puedeVer = $puedeVer;
        $this->puedeRegistrar = $puedeRegistrar;
        $this->puedeEditar = $puedeEditar;
        $this->puedeEliminar = $puedeEliminar;
    }

    public function puedeVer()
    {
        return $this->puedeVer;
    }

    public function puedeRegistrar()
    {
        return $this->puedeRegistrar;
    }

    public function puedeEditar()
    {
        return $this->puedeEditar;
    }

    public function puedeEliminar()
    {
        return $this->puedeEliminar;
    }
}