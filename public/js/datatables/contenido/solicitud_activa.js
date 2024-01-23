let tabulador =1;
let tablaSolicitudes = $('#tabla-solicitudes').DataTable({
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
    "pageLength": 30,
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
let cantActiva = 0;

const cargarDataActiva= function(){
    return {
        init: function(data){
            bloquear();
            KTApp.showPageLoading();
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                            //console.log("Nombre:", data[persona].username);
                    var claseEstado="";
                    if(data[key].EstadoSolicitudId == 1){
                        claseEstado="bg-success";
                    }else if(data[key].EstadoSolicitudId == 2){
                        claseEstado="bg-warning";
                    }
                    var col0 = `<div class="position-relative ps-6">
                                    <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 ${claseEstado}"></div>
                                    <a href="#" class="mb-1 text-gray-900 text-hover-primary fw-bold text-capitalize">#${data[key].Id} ${data[key].NombreCompleto}</a>
                                    <div class="fs-7 text-muted fw-bold">Creada ${formatearFecha(data[key].FechaCreado)}</div>
                                </div>`;
                    var col1 = `<div class="d-flex gap-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fw-bold text-capitalize">${data[key].Movimiento}</a>
                                </div>
                                <div class="fs-7 text-muted fw-bold text-capitalize">${data[key].Atributos}</div>`;
                    
                    var col2 = `<div class="d-flex gap-2">
                                    <span class="badge badge-secondary min-h-30px mh-30px text-uppercase">${data[key].EstadoFlujo}</span>
                                </div>
                                <div class="ps-1 fs-7 fw-bold text-muted text-capitalize">${data[key].NombreFlujo}</div>`;
                    
                    var col3 = `<div class="fw-bold">${formatearFecha2(data[key].FechaDesde)} - ${formatearFecha2(data[key].FechaHasta)}</div>
                                <div class="fs-7 fw-bold text-muted">Rango de Fecha</div>`;

                    var col4 = `<div class="d-flex gap-2">
                                    <a href="#" class="text-gray-900 fw-bold text-capitalize">${data[key].CentroCosto}</a>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Centro de Costo asociado</div>`;

                    var col5= `<div class="d-flex gap-2">
                                    <a href="#" class="text-gray-900 fw-bold">${data[key].UsuarioNombre}</a>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Solicitado por</div>`;

                    var col6 = `<div class="btn-group btn-group-sm" role="group" a="${data[key].Id}" b="${data[key].HistorialId}" c="${data[key].FlujoIdd}" >
                                    <button class="${credenciales.aprobador?
                                        `aceptar`:`disabled`
                                    } btn btn-light-success p-1"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Aprobar">
                                        <i class="ki-duotone ki-check-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button class="${credenciales.aprobador?
                                        `rechazar`:`disabled`
                                    } btn btn-light-danger p-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Rechazar">
                                        <i class="ki-duotone ki-cross-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <div class="btn-group btn-group-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Historial">
                                        <button class="historial btn btn-bg-light btn-active-color-dark p-1" data-bs-toggle="modal" data-bs-target="#historialSolicitud" style="min-width: 43.55px;">
                                            <i class="ki-duotone ki-watch fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </div>
                                </div>`;
                        
                    var rowNode =  tablaSolicitudes.row.add( {
                                        "0": col0,
                                        "1": col1,
                                        "2": col2,
                                        "3": col3,
                                        "4": col4,
                                        "5": col5,
                                        "6": col6,
                                        "7": data[key].Id
                                    } ).node();
                    $(rowNode).find('td:eq(0)').addClass('min-w-175px p-1');
                    $(rowNode).find('td:eq(1)').addClass('p-1');
                    $(rowNode).find('td:eq(2)').addClass('p-0 flujo').attr("abierto",0);
                    $(rowNode).find('td:eq(3)').addClass('min-w-150px p-1');
                    $(rowNode).find('td:eq(4)').addClass('min-w-125px p-1');
                    $(rowNode).find('td:eq(5)').addClass('min-w-125px p-1');
                    $(rowNode).find('td:eq(6)').addClass('text-end p-1');
                    $(rowNode).find('td:eq(7)').addClass('d-none');
                    
                    cantActiva= cantActiva+1;
                }
            }
            tablaSolicitudes.order([7, 'desc']).draw();
            $('[data-bs-toggle="tooltip"]').tooltip();
            $("#activas").text(`ACTIVAS (${cantActiva})`);
        }
    }

}();

KTUtil.onDOMContentLoaded((function() {
    bloquear();
    KTApp.showPageLoading();
    console.log(solicitudeActivas)
    cargarDataActiva.init(solicitudeActivas);
    KTApp.hidePageLoading();
    loadingEl.remove();
    
    $("#activas").on("click", function(e){
        if(tabulador == 2){
            //console.log("Tab Activadas")
            tabulador =1;
            
            $.ajax({
                type: 'GET',
                url: VerActivas,
                data: {
                    _token: csrfToken 
                },
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() { 
                    bloquear();
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    if(data.success){
                        //console.log(data);
                        cantActiva = 0;
                        tablaSolicitudes.clear();
                        cargarDataActiva.init(data.solicitudes);
                    }else{
                        Swal.fire({
                            text: "Error al Cargar Solicitudes Activas",
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
                            text: "Error al Cargar Solicitudes Activas",
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