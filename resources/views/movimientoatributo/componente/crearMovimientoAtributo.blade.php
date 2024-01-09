
<div class="modal fade" tabindex="-1" id="registrar-movAtributo" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-movimientoAtr" class="modal-title text-uppercase">Asignar atributo</h2>

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
            <form id="form-movimiento-atributo" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaErrorMovAtr" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                            <div class="form-floating fv-row">
                                <select id="MovimientoIdInputAtr" name="MovimientoId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" >
                                    <option></option>
                                    @foreach($movimientos as $movimiento)
                                    <option value='{{$movimiento->Id}}' class="text-capitalize">{{ $movimiento->Nombre}}</option>
                                    @endforeach
                                </select>
                                <label for="MovimientoIdInputAtr" class="form-label">Movimiento</label>
                            </div>
                    </div>
                    <div class="row">
                           <div class="form-floating fv-row">
                                <select id="AtributoIdInputMov" name="AtributoId" class="form-select " data-control="select2" data-placeholder="Seleccione" data-close-on-select="false" data-hide-search="true" multiple="multiple"> 
                                    <option></option>
                                        @foreach($atributosSelect as $atributo)
                                        <option value='{{$atributo->Id}}'>{{ $atributo->Nombre}}</option>
                                        @endforeach
                                </select>
                                <label for="AtributoIdInputMov" class="form-label">Atributo(s)</label>
                            </div>
                    </div>

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmitMovAtr" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>