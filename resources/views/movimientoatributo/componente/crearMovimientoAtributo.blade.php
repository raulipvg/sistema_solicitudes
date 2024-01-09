
<div class="d-flex justify-content-center align-items-center mb-1 mt-4" >
    <div class="card card-bordered" style="width: 70%;">
        <form id="form-movimiento-atributo">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="form-floating fv-row">
                        <select id="MovimientoIdInput" name="MovimientoId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" >
                            <option></option>
                            @foreach($movimientos as $movimiento)
                            <option value='{{$movimiento->Id}}'>{{ $movimiento->Nombre}}</option>
                            @endforeach
                        </select>
                        <label for="MovimientoIdInput" class="form-label">Movimiento</label>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-floating fv-row">
                        <select id="AtributoIdInput" name="AtributoId" class="form-select " data-control="select2" data-placeholder="Seleccione" data-close-on-select="false" data-hide-search="true" multiple="multiple"> 
                        <option></option>
                            @foreach($atributosSelect as $atributo)
                            <option value='{{$atributo->Id}}'>{{ $atributo->Nombre}}</option>
                            @endforeach
                        </select>
                        <label for="AtributoIdInput" class="form-label">Atributo(s)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" card-footer justify-content-end ">
                    <button id="AddSubmitMovAtr" type="submit" class="btn btn-success">
                        <div class="indicator-label">Guardar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
            </div>
        </form>
    </div>
</div>