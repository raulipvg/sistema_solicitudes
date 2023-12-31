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
@include('layout.toolbar', ['titulo' => $titulo])
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">{{$titulo}}</h3>
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <!--begin::Tabla Persona-->
            @include('persona.componente.tablaPersona')
            <!--end::Tabla Persona-->
        </div>
    </div>
    
</div>
<!--end::Content-->

<!--begin::modal - Registrar Persona-->
@include('persona.componente.modalRegistrarPersona')
<!--end::modal - Registrar Persona-->

<!--begin::modal - Asignar Usuario-->
@include('persona.componente.modalRegistrarUsuario')
<!--end::modal - Asignar Usuario-->

@endsection

@push('Script')
    <script>
        const GuardarPersona = "{{ route('GuardarPersona') }}";
        const VerPersona = "{{ route('VerPersona') }}";
        const EditarPersona = "{{ route('EditarPersona') }}";
        const CambiarEstadoPersona = "{{ route('CambiarEstadoPersona') }}";
        const DarAccesoPersona =  "{{ route('DarAccesoPersona') }}";
        const VerCC= "{{ route('VerCC')}}";
        
        const data = {!! $personas !!};
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/persona.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/persona/persona.js?id=3') }}"></script> 
    <!--end::Eventos de la pagina-->

@endpush