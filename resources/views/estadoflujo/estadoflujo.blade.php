@if ($credenciales['puedeVer'])
@extends('layout.main')

@push('css')
<link href='{{ asset("css/datatables/datatables.bundle.css?id=2") }}' rel='stylesheet' type="text/css" />
<style>
.w-115px{
   width: 115px!important; 
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
            <h3 class="card-title text-uppercase text-white">Estados de Flujo</h3>
            @if ($credenciales['puedeRegistrar'])
            <div class="m-1">
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            @endif                
        </div>
        <div class="card-body">
                @include('estadoflujo.componente.tablaEstadoFlujo')
        </div>
    </div>
</div>
<!--end::Content-->

@if ($credenciales['puedeRegistrar'] || $credenciales['puedeEditar'] || $credenciales['puedeVer'])
    <!--begin::modal-->
    @include('estadoflujo.componente.modalRegistrarEstadoFlujo')
    <!--end::modal-->
@endif

@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS */
        const GuardarEstado = "{{ route('GuardarEstado') }}";
        const VerEstado = "{{ route('VerEstado') }}";
        const EditarEstado = "{{ route('EditarEstado') }}";
        const CambiarEstado = "{{ route('CambiarEstadoEstado') }}";
        /* END:RUTAS */
        const data =  {!! $estadosFlujo !!};
        const credenciales= {!! json_encode($credenciales) !!};
    </script>
    
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/estadoflujo.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/estadoflujo/estadoflujo.js') }}"></script>
    <!--end::Eventos de la pagina-->

@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif