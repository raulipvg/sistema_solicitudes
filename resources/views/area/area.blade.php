@if ($credenciales['puedeVer'])
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
@include('layout.toolbar')
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">Areas</h3>
            @if ($credenciales['puedeRegistrar'])
            <div class="m-1">
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            @endif
        </div>
        <div class="card-body">
                <!--begin::Tabla Area-->
                @include('area.componente.tablaArea')
                <!--end::Tabla Area-->
        </div>
    </div>
    
</div>
<!--end::Content-->

@if ($credenciales['puedeRegistrar'] || $credenciales['puedeEditar'] || $credenciales['puedeVer'])
    <!--begin::modal - Registrar Area-->
    @include('area.componente.modalRegistarArea')
    <!--end::modal-->
@endif

<!--begin::modal -  Asignar Grupo-->
@include('usuario.componente.modalAsignarGrupo')
<!--end::modal-->

@endsection

@push('Script')
    <script>
        const GuardarArea = "{{ route('GuardarArea') }}";
        const VerArea = "{{ route('VerArea') }}";;
        const EditarArea = "{{ route('EditarArea') }}";;
        const CambiarEstadoArea = "{{ route('CambiarEstadoArea') }}";;

        const VerFlujos =  "{{ route('VerFlujos') }}";
        const EliminarFlujo = "{{ route('EliminarFlujo') }}";

        const data =  {!! $areas !!};
        const credenciales= {!! json_encode($credenciales) !!};
        const credenciales2= {!! json_encode($credenciales2) !!};

    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/area.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/area/area.js?id=3') }}"></script>
    
    <!--end::Eventos de la pagina-->

@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif