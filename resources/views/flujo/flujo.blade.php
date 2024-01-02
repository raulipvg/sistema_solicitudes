@extends('layout.main')

@push('css')
<link href="" rel='stylesheet' type="text/css" />
<style>

</style>
@endpush


@section('main-content')
<!--begin::Toolbar-->
@include('layout.toolbar', ['titulo' => $titulo])
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">Estados de Solicitud</h3>
            <div class="m-1">
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                
            </div>
            
        </div>
    </div>
</div>
<!--end::Content-->

@endsection

@push('Script')
    <script>
       
    </script>
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/flujo/flujo.js?id=3') }}"></script>

    <!--end::Eventos de la pagina-->

@endpush