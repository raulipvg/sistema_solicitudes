<?php

namespace App\Policies;

use App\Models\Usuario;

class AreaPolicy
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
        return $user->puedeVer(6);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(6);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(6);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(6);
    }
}
