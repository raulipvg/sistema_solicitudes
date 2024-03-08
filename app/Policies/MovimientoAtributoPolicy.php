<?php

namespace App\Policies;

use App\Models\Usuario;

class MovimientoAtributoPolicy
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
        return $user->puedeVer(10);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(10);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(10);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(10);
    }
}
