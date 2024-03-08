<?php

namespace App\Policies;

use App\Models\Usuario;

class EmpresaPolicy
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
        return $user->puedeVer(3);
    }

    public function registrar(Usuario $user)
    {
        return $user->puedeRegistrar(3);
    }

    public function editar(Usuario $user)
    {
        return $user->puedeEditar(3);
    }

    public function eliminar(Usuario $user)
    {
        return $user->puedeEliminar(3);
    }
}
