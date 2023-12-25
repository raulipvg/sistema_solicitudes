            <table id="tabla-usuario" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($usuarios as $usuario )
                    <tr class="center-2">
                        <td>{{$usuario->Id}}</td>
                        <td class="text-capitalize">{{ $usuario->persona->Nombre}} {{ $usuario->persona->Apellido}}</td>
                        <td>{{ $usuario->Username}}</td>
                        <td>{{ $usuario->Email }}</td>
                        @if ($usuario->Enabled == 1)
                            <td data-search="Enabled">
                                <button class="btn btn-sm btn-light-success estado-usuario fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Usuario">
                                    <span class="indicator-label">ACTIVO</span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                </button>
                            </td>
                        @else
                        <td data-search="Disabled">
                            <button class="btn btn-light-warning fs-7 estado-usuario text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Usuario">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        @endif
                        
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{$usuario->Id}}">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{$usuario->Id}}">Editar</a>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Grupos Asociados">
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