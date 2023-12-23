            <table id="tabla-empresa" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">RUT</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    
                    <tr class="center-2">
                        <td>1</td>
                        <td class="text-capitalize">Empresa 1</td>
                        <td>54.323.232-2</td>
                        <td>empresa@empresa.cl</td>
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-empresa fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Empresa">
                                <span class="indicator-label">ACTIVO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Centro de Costos Asociados">
                                <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                                <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                                <span class="indicator-label"></span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                    </tr>

                    <tr class="center-2">
                        <td>2</td>
                        <td class="text-capitalize">Empresa 2</td>
                        <td>nombre</td>
                        <td>empresa2@empresa.cl</td>
                        <td data-search="Disabled">
                            <button class="btn btn-light-warning fs-7 estado-empresa text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Empresa">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="2">Editar</a>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Centro de Costos Asociados">
                                <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                                <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                                <span class="indicator-label"></span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>