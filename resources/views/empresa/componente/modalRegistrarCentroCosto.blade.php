<div class="modal fade" tabindex="-1" id="registrar-cc" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear2">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar un Centro de Costo</h2>

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
            <form id="Formulario-CC" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control h-input text-capitalize" placeholder="Ingrese el nombre" id="NombreInput2" name="Nombre" />
                                <label for="NombreInput2" class="form-label">Nombre</label>
                            </div>
                        </div>
                        <input hidden type="number" id="EmpresaIdInput" name="EmpresaId" />
                        
                    </div>                
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit-cc" type="submit" class="btn btn-success">
                        <div class="indicator-label">Asignar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>

                </div>
            </form>


        </div>
    </div>
</div>