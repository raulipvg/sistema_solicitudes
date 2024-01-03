@extends('layout.main')

@push('css')
<link href="" rel='stylesheet' type="text/css" />
<style>
.no-select {
    user-select: none; /* Propiedad que desactiva la selección de texto */
    -moz-user-select: none; /* Para Firefox */
    -ms-user-select: none; /* Para Internet Explorer / Edge */
    -webkit-user-select: none; /* Para Safari / Google Chrome */
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
        <div class="card-header bg-dark">
            <h3 class="card-title text-uppercase text-white">CREAR FLUJO</h3>
            <div class="m-1">
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1 flex-column">

                <!--BEGIN::CARD DE LOS ESTADOS DEL FLUJO-->
                <div class="card card-bordered mb-10" style="width: 70%;">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">ESTADOS DISPONIBLES</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-2 hover-scroll-x no-select">
                        <!--begin::Row-->
                        <div class="d-flex flew-row align-items-center draggable-zone min-h-100px" tabindex="0">
                            
                        @foreach ( $estados as $estado )
                            <div class="draggable mx-2" data-info="{{ $estado->Id }}">
                                <div class="card draggable-handle bg-dark min-h-55px align-items-center">
                                    <div class="d-flex align-items-center card-body p-2">
                                        <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                                            <div class="d-flex text-center">
                                                <span class="text-white fw-semibold fs-6 text-uppercase">{{ $estado->Nombre }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </div>
                        <!--end::Row-->
                        
                        
                    </div>
                    <!--end::Card body-->
                </div>
                <!--END::CARD DE LOS ESTADOS DEL FLUJO-->

                <!--BEGIN::CARD PARA CREAR UN FLUJO-->
                <div class="card card-bordered mb-10" style="width: 70%;">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">DISEÑAR FLUJO</h3>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body p-2 no-select">                    
                        <div class="d-flex flew-row align-items-center justify-content-center min-h-100px">

                            <div class="d-flex flex-column">                            
                                <i class="ki-duotone ki-to-right fs-3x pt-2"></i>
                                <span class="text-gray-800 fw-bold text-center">Inicio</span>
                            </div>

                            <!--begin::Row-->
                            <div id="nuevoFlujo" class="d-flex align-items-center draggable-zone min-h-100px min-w-25 hover-scroll-x">                          
                                 
                            </div>
                            <!--end::Row-->

                            <div class="d-flex flex-column">                            
                                <i class="ki-duotone ki-abstract-5 fs-3x pt-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="text-gray-800 fw-bold text-center">FIN</span>
                            </div>

                        </div>
                    </div>
                    <!--end::Card body-->
                    <div class="card-footer bg-light">
                        <form id="FormularioFlujo" action="" method="post" >
                            <div class="modal-body">
                                <div id="AlertaErrorFlujo" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-floating fv-row">
                                            <input type="text" class="form-control" placeholder="Ingrese el Nombre" id="NombreInput" name="Nombre" />
                                            <label for="UsernameInput" class="form-label">Nombre del Flujo</label>
                                            <input hidden type="number" id="NombreInput" name="Id" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-floating fv-row">
                                            <select id="AreaIdInput" name="AreaId" class="form-select" data-control="select2" data-placeholder="Seleccione Area" data-hide-search="false">
                                                <option></option>
                                                @foreach ( $areas as $area )
                                                <option value="{{ $area->Id }}"> {{ $area->Nombre}}</option>                                   
                                                @endforeach
                                            </select>
                                            <label for="AreaIdInput" class="form-label">Area</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-floating fv-row">
                                            <select id="GrupoIdInput" name="GrupoId" class="form-select" data-control="select2" data-placeholder="Seleccione Grupo Encargado" data-hide-search="false">
                                                <option></option>
                                                @foreach ( $grupos as $grupo )
                                                    <option value="{{ $grupo->Id }}">{{ $grupo->Nombre}} </option>
                                                @endforeach                               
                                            
                                            </select>
                                            <label for="CentroCostoInput" class="form-label">Grupo Encargado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2 tex-end d-flex  align-items-center justify-content-end">
                                        <div>
                                        <button id="AddSubmitFlujo" type="submit" class="btn btn-success">
                                            <div class="indicator-label">CREAR FLUJO</div>
                                            <div class="indicator-progress">Espere...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </div>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--END::CARD PARA CREAR UN FLUJO-->

                
            </div>
            
        </div>
    </div>
</div>
<!--end::Content-->

@endsection

@push('Script')
    <script>
       const GuardarFlujo = "{{route('GuardarFlujo')}}";
    </script>
    <!--begin::Eventos de la pagina-->
    
    <script src="{{ asset('js/draggable/draggable.bundle.js?id=3') }}"></script>
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/flujo/flujo.js?id=3') }}"></script>

    <!--end::Eventos de la pagina-->

@endpush