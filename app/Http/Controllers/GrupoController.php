<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function Index()
    {
        return View('grupo.grupo');
    }
}
