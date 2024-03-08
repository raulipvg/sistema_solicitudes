<?php

namespace App\Policies;

use App\Models\Usuario;

class GrupoPolicy
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
        return $user->puedeVer(2);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(2);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(2);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(2);
    }
}
