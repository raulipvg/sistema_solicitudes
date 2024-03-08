//CREACION SUBTABLLA
function format(data,usuario) {   
    var html=`
            <div class="d-flex justify-content-center">
                <div class="card shadow-sm" style=" width: 50%;">
                <table id="services_table" class="table table-row-dashed">
                    <thead class="services-info">
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="p-0 ps-3">Flujo</th>
                            <th class="p-0 ps-3">Fecha</th>
                            <th class="text-center col-3 p-0 ps-2">ESTADO
                            </th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
            `;

    for(const elemento of data) {
        html = html + AgregarTR(elemento.Nombre, elemento.Id, elemento.created_at, "Deshabilitar Flujo");   
    }

    html=  html+'</tbody></table></div></div>';
    return html;   
}

//TR A SUB TABLA
function AgregarTR(nombre, id, fecha, titulo){

    var fechaFormateada = formatearFecha(fecha);
    var className = (credenciales['Flujo'].puedeEliminar)? 'estado-flujo': 'disabled';
    var html =`
                <tr>
                    <td class="text-gray-700 text-capitalize">${nombre}</td>
                    <td>${fechaFormateada}</td>
                    <td class="text-center p-0">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-sm btn-light-success ${className} fs-7 text-uppercase estado justify-content-center p-1 w-100px" 
                                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="${id}" title="${titulo}">
                                <span class="indicator-label">HABILITADO</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
    return html;
}
let miTablaArea;
if(credenciales['Area'].puedeVer) {
    miTablaArea = $('#tabla-area').DataTable({
        "language": languageConfig,
        "dom":
            "<'d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-center'" +
            "<'filtro'B>" +
            "<''f>" +
            ">" +
            "<'table-responsive'tr>"+
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
        , 
        "buttons": [
            {
                extend: 'copy',
                className: '',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'excel',
                className: '',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdf',
                className: '',
                pageSize: 'LETTER',
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10; //2, 3, 4,etc
                    doc.styles.title.fontSize = 14;
                    doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                    doc.content[1].table.widths = ['25%','25%','25%','25%'];
                },
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                className: '',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        "pageLength": 10,
        "columnDefs": [
            { "targets": 1, "responsivePriority": 1 },
            { "targets": 0, "responsivePriority": 3,"searchable": false },
            { 
                targets: -1,
                responsivePriority: 1,
                className: 'dt-control',
                orderable: false,
                searchable: false,
                
            },      
            { "targets": 2, "responsivePriority": 4 },
            { "targets": 3, "responsivePriority": 5 }
        ],
        "responsive": true,
        "initComplete": function() {
            $('.filtro').children().addClass('btn-group-sm')
            $('.dataTables_filter').addClass('p-0')
        }
        //"scrollX": true
    });
}
//CARGAR DATA TABLA
const cargarDataArea= function(){
    return {
        init: function(data){
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                            //console.log("Nombre:", data[persona].username);

                    var className = (credenciales['Area'].puedeEliminar)? 'estado-area': 'disabled';

                    var btnEstado = (data[key].Enabled == 1)? botonEstado('Deshabilitar Area','btn-light-success w-115px '+className,'HABILITADO')
                                                             :botonEstado('Habilitar Area','btn-light-warning w-115px '+className,'DESHABILITADO');
                    
                    var rowNode =  miTablaArea.row.add( {
                                        "0": data[key].Id,
                                        "1": data[key].Nombre,
                                        "2": data[key].Descripcion,
                                        "3": formatearFecha(data[key].created_at),
                                        "4": btnEstado,
                                        "5": botonAcciones('registrar',data[key].Id,'Area'),
                                        "6": (credenciales['Area'].puedeVer)?botonVerDetalle('Flujos Asociados'):null
                                    } ).node();
                    $(rowNode).find('td:eq(1)').addClass('text-capitalize ftext-gray-800 fw-bolder');
                    $(rowNode).find('td:eq(2)').addClass('text-capitalize');
                    $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');
                    $(rowNode).find('td:eq(5)').addClass('text-center p-0');          
                }
            }
            miTablaArea.order([1, 'asc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    }

}();
