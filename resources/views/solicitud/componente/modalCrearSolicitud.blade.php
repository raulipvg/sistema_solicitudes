<div class="modal fade" tabindex="-1" id="crearSolicitud" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Crear Solicitud</h2>

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
                    <div class="row">
                        <div class="col mb-2">
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
                    </div>
                    Crear Solicitud

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>                    
                </div>
            </form>


        </div>
    </div>
</div>