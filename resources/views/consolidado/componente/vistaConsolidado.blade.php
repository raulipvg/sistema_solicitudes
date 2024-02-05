<!--begin::Content-->


            <div id="contenedor-1" class="col-12 mb-3">                   
                    <div class="p-2">
                        <div id="contenedor-controles">
                            <div class="row col-md-10">
                            <div class="col-md-2 col-6 mb-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Empresa">
                                <select id="EmpresaIdInput" name="EmpresaId" class="form-select" data-control="select2" data-placeholder="Seleccione Empresa" data-hide-search="false" data-allow-clear="true">
                                    <option ></option>
                                    <option>Todo</option>
                                    @foreach ($empresas as $empresa )
                                    <option value="{{ $empresa->Id}}">{{$empresa->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 col-6 mb-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Centro de Costo">
                                <select id="CentroCostoIdInput" name="CentroCostoId" class="form-select" data-control="select2" data-placeholder="Seleccione Centro de costo" data-hide-search="false" data-allow-clear="true">
                                    <option ></option>
                                    @foreach ($centrocostos as $centro )
                                    <option value="{{ $centro->Id}}">{{$centro->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 col-5 mb-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Movimiento">
                                <select id="MovimientoIdInput" name="MovimientoId" class="form-select" data-control="select2" data-placeholder="Seleccione Movimiento" data-hide-search="false" data-allow-clear="true">
                                    <option selected></option>
                                    @foreach ($movimientos as $movimiento )
                                    <option value="{{ $movimiento->Id}}">{{$movimiento->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-4 mb-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Fecha">
                                <select id="ConsolidadoIdInput" name="ConsolidadoId" class="form-select" data-control="select2" data-placeholder="Fecha" data-hide-search="false">
                                    <option selected></option>
                                    @foreach ($consolidados as $consolidado )
                                    <option value="{{ $consolidado->Id}}">{{$consolidado->Mes}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-3 mb-2">
                            <button id="ConsultarBtn" type="button" class="btn btn-dark">Consultar</button>
                            </div>
                            </div>

                        </div>
                            <div id="detalle-cc" class="border border-dashed border-2 p-4 pt-0 rounded">
                                <h3 class="card-title text-uppercase"></h3>
                               @include('consolidado.componente.tablaDetalle')
                            </div>          
                    </div>
            </div>

<!--end::Content-->