
let miTabla = $('#tabla-estado').DataTable({
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
                    var className = (credenciales.puedeEliminar)? 'estado-estado': 'disabled';

                    var btnEstado = (data[key].Enabled == 1)? botonEstado('Deshabilitar Estado','btn-light-success w-115px '+className,'HABILITADO')
                                                            :botonEstado('Habilitar Estado','btn-light-warning w-115px '+className,'DESHABILITADO');
                    
                    var rowNode =  miTabla.row.add( {
                                        "0": data[key].Id,
                                        "1": data[key].Nombre,
                                        "2": btnEstado,
                                        "3": (credenciales.puedeEditar)?botonAccion('registrar',data[key].Id):null
                                    } ).node();
                    $(rowNode).find('td:eq(1)').addClass('text-capitalize ftext-gray-800 fw-bolder');
                    (credenciales.puedeEditar)?$(rowNode).find('td:eq(3)').addClass('text-center p-0'):null;          
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

