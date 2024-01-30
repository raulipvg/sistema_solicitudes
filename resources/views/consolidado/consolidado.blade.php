@extends('layout.main')

@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
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



</style>
@endpush

<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">{{$titulo}}</h3>                
        </div>
        <div class="card-body">
                @include('consolidado.componente.vistaConsolidado')
        </div>
    </div>
</div>
<!--end::Content-->




@endsection

@push('Script')
    <script>
        /* BEGIN::RUTAS */
       
        /* END:RUTAS */
        //const data =  {!! '' !!};
        //const credenciales= {!! json_encode('') !!};
        //const credenciales2= {!! json_encode('') !!};
        
        const layout= {!! json_encode($accesoLayout) !!};

        
    </script>

    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->

    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/consolidado/consolidado.js?id=3') }}"></script>
    <!--end::Eventos de la pagina-->

@endpush