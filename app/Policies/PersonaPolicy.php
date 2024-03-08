<?php

namespace App\Policies;

use App\Models\Usuario;

class PersonaPolicy
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
        return $user->puedeVer(5);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(5);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(5);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(5);
    }
}
