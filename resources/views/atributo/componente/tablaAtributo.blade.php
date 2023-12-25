<table id="tabla-atributo" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Valor de Referencia</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($atributos as $atributo)
                    <tr class="center-2">
                        <td>{{ $atributo->Id }}</td>
                        <td class="text-capitalize">{{ $atributo->Nombre }}</td>
                        <td>$ {{ number_format($atributo->ValorReferencia, 0, '', '.') }}</td>
                        @if($atributo->Enabled == 1)
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-atributo fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Atributo">
                                <span class="indicator-label">ACTIVO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        @else
                        <td data-search="Disabled">
                            <button class="btn btn-light-warning fs-7 estado-atributo text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Atributo">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        @endif
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $atributo->Id }}">Editar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>