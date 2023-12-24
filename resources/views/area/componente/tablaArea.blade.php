            <table id="tabla-area" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ( $areas as $area )
                        <tr class="center-2">
                            <td>{{ $area->Id }}</td>
                            <td>{{ $area->Nombre }}</td>
                            <td class="text-capitalize">{{ $area->Descripcion }}</td>
                            <td>{{\Carbon\Carbon::parse($area->created_at)->format('d-m-Y')}}</td>
                            @if ($area->Enabled == 1 )
                                <td data-search="Enabled">
                                    <button class="btn btn-sm btn-light-success estado-area fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Area">
                                        <span class="indicator-label">ACTIVO</span>
                                        <span class="indicator-progress">
                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                        </span>
                                    </button>
                                </td>
                            @else
                                <td data-search="Disabled">
                                <button class="btn btn-light-warning fs-7 estado-area text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Area">
                                    <span class="indicator-label">Inactivo</span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                </button>
                                </td>
                            @endif
                            <td class="text-center p-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $area->Id }}">Ver</a>
                                    <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $area->Id }}">Editar</a>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Flujos Asociados">
                                    <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                                    <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                                    <span class="indicator-label"></span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach                    
                </tbody>
            </table>