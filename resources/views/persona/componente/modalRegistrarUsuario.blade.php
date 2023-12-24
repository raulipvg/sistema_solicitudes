<div class="modal fade" tabindex="-1" id="registrar-acceso-sistema" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear2">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-acceso" class="modal-title text-uppercase">Registrar Usuario</h2>

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
            <form id="FormularioAccesoSistema" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el username" id="UsernameInput" name="Username" autocomplete="off" />
                                <label for="UsernameInput" class="form-label">Username</label>
                            </div>
                            <input hidden type="number" id="PersonaIdInput" name="PersonaId" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="password" class="form-control" autocomplete="off" placeholder="Ingrese la password" id="PasswordInput" name="Password" />
                                <label for="PasswordInput" class="form-label">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="email" class="form-control h-input" placeholder="Ingrese el email" id="CorreoInput" name="Email" autocomplete="off" />
                                <label for="CorreoInput" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoIdInput3" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="1">Deshabilitado</option>
                                </select>
                                <label for="EstadoIdInput3" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit-acceso-sistema" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar Usuario</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>

                </div>
            </form>


        </div>
    </div>
</div>