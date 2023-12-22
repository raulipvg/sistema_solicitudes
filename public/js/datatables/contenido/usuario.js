// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
function format(data) {
    // `d` is the original data object for the row
    /*
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

    */
   
        var html=
                '<div class="d-flex justify-content-center">'+
                    '<div class="card hover-elevate-up shadow-sm parent-hover" style=" width: 50%;">'+
                        '<table id="services_table" class="table table-row-dashed">'+
                            '<thead class="services-info">'+
                                '<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">'+
                                    '<th class="col-4 p-0 ps-3">Grupo</th>'+
                                    '<th class="col-4 p-0 ps-3">Fecha</th>'+
                                    '<th class="col-4 p-0 ps-2 text-center">ESTADO'+
                                        '<span class="dar-acceso" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Asignar Grupo">'+ 
                                            '<button type="button" data-info="1" class="registrar-acceso btn btn-sm btn-icon btn-color-dark btn-active-light btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#registrar-acceso">'+
                                                '<i class="ki-outline ki-plus-square fs-2"></i>'+
                                            '</button>'+
                                        '</span>'+
                                    '</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody class="fw-bold text-gray-600">'+
                                '<tr>'+
                                    '<td class="text-gray-700 text-capitalize">Grupo 1</td>'+
                                    '<td>01-01-2024</td>'+
                                    '<td class="text-center p-0">'+
                                        '<div class="btn-group btn-group-sm" role="group">'+
                                            '<button class="btn btn-sm btn-light-success editar-acceso fs-7 text-uppercase estado justify-content-center p-1 w-100px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="1" title="Desvincular del Grupo">'+
                                                '<span class="indicator-label">HABILITADO</span>'+
                                                '<span class="indicator-progress">'+
                                                    '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                                                '</span>'+
                                            '</button>'+
                                        '</div>'+
                                    '</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td class="text-gray-700 text-capitalize">Grupo 2</td>'+
                                    '<td>01-01-2024</td>'+
                                    '<td class="text-center p-0">'+
                                        '<div class="btn-group btn-group-sm" role="group">'+
                                            '<button class="btn btn-sm btn-light-success editar-acceso fs-7 text-uppercase estado justify-content-center p-1 w-100px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" info="1" title="Desvincular del Grupo">'+
                                                '<span class="indicator-label">HABILITADO</span>'+
                                                '<span class="indicator-progress">'+
                                                    '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                                                '</span>'+
                                            '</button>'+
                                        '</div>'+
                                    '</td>'+
                                '</tr>'+
                            '</tbody>'+
                        '</table>'+
                    '</div>'+
                '</div>';

    return html;
    
}
 
let miTabla = $('#tabla-usuario').DataTable({
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": '',
                "searchPlaceholder": 'BUSCAR',
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %d fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "$d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "AM",
                        "PM"
                    ],
                    "months": {
                        "0": "Enero",
                        "1": "Febrero",
                        "10": "Noviembre",
                        "11": "Diciembre",
                        "2": "Marzo",
                        "3": "Abril",
                        "4": "Mayo",
                        "5": "Junio",
                        "6": "Julio",
                        "7": "Agosto",
                        "8": "Septiembre",
                        "9": "Octubre"
                    },
                    "weekdays": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros"
    
    
            },
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

