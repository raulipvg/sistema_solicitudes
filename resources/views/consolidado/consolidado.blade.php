@extends('layout.main')

@section('main-content')

@push('css')
<link href="{{ asset('css/datatables/datatables.bundle.css?id=2') }}" rel='stylesheet' type="text/css" />
<style>
.rounded-bottom-1 {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
}
.rounded-top-1{
    border-top-left-radius: 20px!important;
    border-top-right-radius: 20px !important;
}
.bg-dark-2{
    background-color: #404040;
}
@media  ( min-width: 768px) {
  .top-md {
    position: relative;
    top: -572px;
  }
  .top-md-2 {
    position: relative;
    top: -665px;
  }
}
.nav-link{
	color: var(--bs-text-gray-500);
}
.btn-check:active+.btn.btn-active-color-primary, .btn-check:checked+.btn.btn-active-color-primary, .btn.btn-active-color-primary.active, .btn.btn-active-color-primary.show, .btn.btn-active-color-primary:active:not(.btn-active), .btn.btn-active-color-primary:focus:not(.btn-active), .btn.btn-active-color-primary:hover:not(.btn-active), .show>.btn.btn-active-color-primary {
    color: var(--bs-text-dark);
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
       
        /* END:RUTAS */
        //const data =  {!! '' !!};
        //const credenciales= {!! json_encode('') !!};
        //const credenciales2= {!! json_encode('') !!};
        const VerCompuesta ="{{ route('VerCompuesta')}}";
        
        const layout= {!! json_encode($accesoLayout) !!};

        
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/consolidado_detalle.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/consolidado/consolidado.js?id=3') }}"></script>
    <!--end::Eventos de la pagina-->

@endpush