// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
let miTabla = $('#tabla-persona').DataTable({
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
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'excel',
                    className: '',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
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
                        doc.content[1].table.widths = ['20%','20%','20%','20%','20%'];
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    className: '',
                    exportOptions: {
                        columns: [0, 1, 2, 3,4]
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
                            //console.log("Nombre:", data[persona].username);
                    var className = (credenciales.puedeEliminar)? 'estado-persona': 'disabled'
                    var btnEstado = (data[key].Enabled == 1)? botonEstado('Deshabilitar Persona','btn-light-success w-70px '+className,'ACTIVO')
                                                            :botonEstado('Habilitar Persona','btn-light-warning w-70px '+className,'INACTIVO');
                  
                    var rowNode =  miTabla.row.add( {
                                        "0": data[key].Id,
                                        "1": data[key].NombreCompleto,
                                        "2": data[key].Rut,
                                        "3": data[key].NombreEmpresa,
                                        "4": data[key].NombreCC,
                                        "5": btnEstado,
                                        "6": botonAcciones('registrar',data[key].Id),
                                        "7": (data[key].UsuarioId == null && credenciales2.puedeRegistrar)?botonModal('#registrar-acceso-sistema','Dar Acceso al Sistema',data[key].Id):null
                                    } ).node();
                    $(rowNode).find('td:eq(1)').addClass('text-capitalize ftext-gray-800 fw-bolder');
                    $(rowNode).find('td:eq(3)').addClass('text-capitalize fw-bold text-gray-600');
                    $(rowNode).find('td:eq(4)').addClass('text-capitalize');
                    $(rowNode).find('td:eq(6)').addClass('text-center p-0');          
                }
            }
            miTabla.order([1, 'asc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip(); 
        }
    }

}();

KTUtil.onDOMContentLoaded((function() {
    (credenciales.puedeVer)?cargarData.init(data):null;
}));