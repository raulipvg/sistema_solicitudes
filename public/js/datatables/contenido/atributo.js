// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
function format(data) {
    // `d` is the original data object for the row
    
    var html=
    '<div class="d-flex justify-content-center">'+
        '<div class="card hover-elevate-up shadow-sm parent-hover" style=" width: 50%;">'+
        '<table id="services_table" class="table table-row-dashed">'+
            '<thead class="services-info">'+
               '<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">'+
                    '<th class="p-0 ps-3">Comundidad</th>'+
                    '<th class="p-0 ps-3">Fecha</th>'+
                    '<th class="text-center col-3 p-0 ps-2">ESTADO'+
                        '<span class="dar-acceso" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Acceso">'+ 
                        '<button type="button" data-info="'+data[0].UsuarioId+'" class="registrar-acceso btn btn-sm btn-icon btn-color-dark btn-active-light btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#registrar-acceso">'+
                            '<i class="ki-outline ki-plus-square fs-2"></i>'+
                        '</button>'+
                        '</span>'+
                    '</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody class="fw-bold text-gray-600">';



    for(const elemento of data) {
       // console.log(elemento.Enabled);
        // Crear un objeto Date a partir de la cadena original
        var fecha = new Date(elemento.FechaAcceso);

        // Obtener el día, mes y año
        var dia = fecha.getDate();
        var mes = fecha.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
        var anio = fecha.getFullYear();

        // Formatear la fecha como "DD-MM-YYYY"
        var fechaFormateada = dia + "-" + (mes < 10 ? "0" : "") + mes + "-" + anio;

       html = html +
                '<tr>'+
                    '<td class="text-gray-700 text-capitalize">'+elemento.Nombre+'</td>'+
                    '<td>'+fechaFormateada+'</td>';

        if(elemento.Enabled == 1){
            html = html +
                    '<td class="text-center p-0">'+
                        '<div class="btn-group btn-group-sm" role="group">'+
                            '<button class="btn btn-sm btn-light-success editar-acceso fs-7 text-uppercase estado justify-content-center p-1 w-65px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="'+elemento.Id+'" title="Deshabilitar Acceso">'+
                            '<span class="indicator-label">Activo</span>'+
                            '<span class="indicator-progress">'+
                                '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                            '</span>'+
                            '</button>';
                        '</div>'+
                    '</td>'+
                '</tr>'

        }else{
            html = html +
                    '<td class="text-center p-0">'+
                        '<div class="btn-group btn-group-sm" role="group">'+
                            '<button class="btn btn-sm btn-light-warning editar-acceso fs-7 text-uppercase estado justify-content-center p-1 w-65px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="'+elemento.Id+'" title="Habilitar Acceso">'+
                            '<span class="indicator-label">Inactivo</span>'+
                            '<span class="indicator-progress">'+
                                '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                            '</span>'+
                            '</button>';
                         '</div>'+
                    '</td>'+
                '</tr>'

        }
    }

       html=  html+        
                    '</tbody>'+
                '</table>'+
                '</div>'+
                '</div>';

                
    return html;
    
}
 
let miTabla = $('#tabla-usuario').DataTable({
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
      
$(document).ready(function() {



});
