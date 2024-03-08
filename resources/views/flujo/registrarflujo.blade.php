@if ($credenciales['Flujo']['puedeRegistrar'])

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
.select-size {
    max-height: 40px!important;
    min-height: auto!important;
}
.form-select.form-select-solid {
    background-color: #353A40;
    border-color: #353A40;
    color: var(--bs-gray-700);
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
            <h3 class="card-title text-uppercase text-white">FLUJO</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1 flex-column">

                

                <!--BEGIN::CARD STEPPER CREAR UN FLUJO-->
                <div class="card card-bordered" style="width: 90%;">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">DISEÑAR FLUJO</h3>
                        </div>
                    </div>
                    <div class="card-body p-1 py-5">
                        <!--begin::Stepper-->
                        <div class="stepper stepper-pills" id="kt_stepper_flujo">
                            <!--begin::Nav-->
                            <div class="stepper-nav flex-md-center flex-wrap mb-5 ms-10 ms-md-0">
                                <!--begin::Step 1-->
                                <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check ki-duotone ki-check fs-2x"></i>
                                            <span class="stepper-number">1</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Paso 1</h3>
                                            <div class="stepper-desc">Crear un Flujo</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check ki-duotone ki-check fs-2x"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <!--begin::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Paso 2</h3>
                                            <div class="stepper-desc">Diseñar un Flujo</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 2-->

                                <!--begin::Step 3-->
                                <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                <!--begin::Wrapper-->
                                    <div class="stepper-wrapper d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check ki-duotone ki-check fs-2x"></i>
                                            <span class="stepper-number">3</span>
                                        </div>
                                        <!--begin::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Paso 3</h3>
                                            <div class="stepper-desc">Confirmación</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 3-->                               
                            </div>
                            <!--end::Nav-->

                            <div class="d-flex justify-content-center">
                                <div class="col-10">
                                <!--begin::Form-->
                                <form class="form" id="FormularioFlujo">

                                    <!--begin::Group-->
                                    <div class="mb-5 mx-md-20 mx-sm-0 mx-0">

                                        <!--begin::Step 1-->
                                        <div class="flex-column current" data-kt-stepper-element="content">
                                                <div class="modal-body">                                                    
                                                        <div class="col mb-2">
                                                            <div class="form-floating fv-row">
                                                                <input type="text" class="form-control" placeholder="Ingrese el Nombre" id="NombreInput" name="Nombre" />
                                                                <label for="UsernameInput" class="form-label">Nombre del Flujo</label>
                                                                <input hidden type="number" id="NombreInput" name="Id" />
                                                            </div>
                                                        </div>
                                                        <div class="col mb-2">
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
                                                    
                                                    <div class="row">
                                                        <div class="col mb-2">
                                                            <div class="form-floating fv-row">
                                                                <select id="GrupoIdInput" name="GrupoId" class="form-select" data-control="select2" data-placeholder="Seleccione el grupo administrador del flujo" data-hide-search="false">
                                                                    <option></option>
                                                                    @foreach ( $grupos as $grupo )
                                                                        <option value="{{ $grupo->Id }}">{{ $grupo->Nombre}} </option>
                                                                    @endforeach                               
                                                                
                                                                </select>
                                                                <label for="GrupoIdInput" class="form-label">Grupo Administrador</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                        <!--begin::Step 1-->

                                        <!--begin::Step 2-->
                                        <div class="flex-column" data-kt-stepper-element="content">
                                            <!--BEGIN::CARD DE LOS ESTADOS DEL FLUJO-->
                                            <div class="card card-bordered mb-5">
                                                <!--begin::Card header-->
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h3 class="card-label">ESTADOS DISPONIBLES</h3>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body p-0 hover-scroll-x no-select">
                                                    <!--begin::Row-->
                                                    <div id="estadoDisponible" class="d-flex flew-row align-items-center draggable-zone min-h-50px" tabindex="0">
                                                        
                                                    @foreach ( $estados as $estado )
                                                        <div class="draggable mx-2" data-info="{{ $estado->Id }}">
                                                            <div class="card bg-dark align-items-center align-self-center justify-content-center px-2">
                                                                <div class="d-flex flex-column">
                                                                    <div class="card-estado py-1" hidden>
                                                                        <select name="Enabled" class="form-select form-select-sm form-select-solid select2-negro" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                                                                            <option></option>
                                                                            @foreach ($grupos as $grupo)
                                                                                <option value="{{ $grupo->Id }}" > {{ $grupo->Nombre }}
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="draggable-handle min-h-40px d-flex align-items-center justify-content-center">
                                                                        <span class="text-white fw-semibold fs-6 text-uppercase">{{ $estado->Nombre }}</span>
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
                                            <div id="disenoFlujo" class="card card-bordered mb-10" >
                                                <!--begin::Card header-->
                                                <div class="card-header bg-dark ">
                                                    <div class="card-title">
                                                        <h3 class="card-label text-white">DISEÑAR FLUJO</h3>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->

                                                <!--begin::Card body-->
                                                <div class="card-body p-2 no-select">
                                                    <div id="AlertaErrorFlujoPaso2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                                                    </div>                    
                                                    <div class="d-flex flew-row align-items-center justify-content-center min-h-100px">

                                                        <div class="d-flex flex-column">                            
                                                            <div class="symbol symbol-40px">
                                                                <span class="symbol-label bg-success">
                                                                    <i class="ki-duotone ki-to-right text-white fs-3x"><span class="path1"></span><span class="path2"></span></i>
                                                                </span>
                                                            </div>
                                                            <span class="text-gray-800 fw-bold text-center">Inicio</span>
                                                        </div>

                                                        <!--begin::Row-->
                                                        <div id="nuevoFlujo" class="d-flex align-items-center draggable-zone min-h-100px min-w-25 hover-scroll-x">                          
                                                             
                                                        </div>
                                                        <!--end::Row-->

                                                        <div class="d-flex flex-column">                            
                                                            <div class="symbol symbol-40px">
                                                                <span class="symbol-label bg-dark">
                                                                    <i class="ki-duotone ki-abstract-5 text-white fs-3x">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                            </div>
                                                            <span class="text-gray-800 fw-bold text-center">FIN</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                                
                                            </div>
                                            <!--END::CARD PARA CREAR UN FLUJO-->
                                        </div>
                                        <!--begin::Step 2-->

                                        <!--begin::Step 3-->
                                        <div class="flex-column" data-kt-stepper-element="content">
                                            <div id="AlertaErrorFlujo" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row">
                                                <label class="form-label d-flex align-items-center">
                                                    <span class="required">Nombre del Flujo</span>
                                                </label>
                                                <input id="NombreCheck" type="text" class="form-control form-control-solid  text-capitalize" name="input1" placeholder="" value="" disabled/>
                                            </div>
                                            <!--end::Input group-->
                                            <div class="fv-row">
                                                <label class="form-label d-flex align-items-center">
                                                    <span class="required">Area</span>
                                                </label>
                                                <input id="AreaCheck" type="text" class="form-control form-control-solid text-capitalize" name="input1" placeholder="" value="" disabled/>
                                            </div>
                                            <div class="fv-row">
                                                <label class="form-label d-flex align-items-center">
                                                    <span class="required">Grupo Administrador</span>
                                                </label>
                                                <input id="GrupoCheck" type="text" class="form-control form-control-solid text-capitalize" name="input1" placeholder="" value="" disabled/>
                                            </div>
                                            <div id="check" class="fv-row mt-3">

                                            </div>
                                        </div>
                                        <!--begin::Step 3-->

                                        
                                    </div>
                                    <!--end::Group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Wrapper-->
                                        <div class="me-2">
                                            <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                                Atrás
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->

                                        <!--begin::Wrapper-->
                                        <div>
                                            <button id="AddSubmitFlujo" type="button" class="btn btn-success" data-kt-stepper-action="submit">
                                                <span class="indicator-label">CREAR</span>
                                                <span class="indicator-progress">Espere... 
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>

                                            <button id="ContinuarBtn" type="button" class="btn btn-dark" data-kt-stepper-action="next">
                                                Continuar
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Actions-->


                                </form>
                                <!--end::Form-->
                                </div>
                            </div>
                        </div>
                        <!--end::Stepper-->
                    </div>
                </div>

                
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
    <script src="{{ asset('js/eventos/flujo/registrar.js?id=3') }}"></script>

    <script>


    </script>

    <!--end::Eventos de la pagina-->

@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif