// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
function format(data,usuario) {   
    var html=`
            <div class="d-flex justify-content-center">
                <div class="card shadow-sm " style=" width: 50%;">
                <table id="services_table" class="table table-row-dashed">
                    <thead class="services-info">
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="p-0 ps-3">Centro de Costo</th>
                            <th class="p-0 ps-3">Fecha</th>
                            <th class="text-center col-3 p-0 ps-2">ESTADO${
                                credenciales['CC'].puedeRegistrar
                                    ? `<span class="dar-acceso" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar un Centro de Costo">
                                        <button type="button" data-info="${usuario}" class="registrar-cc btn btn-sm btn-icon btn-color-dark btn-active-light btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#registrar-cc">
                                            <i class="ki-outline ki-plus-square fs-2"></i>
                                        </button>
                                    </span>`
                                    : ''
                            }</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">`;

    for(const elemento of data) {
        html = html + AgregarTR(elemento.Nombre, elemento.Id, elemento.created_at, "Eliminar CC");   
    }

    html=  html+'</tbody></table></div></div>';
    return html;   
}

function AgregarTR(nombre, id, fecha, titulo){

    var date = new Date(fecha);
    // Obtener el día, mes y año
    var dia = date.getDate();
    var mes = date.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
    var anio = date.getFullYear();
    // Formatear la fecha como "DD-MM-YYYY"
    var fechaFormateada = dia + "-" + (mes < 10 ? "0" : "") + mes + "-" + anio;

    var className = (credenciales['CC'].puedeEliminar)? 'editar-acceso': 'disabled';
    var html =`<tr>
                    <td class="text-gray-700 text-capitalize">${nombre}</td>
                    <td>${fechaFormateada}</td>
                    <td class="text-center p-0">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-sm btn-light-success ${className} fs-7 text-uppercase estado justify-content-center p-1 w-100px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="${id}" title="${titulo}">
                            <span class="indicator-label">HABILITADO</span>
                            <span class="indicator-progress">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                            </span>
                            </button>
                        </div>
                    </td>
                </tr>`;
    return html;
}
 
let miTabla = $('#tabla-empresa').DataTable({
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

const cargarData= function(){
            return {
                init: function(data){
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {                            
                            var className = (credenciales['Empresa'].puedeEliminar)? 'estado-empresa': 'disabled';

                            var btnEstado = (data[key].Enabled == 1)? botonEstado('Deshabilitar Empresa','btn-light-success w-115px '+className,'HABILITADO')
                                                                     :botonEstado('Habilitar Empresa','btn-light-warning w-115px '+className,'DESHABILITADO');
                            
                            var rowNode =  miTabla.row.add( {
                                                "0": data[key].Id,
                                                "1": data[key].Nombre,
                                                "2": data[key].Rut,
                                                "3": data[key].Email,
                                                "4": btnEstado,
                                                "5": botonAcciones('registrar',data[key].Id,'Empresa'),
                                                "6": (credenciales['CC'].puedeVer)?botonVerDetalle('Centros de Costos Asociados'):null
                                            } ).node();
                            $(rowNode).find('td:eq(1)').addClass('text-capitalize ftext-gray-800 fw-bolder');
                            $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');
                            $(rowNode).find('td:eq(5)').addClass('text-center p-0');          
                        }
                    }
                    miTabla.order([1, 'asc']).draw();
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            }
        
        }();

KTUtil.onDOMContentLoaded((function() {
    
    (credenciales['Empresa'].puedeVer)?cargarData.init(data):null;
})); 