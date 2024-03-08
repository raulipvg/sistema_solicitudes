<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('ver-flujo', 'App\Policies\FlujoPolicy@ver');
        Gate::define('registrar-flujo', 'App\Policies\FlujoPolicy@registrar');
        Gate::define('editar-flujo', 'App\Policies\FlujoPolicy@editar');
        Gate::define('eliminar-flujo', 'App\Policies\FlujoPolicy@eliminar');

        Gate::define('ver-area', 'App\Policies\AreaPolicy@ver');
        Gate::define('registrar-area', 'App\Policies\AreaPolicy@registrar');
        Gate::define('editar-area', 'App\Policies\AreaPolicy@editar');
        Gate::define('eliminar-area', 'App\Policies\AreaPolicy@eliminar');

        Gate::define('ver-estadoflujo', 'App\Policies\EstadoFlujoPolicy@ver');
        Gate::define('registrar-estadoflujo', 'App\Policies\EstadoFlujoPolicy@registrar');
        Gate::define('editar-estadoflujo', 'App\Policies\EstadoFlujoPolicy@editar');
        Gate::define('eliminar-estadoflujo', 'App\Policies\EstadoFlujoPolicy@eliminar');

        Gate::define('ver-movimientoatributo', 'App\Policies\MovimientoAtributoPolicy@ver');
        Gate::define('registrar-movimientoatributo', 'App\Policies\MovimientoAtributoPolicy@registrar');
        Gate::define('editar-movimientoatributo', 'App\Policies\MovimientoAtributoPolicy@editar');
        Gate::define('eliminar-movimientoatributo', 'App\Policies\MovimientoAtributoPolicy@eliminar');

        Gate::define('ver-persona', 'App\Policies\PersonaPolicy@ver');
        Gate::define('registrar-persona', 'App\Policies\PersonaPolicy@registrar');
        Gate::define('editar-persona', 'App\Policies\PersonaPolicy@editar');
        Gate::define('eliminar-persona', 'App\Policies\PersonaPolicy@eliminar');

        Gate::define('ver-usuario', 'App\Policies\UsuarioPolicy@ver');
        Gate::define('registrar-usuario', 'App\Policies\UsuarioPolicy@registrar');
        Gate::define('editar-usuario', 'App\Policies\UsuarioPolicy@editar');
        Gate::define('eliminar-usuario', 'App\Policies\UsuarioPolicy@eliminar');

        Gate::define('ver-grupo', 'App\Policies\GrupoPolicy@ver');
        Gate::define('registrar-grupo', 'App\Policies\GrupoPolicy@registrar');
        Gate::define('editar-grupo', 'App\Policies\GrupoPolicy@editar');
        Gate::define('eliminar-grupo', 'App\Policies\GrupoPolicy@eliminar');

        Gate::define('ver-empresa', 'App\Policies\EmpresaPolicy@ver');
        Gate::define('registrar-empresa', 'App\Policies\EmpresaPolicy@registrar');
        Gate::define('editar-empresa', 'App\Policies\EmpresaPolicy@editar');
        Gate::define('eliminar-empresa', 'App\Policies\EmpresaPolicy@eliminar');

        Gate::define('ver-cc', 'App\Policies\CentroCostoPolicy@ver');
        Gate::define('registrar-cc', 'App\Policies\CentroCostoPolicy@registrar');
        Gate::define('editar-cc', 'App\Policies\CentroCostoPolicy@editar');
        Gate::define('eliminar-cc', 'App\Policies\CentroCostoPolicy@eliminar');
    }
}
