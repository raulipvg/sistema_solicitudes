@extends('layout.main')

@push('css')
<link href='{{ asset("css/datatables/datatables.bundle.css?id=2") }}' rel='stylesheet' type="text/css" />
<style>
    .w-115px{
    width: 115px!important; 
    }
    
    .form-select.form-select-solid {
        background-color: #353A40;
        border-color: #353A40;
        color: #ffffff!important;
        transition: color .2s ease;
    }
    .select2-container--bootstrap5 .select2-selection--single.form-select-solid .select2-selection__placeholder {
        color: #ffffff;
    }
    .select2-container--bootstrap5.select2-container--focus:not(.select2-container--disabled) .form-select-solid, .select2-container--bootstrap5.select2-container--open:not(.select2-container--disabled) .form-select-solid {
        background-color: #353A40;
    }
    .select2-container--bootstrap5 .select2-selection--single.form-select-solid .select2-selection__rendered {
        color: #ffffff;
    }
    .select2-negro .select2-container--bootstrap5.select2-container--disabled .form-select {
    background-color: #1f1f1f;
    border-color: var(--bs-gray-300);
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
        <ul id="nav-tab" class="nav nav-tabs">
            <li class="nav-item flex-fill px-1" role="presentation">
                <a id="tab-flujo" class="nav-link w-100 btn btn-flex btn-active-dark justify-content-center active" data-bs-toggle="tab" href="#panel-flujo" aria-selected="true" role="tab">
                    <i class="fs-2 text-primary me-3"></i>
                        <span class="d-flex flex-column align-items-start align-items-center">
                            <span class="fs-4 fw-bold text-capitalize">FLUJOS</span>
                            <span class="fs-7">Administrar flujos</span>
                        </span>
                </a>
            </li>
            <li class="nav-item flex-fill px-1" role="presentation">
                <a id="tab-estado" class="nav-link w-100 btn btn-flex btn-active-dark justify-content-center" data-bs-toggle="tab" href="#panel-estado" aria-selected="false" role="tab" tabindex="-1">
                    <i class="fs-2 text-primary"></i>
                        <span class="d-flex flex-column align-items-start align-items-center">
                            <span class="fs-4 fw-bold text-capitalize">ESTADOS</span>
                            <span class="fs-7">Administrar estados de los flujos</span>
                        </span>
                </a>
            </li>
            <li class="nav-item flex-fill px-1" role="presentation">
                <a id="tab-area" class="nav-link w-100 btn btn-flex btn-active-dark justify-content-center" data-bs-toggle="tab" href="#panel-area" aria-selected="false" role="tab" tabindex="-1">
                    <i class="fs-2 text-primary"></i>
                        <span class="d-flex flex-column align-items-start align-items-center">
                            <span class="fs-4 fw-bold text-capitalize">AREAS</span>
                            <span class="fs-7">Administrar areas de los flujos</span>
                        </span>
                </a>
            </li>
        </ul>
        <div class="card-body pt-5">
        <div id="ContenidoFlujo" class="tab-content" >
                <div class="tab-pane fade active show" id="panel-flujo" role="tabpanel">
                    @include('flujo.flujo')                                   
                </div>

                <div class="tab-pane fade" id="panel-estado" role="tabpanel">
                    @include('estadoflujo.estado')       
                </div>

                <div class="tab-pane fade" id="panel-area" role="tabpanel">
                    @include('area.area1')
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS FLUJO */
        const VerTodoFlujo = "{{ route('VerTodoFlujo') }}";
        const VerFlujoId = "{{ route('VerFlujoId') }}";
        const EditarFlujo = "{{ route('EditarFlujo')}}";

        /* BEGIN::RUTAS FLUJO */

        /* BEGIN::RUTAS ESTADO */
        const VerTodoEstado = "{{ route('VerTodoEstado')}}";
        const VerEstado = "{{ route('VerEstado') }}";
        const GuardarEstado = "{{ route('GuardarEstado') }}";
        const EditarEstado = "{{ route('EditarEstado') }}";
        const CambiarEstado = "{{ route('CambiarEstadoEstado') }}";
        /* END:RUTAS ESTADO*/

        /* BEGIN::RUTAS AREA */
        const VerTodoArea = "{{ route('VerTodoArea')}}";
        const VerArea = "{{ route('VerArea') }}";        
        const GuardarArea = "{{ route('GuardarArea') }}";
        const EditarArea = "{{ route('EditarArea') }}";;
        const CambiarEstadoArea = "{{ route('CambiarEstadoArea') }}";;

        const VerFlujos =  "{{ route('VerFlujos') }}";
        const CambiarEstadoFlujo = "{{ route('CambiarEstadoFlujo') }}";
        /* END::RUTAS AREA */


        const credenciales= {!! json_encode($credenciales) !!}; //observacion, arreglar
        const credenciales2= {!! json_encode($credenciales) !!}; //observacion, arreglar
        console.log(credenciales);
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script> 
    <script src="{{ asset('js/datatables/contenido/flujo.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/estadoflujo.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/area.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->


    <!--begin::Eventos de la pagina-->
     <script src="{{ asset('js/global/main.js?id=4') }}"></script>
     <script src="{{ asset('js/eventos/flujo/main.js?id=1') }}"></script>
     <script src="{{ asset('js/eventos/flujo/flujo.js?id=1') }}"></script>
     <script src="{{ asset('js/eventos/estadoflujo/estadoflujo.js?id=2') }}"></script>
     <script src="{{ asset('js/eventos/area/area.js?id=3') }}"></script>

    <!--end::Eventos de la pagina-->
@endpush