<?php

namespace App\Policies;

use App\Models\Usuario;

class CentroCostoPolicy
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
        return $user->puedeVer(4);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(4);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(4);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(4);
    }
}
