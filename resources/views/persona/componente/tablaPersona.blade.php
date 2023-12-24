            <table id="tabla-persona" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">RUT</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">CC</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($personas as $persona )
                        <tr class="center-2">
                            <td>{{ $persona->Id }}</td>
                            <td class="text-capitalize"> {{ $persona->Nombre }} {{ $persona->Apellido }}</td>
                            <td>{{ $persona->Rut }}</td>
                            <td class="text-capitalize">{{ $persona->centro_de_costo->empresa->Nombre}}</td>
                            <td class="text-capitalize">{{ $persona->centro_de_costo->Nombre }} </td>
                            @if ($persona->Enabled == 1)
                                <td data-search="Enabled">
                                    <button class="btn btn-sm btn-light-success estado-persona fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Persona">
                                        <span class="indicator-label">ACTIVO</span>
                                        <span class="indicator-progress">
                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                        </span>
                                    </button>
                                </td>
                            @else
                                <td data-search="Disabled">
                                    <button class="btn btn-light-warning fs-7 estado-persona text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Persona">
                                        <span class="indicator-label">Inactivo</span>
                                        <span class="indicator-progress">
                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                        </span>
                                    </button>
                                </td>
                            @endif
                            
                            <td class="text-center p-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $persona->Id }}">Ver</a>
                                    <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $persona->Id }}">Editar</a>
                                </div>
                            </td>
                            <td>
                                @if ( $persona->UsuarioId == null)
                                <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Dar Acceso Sistema">
                                    <a class="btn btn-sm btn-icon btn-light btn-active-light-primary h-25px w-25px dar-acceso" type="button" data-bs-toggle="modal" data-bs-target="#registrar-acceso-sistema" info="{{ $persona->Id }}">
                                        <i class="ki-duotone ki-plus fs-3 m-0"></i>
                                    </a>
                                </div>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach                                   
                    
                </tbody>
            </table>