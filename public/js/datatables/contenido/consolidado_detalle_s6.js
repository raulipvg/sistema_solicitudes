//CREACION SUBTABLLA
function format(data) {   
    var html=`
            <div class="d-flex justify-content-center">
                <div class="card shadow-sm" style=" width: 50%;">
                <table id="services_table" class="table table-row-dashed">
                    <thead class="services-info">
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="p-0 ps-3">Solicitud</th>
                            <th class="p-0 ps-3">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
            `;

    for(const elemento of data) {
        html = html + AgregarTR(elemento.Nombre,elemento.Id);   
    }

    html=  html+'</tbody></table></div></div>';
    return html;   
}

//TR A SUB TABLA
function AgregarTR(Nombre, Id){

    var html =`
                <tr>
                    <td>#${Id}</td>
                    <td class="text-gray-700 text-capitalize">${Nombre}</td>                                  
                </tr>
            `;
    return html;
}

let miTablaDetalle = $('#tabla-detalle-consolidado').DataTable({
    "language": languageConfig,
    "dom":
        "<'d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-center'" +
        "<'filtro'B>" +
        "<''f>" +
        ">" +
        "<'table-responsive'tr>"+
        "<'d-flex flex-row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">"
    , 
    "buttons": [
        {
            extend: 'copy',
            className: '',
            exportOptions: {
                columns: [0, 1, 2]
            }
        },
        {
            extend: 'excel',
            className: '',
            exportOptions: {
                columns: [0, 1, 2]
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
                doc.content[1].table.widths = ['25%','25%','25%'];
            },
            exportOptions: {
                columns: [0, 1, 2]
            }
        },
        {
            extend: 'print',
            className: '',
            exportOptions: {
                columns: [0, 1, 2]
            }
        }
    ],
    "pageLength": 20,
    "columnDefs": [
        { "targets": 1, "responsivePriority": 1 },
        { "targets": 0, "responsivePriority": 2 },
        { 
            targets: -1,
            responsivePriority: 1,
            className: 'dt-control',
            orderable: false,
            searchable: false,
            
        }
    ],
    "responsive": true,
    "initComplete": function() {
        $('.filtro').children().addClass('btn-group-sm')
        $('.dataTables_filter').addClass('p-1')
    }
    //"scrollX": true
});

//CARGAR DATA TABLA
const cargarData= function(){
    return {
        init: function(data){
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                            //console.log("Nombre:", data[persona].username);

                    
                    
                    var html= `<span class="text-start">CLP$</span>
                                <span class="text-end">${data[key].Total}</span>`;

                    var rowNode =  miTablaDetalle.row.add( {
                                        "0": data[key].Nombre,
                                        "1": data[key].Cantidad,
                                        "2": html,
                                        "3": botonVerDetalle('Detalles Asociados')
                                    } ).node();
                    $(rowNode).find('td:eq(0)').addClass('py-0 px-2 text-capitalize text-gray-800 fw-bolder');
                    $(rowNode).find('td:eq(1)').addClass('py-0 px-2');
                    $(rowNode).find('td:eq(2)').addClass('py-0 fw-bold text-gray-600');
                    //$(rowNode).find('td:eq(3)').addClass('text-center p-1');          
                }
            }
            miTablaDetalle.order([0, 'asc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    }

}();

KTUtil.onDOMContentLoaded((function() {
    
}));