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
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">{{$titulo}}</h3>
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            @include('atributo.componente.tablaAtributo')
        </div>
    </div>
</div>
<!--end::Content-->

<!--begin::modal-->
@include('atributo.componente.modalRegistrarAtributo')
<!--end::modal-->


@endsection

@push('Script')
    <script>
        const GuardarAtributo = "{{ route('GuardarAtributo') }}";
        const VerAtributo = "{{ route('VerAtributo') }}";
        const EditarAtributo = "{{ route('EditarAtributo') }}";
        const CambiarEstadoAtributo = "{{ route('CambiarEstadoAtributo') }}";

        const dataAtributos = {!! $atributos !!};
    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/atributo.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/atributo/atributo.js?id=3') }}"></script>
    
    <!--end::Eventos de la pagina-->

@endpush