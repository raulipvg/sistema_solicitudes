<div class="modal fade" tabindex="-1" id="editar-flujo" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-20">
        <div class="modal-content" id="div-bloquear-flujo">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-flujo" class="modal-title text-uppercase">Editar Flujo</h2>

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
            <form id="FormularioFlujo" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaErrorFlujo" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input id="NombreFlujoInput" type="text" class="form-control text-capitalize" placeholder="Ingrese el nombre"  name="Nombre" />
                                <label for="NombreFlujoInput" class="form-label">Nombre del Flujo</label>
                                <input hidden type="number" id="IdFlujoInput" name="Id" />

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="AreaIdInput" name="AreaId" class="form-select" data-control="select2" data-placeholder="Seleccione Area" data-hide-search="false" data-dropdown-parent="#editar-flujo">
                                    <option></option>
                                    <option value="1">Area 1</option>
                                    <option value="0">Area 2</option>
                                </select>
                                <label for="AreaIdInput" class="form-label">Area</label>
                            </div>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="GrupoIdInput" name="GrupoId" class="form-select" data-control="select2" data-placeholder="Seleccione el grupo administrador del flujo" data-hide-search="false" data-dropdown-parent="#editar-flujo">
                                    <option></option>
                                </select>
                                <label for="GrupoIdInput" class="form-label">Grupo Administrador</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoIdFlujoInput" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="0">Deshabilitado</option>
                                </select>
                                <label for="EstadoIdFlujoInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>
                    <!--BEGIN::CARD PARA CREAR UN FLUJO-->
                    <div id="disenoFlujo" class="card card-bordered mb-10" >
                        <!--begin::Card header-->
                        <div class="card-header bg-dark ">
                            <div class="card-title">
                                <h3 class="card-label text-white">DISEÑO DEL FLUJO</h3>
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
                                <div id="nuevoFlujo" class="d-flex align-items-center min-h-100px hover-scroll-x">                          
                                                                
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
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="EditSubmitFlujo" type="submit" class="btn btn-success">
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