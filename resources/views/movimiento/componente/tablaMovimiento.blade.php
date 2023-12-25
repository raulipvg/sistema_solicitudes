<table id="tabla-movimiento" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
    <thead>
        <tr class="fw-bolder text-uppercase">
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Grupo Autorizado</th>
            <th scope="col">Flujo</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acción</th>
        </tr>
    </thead>
    <tbody>
        <tr class="center-2">
            <td>1</td>
            <td class="text-capitalize">Pase EPI</td>
            <td>Grupo 1</td>
            <td>Flujo 1</td>
            <td data-search="Enabled">
                <button class="btn btn-sm btn-light-success estado-movimiento fs-7 text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Movimiento">
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
        </tr>
        <tr class="center-2">
            <td>2</td>
            <td class="text-capitalize">Pase Vuelo</td>
            <td>Grupo 2</td>
            <td>Flujo 2</td>
            <td data-search="Disabled">
                <button class="btn btn-light-warning fs-7 estado-movimiento text-uppercase estado justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Movimiento">
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
        </tr>
    </tbody>
</table>