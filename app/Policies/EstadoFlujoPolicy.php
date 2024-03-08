<?php

namespace App\Policies;

use App\Models\Usuario;

class EstadoFlujoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function ver(Usuario $user)
    {
        return $user->puedeVer(8);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(8);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(8);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(8);
    }
}
