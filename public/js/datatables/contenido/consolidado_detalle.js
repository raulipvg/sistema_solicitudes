var groupColumn = 0;
let TotalCC = [];
var optionsExport= 
    {
        columns: [0, 1, 2,3],
        customizeData: function (data) {
            // Modifica la data de la columna 0 antes de imprimir
            for (var i = 0; i < data.body.length; i++) {
                var columna0 = data.body[i][0];
                var columna0Separada = columna0.split(',');
                data.body[i][0] = columna0Separada[0]; // Solo toma el primer elemento de la columna 0
            }
        }
    };

//CREACION SUBTABLLA
function format(data) {   
    var html=`
            <div class="d-flex justify-content-center">
                <div class="card shadow-sm" style=" width: 50%;">
                <table id="services_table" class="table table-row-dashed">
                    <thead class="services-info">
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="p-0 ps-3">Solicitud</th>
                            <th class="p-0 ps-3">Movimiento</th>
                            <th class="p-0 ps-3">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
            `;

    for(const elemento of data) {
        html = html + AgregarTR(elemento);   
    }

    html=  html+'</tbody></table></div></div>';
    return html;   
}

//TR A SUB TABLA
function AgregarTR(elemento){

    var html =`
                <tr>
                    <td class="py-1">#${elemento.SolicitudId}</td>
                    <td class="py-1 text-capitalize">${elemento.Movimiento}</td>
                    <td class="py-1 text-gray-700 text-capitalize">${ (elemento.Detalle ?? '-')}</td>                                                                    
                </tr>
            `;
    return html;
}

var miTablaDetalle = $("#tablaConsolidado").DataTable({
    "language": languageConfig,
    "dom":
        `
        <'d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-center'
            <'#btnExport' B >
            <'#filtro.d-flex flex-row align-items-center'
                <'#tipo-cambio.flex-row'> f
            >
        >
        <'table-responsive'tr>
        <'d-flex flex-md-row flex-column justify-content-md-between'
            <'d-flex align-items-center justify-content-center'li>
            <'d-flex align-items-center justify-content-center'p>
        >
        `
    ,    
    "buttons": [
        {
            extend: 'copy',
            className: '',
            exportOptions: optionsExport
        },
        {
            extend: 'excel',
            className: '',
            exportOptions: optionsExport
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
            exportOptions: optionsExport
        },
        {
            extend: 'print',
            className: '',
            exportOptions: optionsExport
        }
    ],
	"columnDefs": [
        {"targets": groupColumn, "visible": false},
        { 
            targets: -1,
            responsivePriority: 1,
            className: 'dt-control',
            orderable: false,
            searchable: false,
            width: '30.5px'
            
            
        }
    ],
	"order": [
		[groupColumn, "asc"]
	],
    "responsive": true,
    "initComplete": function() {
        $('#btnExport').children().addClass('btn-group-sm')
        $('#tablaConsolidado_length').addClass('p-0');
        $('#tablaConsolidado_info').addClass('p-0');
        $('#tablaConsolidado_paginate').addClass('p-0');
        var icon = `<i class="ki-duotone ki-magnifier fs-1 position-absolute ms-4 mt-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>`;
        $('#tablaConsolidado_filter label').prepend(icon);
        $('#tablaConsolidado_filter input').addClass('ps-9');  

    },
    "pageLength": 25,
	"displayLength": 25,
	"drawCallback": function(settings) {
		var api = this.api();
		var rows = api.rows({
			page: "current"
		}).nodes();
		var last = null;

		api.column(groupColumn, {
			page: "current"
		}).data().each(function(group, i) {
            grupo = group.split(',')
			if (last !== grupo[0]) {

                var totalEncontrado = TotalCC.find(function(elemento) {
                    return elemento.CcId === parseInt(grupo[1]);
                });
                //console.log(a)
				$(rows).eq(i).before(
					`<tr id="cc${grupo[1]}" class="group text-uppercase text-gray-800 fw-bolder bg-secondary puntero">
                        <td class="py-0 px-2 ordenar" colspan="2">
                            ${grupo[0]}
                        </td>
                        <td class="py-0 ps-2 pe-3 ordenar" colspan="1">
                            <span class="float-start">TOTAL CC:</span> 
                            <span class="float-end">CLP$ ${totalEncontrado.Total.toLocaleString()}</span> 
                        </td>
                        <td class="py-0 text-center" colspan="1">
                            <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Solicitudes Asociadas">
                                <button type="button" class="btn-plus btn ver-solicitudes btn-icon btn-light-success" data-bs-toggle="modal" data-bs-target="#solicitudes" data-a="${grupo[1]}" >
                                    <i class="ki-duotone ki-double-check-circle fs-2x">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </button>
                            </div>
                        </td>
                    </tr>`
				);
				last = grupo[0];
			}
		});
	}


});

//CARGAR DATA TABLA
const cargarDataDetalle= function(){
    return {
        init: function(data,tipoCambio){
            //var CostoTotalCC = 0;            
            var ccIdAnterior=0;
            var ccTotal=0;
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                            //console.log("Nombre:", data[persona].username);
                    var costos = JSON.parse(data[key].CostoMoneda);

                    var costoTotalCLP = 0;
                    costos.forEach( (costo) => {
                        if(costo.TipoMonedaId == 1){
                            costoTotalCLP += costo.CostoReal;
                        }else{
                            var cambioCLP = buscarPorTipoMonedaId(tipoCambio,costo.TipoMonedaId)
                            valorCLP= cambioCLP.ToCLP * costo.CostoReal;
                            costoTotalCLP += valorCLP;
                            //console.log(a)
                        }
                    });
                    if(ccIdAnterior == data[key].CcId || key ==0){
                        ccTotal+= costoTotalCLP;
                    }else{
                        var obj = {
                            CcId: ccIdAnterior,
                            Total: ccTotal
                        }
                        TotalCC.push(obj);
                        ccTotal=costoTotalCLP;
                    }
                    
                    //CostoTotalCC += costoTotalCLP;
                    

                    //console.log(costos);
                    //console.log('TOTAL CLP: '+ costoTotalCLP)
                    //console.log(tipoCambio)
                    var html= `<span class="float-start ms-11 ps-11">CLP$</span>
                                <span class="float-end">${costoTotalCLP.toLocaleString()}</span>`;

                    var rowNode =  miTablaDetalle.row.add( {
                                        "0": data[key].EmpresaNombre+' - '+data[key].CcNombre+','+data[key].CcId,
                                        "1": data[key].AtributoNombre,
                                        "2": data[key].Cantidad,
                                        "3": html,
                                        "4": botonVerDetalle('Detalles Asociados',data[key].CcId,data[key].AtributoId,data[key].ConsolidadoId)
                                    } ).node();
                    $(rowNode).find('td:eq(0)').addClass('py-1');
                    $(rowNode).find('td:eq(1)').addClass('py-1');
                    $(rowNode).find('td:eq(2)').addClass('py-1');
                    $(rowNode).find('td:eq(3)').addClass('py-1 text-center');
                    
                    ccIdAnterior = data[key].CcId        
                }
            }            
            var obj = {
                CcId: ccIdAnterior,
                Total: ccTotal
            }
            TotalCC.push(obj);
            total1= sumCCTotals(TotalCC);
            //console.log('CLP$ '+total1);
            $("#totales").text('CLP$ '+total1.toLocaleString());
            miTablaDetalle.order([0, 'asc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    }

}();

function sumCCTotals(ccObjects) {
    return ccObjects.reduce((total, obj) => total + obj.Total, 0);
  }
// Función para buscar por TipoMonedaId
function buscarPorTipoMonedaId(tipoCambio, tipoMonedaId) {
    return tipoCambio.find(function(elemento) {
        return elemento.TipoMonedaId === tipoMonedaId;
    });
}
// Order by the grouping
$("#tablaConsolidado tbody").on("click", "tr.group td.ordenar", function() {
	var currentOrder = miTablaDetalle.order()[0];
	if (currentOrder[0] === groupColumn && currentOrder[1] === "asc") {
		miTablaDetalle.order([groupColumn, "desc"]).draw();
	} else {
		miTablaDetalle.order([groupColumn, "asc"]).draw();
	}
});