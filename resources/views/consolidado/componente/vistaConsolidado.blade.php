<!--begin::Content-->


            <div id="contenedor-1" class="col-12 mb-3">                   
                    <div class="p-2">
                        <div id="contenedor-controles" class="d-flex flex-row  align-items-center">
                            <div class="w-md-200px w-150px my-1 mx-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Empresa">
                                <select id="EmpresaIdInput" name="EmpresaId" class="form-select" data-control="select2" data-placeholder="Seleccione Empresa" data-hide-search="true">
                                    <option selected></option>
                                    <option value="1">TODAS</option>
                                    @foreach ($empresas as $empresa )
                                    <option value="{{ $empresa->Id}}">{{$empresa->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-md-200px w-150px my-1 mx-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Movimiento">
                                <select id="MovimientoIdInput" name="MovimientoId" class="form-select" data-control="select2" data-placeholder="Seleccione Movimiento" data-hide-search="true">
                                    <option selected></option>
                                    @foreach ($movimientos as $movimiento )
                                    <option value="{{ $movimiento->Id}}">{{$movimiento->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="contenedor-cc" class="card">
                                <h3 class="mx-3 mb-0">Centros de Costos - Movimiento 1</h3>
                            <div class="card-body card-scroll p-2" style="max-height: 300px;">
                                <ul class="nav nav-pills d-flex justify-content-between nav-pills-custom gap-3" role="tablist">
                                
                                    @foreach ($centrocostos as $cc )
                                    <!--begin::Item-->
                                    <li class="nav-item position-relative me-0" role="presentation">
                                        <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="left" title="Ver Solicitudes Asociadas">

                                        
                                        <button type="button" class="btn-plus btn ver-solicitudes btn-icon btn-color-danger btn-active-light btn-active-color-primary position-absolute m-1" data-bs-toggle="modal" data-bs-target="#solicitudes" >
                                            <i class="ki-outline ki-plus-square fs-2"></i>
                                        </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Ver Cobros" >
                                            <!--begin::Nav link-->
                                            <a class="nav-link nav-link-border-solid ver-detalle btn btn-outline btn-flex btn-active-color-primary bg-light p-1 page-bg justify-content-center"
                                                data-info="{{$cc->Id}}" data-bs-toggle="pill" style="width: 150px;height: 80px" aria-selected="true" role="tab" href="#detalle-cc">
                                                @php
                                                    $nombreParts = explode(' - ', $cc->Nombre);
                                                @endphp
                                                <!--begin::Info-->
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="fw-semibold fs-7 text-capitalize">{{ $nombreParts[0] }}</span>
                                                    <span class="fw-bold fs-6 d-block text-uppercase">{{ $nombreParts[1] }} </span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::Nav link-->
                                        </div>
                                    </li>
                                    <!--end::Item-->
                                    @endforeach
                                </ul>
                            </div> 
                        </div>
                        <div class="tab-content m-4">
                            <div id="detalle-cc" class="tab-pane fade border border-2 p-4 rounded">
                                <h3 class="card-title text-uppercase">Movimiento 1 - Detalle de Cobros</h3>
                               @include('consolidado.componente.tablaDetalle')
                            </div>


                        </div>          
                    </div>
            </div>

<!--end::Content-->