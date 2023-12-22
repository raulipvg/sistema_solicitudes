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
<div class="toolbar p-3" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 flex-shrink-0 me-5">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Atributos
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-semibold my-1 ms-1">#XRS-45670</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap">
            
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">

    <div class="card mx-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">Atributos</h3>
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <table id="tabla-atributo" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Valor de Referencia</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="center-2">
                        <td>1</td>
                        <td class="text-capitalize">Vehículo</td>
                        <td>$50.000</td>
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-atributo fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Usuario">
                                <span class="indicator-label">ACTIVO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
                            </div>
                        </td>
                    </tr>

                    <tr class="center-2">
                        <td>2</td>
                        <td class="text-capitalize">Persona</td>
                        <td>$65.000</td>
                        <td data-search="Disabled">
                            <button class="btn btn-light-warning fs-7 estado-atributo text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Usuario">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Editar</a>
                            </div>
                        </td>
                        
                    </tr>

                    <tr class="center-2">
                        <td>3</td>
                        <td class="text-capitalize">Pasaje</td>
                        <td>$100.000</td>
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-atributo fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Usuario">
                                <span class="indicator-label">ACTIVO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
                            </div>
                        </td>
                        
                    </tr>

                    <tr class="center-2">
                        <td>4</td>
                        <td class="text-capitalize">Equipaje Bodega</td>
                        <td>$65.000</td>
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-atributo fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Usuario">
                                <span class="indicator-label">ACTIVO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
                            </div>
                        </td>
                        
                    </tr>

                    <tr class="center-2">
                        <td>5</td>
                        <td class="text-capitalize">Hotel</td>
                        <td>$100.000</td>
                        <td data-search="Disabled">
                            <button class="btn btn-light-warning fs-7 estado-atributo text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Usuario">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Editar</a>
                            </div>
                        </td>
                        
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Content-->

<!--begin::modal-->
<div class="modal fade" tabindex="-1" id="registrar" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Atributo</h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-3x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="1" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <form id="Formulario1" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el Nombre" id="NombreInput" name="Nombre" />
                                <label for="NombreInput" class="form-label">Nombre</label>
                                <input hidden type="number" id="IdInput" name="Id" />

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" autocomplete="off" placeholder="Ingrese el valor" id="ValorReferenciaInput" name="ValorReferencia" />
                                <label for="ValorReferenciaInput" class="form-label">Valor de referencia</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoIdInput" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <label for="EstadoIdInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                    <button id="EditSubmit" type="submit" class="btn btn-success">
                        <div class="indicator-label">Actualizar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>

                </div>
            </form>


        </div>
    </div>
</div>
<!--end::modal-->


@endsection

@push('Script')
    <script>
        const GuardarAtributo = "{{ route('GuardarAtributo') }}";
        const VerAtributo = "{{ route('VerAtributo') }}";
        const EditarAtributo = "{{ route('EditarAtributo') }}";
        const CambiarEstadoAtributo = "{{ route('CambiarEstadoAtributo') }}";


        //const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!--begin::Datatables y Configuracion de la Tabla-->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/atributo.js?id=2') }}"></script>
    <!--end::Datatables y Configuracion de la Tabla-->
    <!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/atributo.js?id=3') }}"></script>
    
    <!--end::Eventos de la pagina-->

@endpush