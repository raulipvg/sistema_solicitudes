<div class="modal fade" tabindex="-1" id="crearSolicitud" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Realizar Solicitud</h2>

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
            <form id="FormularioSolicitud" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaErrorSolicitud" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="PersonaIdInput" name="PersonaId" class="form-select" data-control="select2" data-placeholder="Seleccione a la persona" data-hide-search="false" data-dropdown-parent="#crearSolicitud">
                                    <option></option>
                                    @foreach ( $personas as $persona )
                                    <option value="{{ $persona->Id }}">{{ $persona->NombreCompleto }}</option>
                                    @endforeach
                                    
                                </select>
                                <label for="PersonaIdInput" class="form-label">Destinatario de la Solicitud</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="CentroCostoIdInput" name="CentroCostoId" class="form-select" data-control="select2" data-placeholder="Seleccione el centro de costo asociado" data-hide-search="false" data-dropdown-parent="#crearSolicitud">
                                    <option></option>
                                    @foreach ( $centrocostos as $centrocosto )
                                    <option value="{{ $centrocosto->Id }}">{{ $centrocosto->Nombre }}</option>
                                    @endforeach
                                    
                                </select>
                                <label for="CentroCostoIdInput" class="form-label">Centro de Costo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="MovimientoInput" name="MovimientoId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" data-dropdown-parent="#crearSolicitud">
                                    <option></option>
                                    @foreach ( $movimientos as $movimiento )
                                    <option value="{{ $movimiento->Id }}">{{ $movimiento->Nombre }}</option>
                                    @endforeach
                                    
                                </select>
                                <label for="MovimientoInput" class="form-label">Movimiento</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <!--begin::Flatpickr-->
                            <div class="form-floating fv-row">
                                <input id="Fecha" class="form-control" name="Fecha" placeholder="Pick date range"  />
                                <label for="MovimientoInput" class="form-label">Rango de Fecha</label>
                            </div>
							<!--end::Flatpickr-->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div id="elegir-movimientos" class="col border rounded mx-3 p-2">
                            <div class="card">
                                <div class="fs-7 text-gray-700 ps-2">
                                    Atributos a elegir
                                </div>
                                <div class="card-body hover-scroll-y p-0 mh-45px">                                    
                                    <div id="contenedor-movimiento">
                                        <!--
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        <button type="button" class="btn btn-light-dark movimiento-atributo mx-1 mb-2">ATRIBUTO</button>
                                        -->

                                    </div>
                                </div>
                                
                                
                                
                                
                            </div>
                            
                        </div>

                    </div>
                    <div id="contenedor-movimiento-2" class="mx-6 d-flex flex-column justify-content-center align-items-center">
                        <!--
                        <div class="row compuesta">
                            <div class="col-md-3 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="NombreInput" name="Nombre" />
                                    <label for="NombreInput" class="form-label">Nombre</label>
                                </div>
                                <input hidden type="number" id="MovimientoAtributoIdInput" name="MovimientoAtributoId" />
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="CaracteristicaInput" name="Caracteristica" />
                                    <label for="NombreInput" class="form-label">Caracteristica</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="number" class="form-control" placeholder="Ingrese el Costo" id="CostoRealInput" name="CostoReal" />
                                    <label for="CostoRealInput" class="form-label">Costo</label>
                                </div>
                            </div>
                            <div class="col-md-1 mb-2">
                                    <a class="btn btn-sm btn-flex flex-center btn-light-danger">
                                        <i class="ki-duotone ki-trash fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>                                        
                                    </a>
                            </div>
                        </div>
                        -->
                    </div>
                    

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmitSolicitud" type="button" class="btn btn-success">
                        <div class="indicator-label">Solicitar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>                    
                </div>
            </form>


        </div>
    </div>
</div>