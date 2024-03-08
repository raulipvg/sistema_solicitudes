<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
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
        return $user->puedeVer(1);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(1);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(1);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(1);
    }
}
