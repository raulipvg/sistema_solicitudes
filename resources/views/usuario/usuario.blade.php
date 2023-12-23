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
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">Usuarios</h3>

                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <!--begin::Tabla Usuario-->
            @include('usuario.componente.tablaUsuario')
            <!--end::Tabla Usuario-->
        </div>
    </div>
    
</div>
<!--end::Content-->

<!--begin::modal - Registrar Usuario-->
@include('usuario.componente.modalRegistrarUsuario')
<!--end::modal - Registrar Usuario-->

<!--begin::modal -Asignar Grupo-->
@include('usuario.componente.modalAsignarGrupo')
<!--end::modal - Asignar Grupo-->

@endsection

@push('Script')
    <script>
        const GuardarUsuario = "{{ route('GuardarUsuario') }}";
        const VerUsuario = "{{ route('VerUsuario') }}";
        const EditarUsuario = "{{ route('EditarUsuario') }}";
        const CambiarEstado = "{{ route('CambiarEstadoUsuario') }}";

        const VerAcceso =  "{{ route('VerUsuarioGrupo') }}";
        const VerGrupos =  "{{ route('VerGrupoPorUsuario') }}";
        const GuardarUsuarioGrupo = "{{ route('GuardarUsuarioGrupo') }}";
        const DeleteUsuarioGrupo = "{{ route('DeleteUsuarioGrupo')}}";
        //const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/usuario.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/usuario.js?id=3') }}"></script>
    
    <!--end::Eventos de la pagina-->

@endpush