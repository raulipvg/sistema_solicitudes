<?php

namespace App\Policies;

use App\Models\Usuario;

class FlujoPolicy
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
        return $user->puedeVer(7);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(7);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(7);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(7);
    }
}
