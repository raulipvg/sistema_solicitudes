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
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div id="contenedor" class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
            <div class="mx-5">
            <!--begin::Card-->
            @include('grupo.componente.tarjetagrupo', ['grupo'=> $datosgrupo])
            <!--end::Card-->
            </div>       
        </div>
        <!--end::Siderbar-->
    
        <div class="flex-lg-row-fluid">
            <div class="card mx-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h3 class="card-title text-uppercase">Usuarios Asignados</h3>

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

    </div>
</div>
<!--end::Content-->

 <!--begin::Modal - Update role-->
 @include('grupo.componente.modalEditarGrupo')
 <!--end::Modal - Update role-->

<!--begin::modal - Registrar Usuario-->
@include('usuario.componente.modalRegistrarUsuario')
<!--end::modal-->

<!--begin::modal -  Asignar Grupo-->
@include('usuario.componente.modalAsignarGrupo')
<!--end::modal-->

@endsection

@push('Script')
    <script>
        const GuardarUsuario = "{{ route('GuardarUsuario') }}";
        const VerUsuario = "{{ route('VerUsuario') }}";
        const EditarUsuario = "{{ route('EditarUsuario') }}";
        const CambiarEstado = "{{ route('CambiarEstadoUsuario') }}";
        const VerGrupoEdit = '{{ route("VerGrupoEdit") }}';

        const VerAcceso =  "{{ route('VerUsuarioGrupo') }}";
        const VerGrupos =  "{{ route('VerGrupoPorUsuario') }}";
        const GuardarUsuarioGrupo = "{{ route('GuardarUsuarioGrupo') }}";
        const DeleteUsuarioGrupo = "{{ route('DeleteUsuarioGrupo')}}";

        const VerCC= "{{ route('VerCC') }}";
        const EditarGrupoPrivilegio = '{{route("EditarGrupoPrivilegio")}}';
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/usuario.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/usuario/usuario.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/grupo/tarjeta_grupo.js?id=3') }}"></script>

    <!--end::Eventos de la pagina-->

@endpush