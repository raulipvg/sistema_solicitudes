let tablaSolicitudesTerminadas = $('#tabla-solicitudes-terminadas').DataTable({
    "language": languageConfig,
    "dom":
        `<'d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-center'
        <''f>
        > 
        <'table-responsive'tr>
        <'row'
        <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>
        >`
    ,
    "pageLength": 20,
    "columnDefs": [
        { targets: 6, responsivePriority: 3,searchable: false},
        { targets: 0, responsivePriority: 1 },   
        { targets: 1, responsivePriority: 2 },                  
        { targets: 2, responsivePriority: 3 },
        { targets: 5, responsivePriority: 4 }
    ],
    "responsive": true,
    "initComplete": function() {
        //$('.filtro').children().addClass('btn-group-sm')
        $('.dataTables_filter').addClass('p-0')
    }
    //"scrollX": true
});

function BtnEstadoSolicitud(EstadoEtapaFlujoId){

    var html = `<div class="d-flex p-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="${ (EstadoEtapaFlujoId== 1)?`Solicitud Aprobada`: `Solicitud Rechazada` }">                                    
                    <i class="ki-duotone fs-2hx ${ (EstadoEtapaFlujoId== 1)?`text-success ki-check-circle`: `text-danger ki-cross-circle`}"> 
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>`;

    return html;
}
let cantTerminada = 0;
const cargarDataTerminada= function(){
    return {
        init: function(data){
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                            //console.log("Nombre:", data[persona].username);
                    
                    var col0 = `<div class="position-relative ps-6">
                                    <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-dark"></div>
                                    <span class="mb-1 text-gray-900 text-hover-primary fw-bold text-capitalize">#${data[key].Id} ${data[key].NombreCompleto}</span>
                                    <div class="fs-7 text-muted fw-bold">Creada ${formatearFecha(data[key].FechaCreado)}</div>
                                </div>`;
                    var col1 = `<div class="d-flex gap-2">
                                    <span class="text-gray-900 text-hover-primary fw-bold text-capitalize">${data[key].Movimiento}</span>
                                </div>
                                <div class="fs-7 text-muted fw-bold text-capitalize">${data[key].Atributos}</div>`;
                    
                    var col2 = `<div class="d-flex gap-2">
                                    <span class="badge badge-secondary min-h-30px mh-30px text-uppercase">${data[key].EstadoFlujo}</span>
                                </div>
                                <div class="ps-1 fs-7 fw-bold text-muted text-capitalize">${data[key].NombreFlujo}</div>`;
                    
                    var col3 = `<div class="fw-bold">${formatearFecha2(data[key].FechaDesde)} - ${formatearFecha2(data[key].FechaHasta)}</div>
                                <div class="fs-7 fw-bold text-muted">Rango de Fecha</div>`;

                    var col4 = `<div class="d-flex gap-2">
                                    <span class="text-gray-900 fw-bold text-capitalize">${data[key].CentroCosto}</span>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Centro de Costo asociado</div>`;

                    var col5= `<div class="d-flex gap-2">
                                    <span class="text-gray-900 fw-bold text-capitalize ">${data[key].UsuarioNombre}</span>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Solicitado por</div>`;

                    var col6 = `<div class="d-flex flex-row justify-content-end align-items-center" role="group" a="${data[key].Id}" b="${data[key].HistorialId}" c="${data[key].FlujoIdd}" >
                                        ${BtnEstadoSolicitud(data[key].EstadoEtapaFlujoId)}
                                        <div class="btn-group btn-group-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Historial">
                                            <button class="historial btn btn-light-primary p-1" data-bs-toggle="modal" data-bs-target="#historialSolicitud">
                                                <i class="ki-duotone ki-watch fs-2x p-0">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>                                            
                                        </div>
                                </div>`;
                        
                    var rowNode =  tablaSolicitudesTerminadas.row.add( {
                                        "0": col0,
                                        "1": col1,
                                        "2": col2,
                                        "3": col3,
                                        "4": col4,
                                        "5": col5,
                                        "6": col6,
                                        "7": data[key].Id
                                    } ).node();
                    $(rowNode).find('td:eq(0)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(1)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(2)').addClass('col-1 p-0 flujo').attr("abierto",0);
                    $(rowNode).find('td:eq(3)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(4)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(5)').addClass('col-2 min-w-100px p-1');
                    $(rowNode).find('td:eq(6)').addClass('col-1 text-end p-1');
                    $(rowNode).find('td:eq(7)').addClass('d-none');
                    
                    cantTerminada= cantTerminada+1;
                }
            }
            tablaSolicitudesTerminadas.order([7, 'desc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip();

            $("#terminadas").text(`TERMINADAS (${cantTerminada})`);
        }
    }

}();

KTUtil.onDOMContentLoaded((function() {
    $("#terminadas").on("click", function(e){
        if(tabulador == 1){
            //console.log("Tab Terminados")            
            tabulador =2 ;
            
            $.ajax({
                type: 'GET',
                url: VerTerminadas,
                data: {
                    _token: csrfToken 
                },
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() { 
                    bloquear();
                    KTApp.showPageLoading();
                    tablaSolicitudesTerminadas.clear();
                },
                success: function (data) {
                    if(data.success){
                        //data= data.data;             
                        //console.log(data);
                        cantTerminada = 0;
                        cargarDataTerminada.init(data.solicitudes);                        
                    }else{
                        Swal.fire({
                            text: "Error al Cargar Solicitudes Terminadas",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                },
                error: function () {;
                    Swal.fire({
                            text: "Error al Cargar Solicitudes Terminadas",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });    

        }    
    });
    

}));

