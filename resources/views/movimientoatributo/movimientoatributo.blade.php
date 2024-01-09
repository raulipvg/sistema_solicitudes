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
                
            </div>
            <!-- Begin::HorizontalNav -->
            <div class="mb-5 hover-scroll-x">
                <div class="d-grid">
                    <ul class="nav nav-tabs flex-nowrap text-nowrap">
                        <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-success active" data-bs-toggle="tab" href="#panel-movimiento" aria-selected="true" role="tab">
                                <i class="ki-duotone ki-icons/duotune/general/gen001.svg fs-2 text-primary me-3"></i>
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bold text-capitalize">Movimientos</span>
                                    <span class="fs-7">Administrar movimientos</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-info justify-content-center " data-bs-toggle="tab" href="#panel-atributo" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ki-duotone ki-icons/duotune/general/gen003.svg fs-2 text-primary"></i>
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold text-capitalize">Atributos</span>
                                        <span class="fs-7">Administrar atributos</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-info justify-content-center " data-bs-toggle="tab" href="#kt_vtab_pane_6" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ki-duotone ki-icons/duotune/general/gen003.svg fs-2 text-primary"></i>
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold text-capitalize">movimiento_atributo</span>
                                        <span class="fs-7">Description</span>
                                    </span>
                                </a>
                            </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="panel-movimiento" role="tabpanel">
                    <button id="addBtnMovimiento" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar-movimiento">
                        Registrar
                    </button>
                    @include('movimiento.componente.tablaMovimiento')
                    @include('movimiento.componente.modalRegistrarMovimiento')
                </div>

                <div class="tab-pane fade" id="panel-atributo" role="tabpanel">
                    <button id="AddBtnAtr" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar-atributo">
                        Registrar
                    </button>
                    @include('atributo.componente.tablaAtributo')
                    @include('atributo.componente.modalRegistrarAtributo')
                </div>

                <div class="tab-pane fade" id="kt_vtab_pane_6" role="tabpanel">
                    @include('movimientoatributo.componente.crearMovimientoAtributo')
                </div>

            </div>
            
            <!-- End::HorizontalNav -->

            
        </div>
    </div>
</div>
<!--end::Content-->



@endsection

@push('Script')
    <script>
        const GuardarMovimientoAtributo = "{{ route('GuardarMovimientoAtributo') }}";
        
        const GuardarMovimiento = "{{ route('GuardarMovimiento') }}";
        const VerMovimiento = "{{ route('VerMovimiento') }}";
        const EditarMovimiento = "{{ route('EditarMovimiento') }}";
        const CambiarEstadoMovimiento = "{{ route('CambiarEstadoMovimiento') }}";
        const VerGruposFlujosMovimiento = "{{ route('VerGruposFlujosMovimiento') }}";
        
        const dataMovimientos =  {!! $movimientos !!};

        const GuardarAtributo = "{{ route('GuardarAtributo') }}";
        const VerAtributo = "{{ route('VerAtributo') }}";
        const EditarAtributo = "{{ route('EditarAtributo') }}";
        const CambiarEstadoAtributo = "{{ route('CambiarEstadoAtributo') }}";

        const dataAtributos = {!! $atributos !!};

        
    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/movimiento.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/atributo.js?id=2') }}"></script>



    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    
    <script src="{{ asset('js/eventos/movimientoatributo/movimientoatributo.js') }}"></script>
    <script src="{{ asset('js/eventos/movimiento/movimiento.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/atributo/atributo.js?id=3') }}"></script>

    
    <!--end::Eventos de la pagina-->

@endpush