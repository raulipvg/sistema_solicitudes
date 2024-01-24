@if ($credenciales['puedeVer'])
@extends('layout.main')

@push('css')
<link href="{{ asset('css/datatables/datatables.bundle.css?id=2') }}" rel='stylesheet' type="text/css" />
<style>
.w-115px{
   width: 115px!important; 
}
.h-input{
    min-height: 57.55px!important;
}
</style>
@endpush

@section('main-content')
<!--begin::Toolbar-->
@include('layout.toolbar')
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">Empresa</h3>
            @if ($credenciales['puedeRegistrar'])
            <div class="m-1">                
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            @endif
        </div>
        <div class="card-body">          
                <!--begin::Tabla Empresa-->
                @include('empresa.componente.tablaEmpresa')
                <!--end::Tabla Empresa-->
        </div>
    </div>
    
</div>
<!--end::Content-->
@if ($credenciales['puedeRegistrar'] || $credenciales['puedeEditar'] || $credenciales['puedeVer'])
    <!--begin::modal - Registrar Empresa-->
    @include('empresa.componente.modalRegistrarEmpresa')
    <!--end::modal - Registrar Empresa-->
@endif

@if ($credenciales2['puedeRegistrar'])
    <!--begin::modal - Asignar Centro de Costo-->
    @include('empresa.componente.modalRegistrarCentroCosto')
    <!--end::modal-->
@endif

@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS */
        const GuardarEmpresa = "{{ route('GuardarEmpresa') }}";
        const VerEmpresa = "{{ route('VerEmpresa') }}";
        const EditarEmpresa = "{{ route('EditarEmpresa') }}";
        const CambiarEstadoEmpresa = "{{ route('CambiarEstadoEmpresa') }}";
        const VerCentroCosto =  "{{ route('VerCentroCosto') }}";  
        const GuardarCentroCosto = "{{ route('GuardarCentroCosto') }}";
        const DeleteUsuarioGrupo = "{{ route('CambiarEstadoCentroCosto') }}";
        const VerCentroCostoxEmpresa = "{{ route('VerCentroCostoxEmpresa') }}"
        /* END:RUTAS */
        const data =  {!! $empresas !!};
        const credenciales= {!! json_encode($credenciales) !!};
        const credenciales2= {!! json_encode($credenciales2) !!};
        
        const layout= {!! json_encode($accesoLayout) !!};
        console.log(layout)
        
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/empresa.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/empresa/empresa.js?id=3') }}"></script>
    <!--end::Eventos de la pagina-->

@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif