@if ($credencialesUsuario['puedeVer'])
@extends('layout.main')

@push('css')
<link href="{{ asset('css/datatables/datatables.bundle.css?id=2') }}" rel='stylesheet' type="text/css" />
<style>
.w-115px{
   width: 115px!important; 
}
</style>
@endpush


@section('main-content')
<!--begin::Toolbar-->
@include('layout.toolbar', ['titulo' => $titulo])
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">Usuarios</h3>
            @if ($credencialesUsuario['puedeRegistrar'])
                <div class="m-1">
                    <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                        Registrar
                    </button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <!--begin::Tabla Usuario-->
            @include('usuario.componente.tablaUsuario')
            <!--end::Tabla Usuario-->
        </div>
    </div>
    
</div>
<!--end::Content-->
@if ($credencialesUsuario['puedeRegistrar'] || $credencialesUsuario['puedeEditar'] || $credencialesUsuario['puedeVer'])
    <!--begin::modal - Registrar Usuario-->
    @include('usuario.componente.modalRegistrarUsuario')
    <!--end::modal - Registrar Usuario-->
@endif

@if ($credencialesGrupo['puedeRegistrar'])
    <!--begin::modal -Asignar Grupo-->
    @include('usuario.componente.modalAsignarGrupo')
    <!--end::modal - Asignar Grupo-->
@endif

@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS */
        const GuardarUsuario = "{{ route('GuardarUsuario') }}";
        const VerUsuario = "{{ route('VerUsuario') }}";
        const EditarUsuario = "{{ route('EditarUsuario') }}";
        const CambiarEstado = "{{ route('CambiarEstadoUsuario') }}";
        const VerCC= "{{ route('VerCC') }}"

        const VerAcceso =  "{{ route('VerUsuarioGrupo') }}";
        const VerGrupos =  "{{ route('VerGrupoPorUsuario') }}";
        const GuardarUsuarioGrupo = "{{ route('GuardarUsuarioGrupo') }}";
        const DeleteUsuarioGrupo = "{{ route('DeleteUsuarioGrupo')}}";
        /* END:RUTAS */

        const data =  {!! $usuarios2 !!};
        const credencialesUsuario= {!! json_encode($credencialesUsuario) !!};
        const credencialesGrupo= {!! json_encode($credencialesGrupo) !!};
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=5') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=5') }}"></script>
    <script src="{{ asset('js/datatables/contenido/usuario.js?id=5') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=5') }}"></script>
    <script src="{{ asset('js/eventos/usuario/usuario.js?id=5') }}"></script>
    <!--end::Eventos de la pagina-->
    
@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif