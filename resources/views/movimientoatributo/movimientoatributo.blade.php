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
            @include('movimientoatributo.componente.crearMovimientoAtributo')
        </div>
    </div>
</div>
<!--end::Content-->



@endsection

@push('Script')
    <script>
        const GuardarMovimientoAtributo = "{{ route('GuardarMovimientoAtributo') }}";
        
        

        //const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/movimientoatributo/movimientoatributo.js') }}"></script>
    
    <!--end::Eventos de la pagina-->

@endpush