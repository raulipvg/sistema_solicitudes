@extends('layout.main')

@section('main-content')

@push('css')
<link href="{{ asset('css/datatables/datatables.bundle.css?id=2') }}" rel='stylesheet' type="text/css" />
<style>
.puntero{
	cursor: pointer;
}
.btn-plus{
    z-index: 2;
    height: 25px!important;
    width: 25px!important;
}
</style>
@endpush

<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">{{$titulo}}</h3>                
        </div>
        <div class="card-body p-1">
                @include('consolidado.componente.vistaConsolidado')
        </div>
    </div>
</div>
<!--end::Content-->



@include('consolidado.componente.modalSolicitud')

@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS */
        const VerConsolidados = "{{ route('VerConsolidados') }}"       
        const VerDetallesAsociados ="{{ route('VerDetallesAsociados')}}";
        const VerSolicitudesAsociadas = "{{ route('VerSolicitudesAsociadas') }}";
       

        /* END:RUTAS */        
        
        const layout= {!! json_encode($accesoLayout) !!};

        
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/consolidado_detalle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/solicitud_terminada.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/consolidado/consolidado.js?id=3') }}"></script>
    <!--end::Eventos de la pagina-->

@endpush