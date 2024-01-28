<div class="modal fade" tabindex="-1" id="registrar-atributo" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-atr" class="modal-title text-uppercase">Registrar Atributo</h2>

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
            <form id="FormularioAtributo" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaErrorAtr" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control text-capitalize " placeholder="Ingrese el Nombre" id="NombreAtInput" name="Nombre" />
                                <label for="NombreAtInput" class="form-label">Nombre</label>
                                <input hidden type="number" id="IdInputAtr" name="Id" />

                            </div>
                        </div>
                        
                    </div>
                    <div class="row">                        
                        <div class="col-4 mb-2">
                            <div class="form-floating fv-row">
                                <select id="TipoMonedaIdAtInput" name="TipoMonedaId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($tiposMoneda as $tipoMoneda)
                                    <option value="{{$tipoMoneda->Id}}">{{$tipoMoneda->Simbolo}}</option>
                                    @endforeach
                                </select>
                                <label for="TipoMonedaIdAtInput" class="form-label">Moneda</label>
                            </div>
                        </div>
                        <div class="col-8 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" autocomplete="off" placeholder="Ingrese el valor" id="ValorReferenciaInput" name="ValorReferencia" style="min-height: 57.55px;"/>
                                <label for="ValorReferenciaInput" class="form-label">Valor de referencia</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoIdAtInput" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="0">Deshabilitado</option>
                                </select>
                                <label for="EstadoIdAtInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmitAtr" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                    <button id="EditSubmitAtr" type="submit" class="btn btn-success">
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