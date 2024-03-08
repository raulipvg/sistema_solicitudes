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
                <div class="col-12">
                    <ul class="nav nav-tabs row border-bottom-0">
                        <li class="nav-item col-md-6" role="presentation">
                            <a class="nav-link w-100 btn btn-flex btn-active-dark justify-content-center active" data-bs-toggle="tab" href="#panel-movimiento" aria-selected="true" role="tab">
                                <i class="fs-2 text-primary me-3"></i>
                                <span class="d-flex flex-column align-items-start align-items-center">
                                    <span class="fs-4 fw-bold text-capitalize">MOVIMIENTOS</span>
                                    <span class="fs-7">Administrar movimientos</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item col-md-6" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-dark justify-content-center" data-bs-toggle="tab" href="#panel-atributo" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="fs-2 text-primary"></i>
                                    <span class="d-flex flex-column align-items-start align-items-center">
                                        <span class="fs-4 fw-bold text-capitalize">ATRIBUTOS</span>
                                        <span class="fs-7">Administrar atributos</span>
                                    </span>
                                </a>
                            </li>
                    </ul>
                </div>
        <div class="card-body pt-5">
            <!-- Begin::HorizontalNav -->
            

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="panel-movimiento" role="tabpanel">
                    @if ($credenciales['puedeRegistrar'])
                        <button id="addBtnMovimiento" type="button" class="btn btn-sm btn-success float-end mx-2" data-bs-toggle="modal" data-bs-target="#registrar-movimiento" style="z-index: 10; position: relative;">
                            Registrar
                        </button>
                    @endif
                    @include('movimiento.componente.tablaMovimiento')

                    @if ($credenciales['puedeRegistrar'] || $credenciales['puedeEditar'] || $credenciales['puedeVer'])
                        @include('movimiento.componente.modalRegistrarMovimiento')
                    @endif
                </div>

                <div class="tab-pane fade" id="panel-atributo" role="tabpanel">
                    @if ($credenciales['puedeRegistrar'])
                        <button id="AddBtnAtr" type="button" class="btn btn-sm btn-success float-end mx-2" data-bs-toggle="modal" data-bs-target="#registrar-atributo" style="z-index: 10; position: relative;">
                            Registrar
                        </button>
                    @endif
                    @include('atributo.componente.tablaAtributo')

                    @if ($credenciales['puedeRegistrar'] || $credenciales['puedeEditar'] || $credenciales['puedeVer'])
                        @include('atributo.componente.modalRegistrarAtributo')
                    @endif
                </div>

            </div>
            
            <!-- End::HorizontalNav -->

            
        </div>
    </div>
</div>
<!--end::Content-->
@if ($credenciales['puedeRegistrar'])
    @include('movimientoatributo.componente.crearMovimientoAtributo')
@endif

@endsection

@push('Script')
    <script>
        const GuardarMovimientoAtributo = "{{ route('GuardarMovimientoAtributo') }}";
        const VerMovimientoAtributo = "{{ route('VerMovimientoAtributo') }}";
        const VerAtributosFaltantes = "{{ route('VerAtributosFaltantes') }}"
        
        const GuardarMovimiento = "{{ route('GuardarMovimiento') }}";
        const VerMovimiento = "{{ route('VerMovimiento') }}";
        const EditarMovimiento = "{{ route('EditarMovimiento') }}";
        const CambiarEstadoMovimiento = "{{ route('CambiarEstadoMovimiento') }}";
        const VerGruposFlujosMovimiento = "{{ route('VerGruposFlujosMovimiento') }}";
        
        const dataMovimientos =  JSON.parse('{!! $movimientos !!}');

        const GuardarAtributo = "{{ route('GuardarAtributo') }}";
        const VerAtributo = "{{ route('VerAtributo') }}";
        const EditarAtributo = "{{ route('EditarAtributo') }}";
        const CambiarEstadoAtributo = "{{ route('CambiarEstadoAtributo') }}";

	
        const dataAtributos = JSON.parse('{!! $atributos !!}');

        const credenciales= {!! json_encode($credenciales) !!};

        
    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=5') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=5') }}"></script>
    <script src="{{ asset('js/datatables/contenido/movimiento.js?id=5') }}"></script>
    <script src="{{ asset('js/datatables/contenido/atributo.js?id=5') }}"></script>



    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=5') }}"></script>
    
    <script src="{{ asset('js/eventos/movimientoatributo/movimientoatributo.js?id=5') }}"></script>
    <script src="{{ asset('js/eventos/movimiento/movimiento.js?id=5') }}"></script>
    <script src="{{ asset('js/eventos/atributo/atributo.js?id=5') }}"></script>

    
    <!--end::Eventos de la pagina-->

@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif