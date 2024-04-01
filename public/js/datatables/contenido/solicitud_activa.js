let tabulador =1;
let tablaSolicitudes = $('#tabla-solicitudes').DataTable({
    "language": languageConfig,
    "dom":
        `
        <'d-flex flex-row justify-content-between align-items-center'
            <'#filtro'f>
            <'#acciones.form-check form-check-sm form-check-custom form-check-solid'>	
        > 
        <'table-responsive'tr>
        <'d-flex flex-md-row flex-column justify-content-md-between'
            <'d-flex align-items-center justify-content-center'li>
            <'d-flex align-items-center justify-content-center'p>
        >
        `
    ,
    "pageLength": 25,
    "displayLength": 25,
    "columnDefs": [        
        { targets: 0, responsivePriority: 1 },   
        { targets: 1, responsivePriority: 2 },                  
        { targets: 2, responsivePriority: 3 },
        { targets: 5, responsivePriority: 4 },
        { targets: 6, responsivePriority: 3, orderable:false, searchable: false},
        { targets: 8, orderable:false }
    ],
    "responsive": true,
    "initComplete": function() {
        $('#tabla-solicitudes_filter').addClass('py-1');
        $('#tabla-solicitudes_length').addClass('p-0');
        $('#tabla-solicitudes_info').addClass('p-0');
        $('#tabla-solicitudes_paginate').addClass('p-0');
        var icon = `<i class="ki-duotone ki-magnifier fs-1 position-absolute m-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>`;
        $('#tabla-solicitudes_filter label').prepend(icon);
        $('#tabla-solicitudes_filter input').addClass('ps-9');
     
        var acciones = `${credenciales.aprobador? 
                                `<div class="btn-group btn-group-sm me-md-15 me-2 ms-2" role="group">
                                    <button id="aceptar-seleccion" class="btn-light-success btn p-1"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Aprobar Seleccion">
                                        <i class="ki-duotone ki-check-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button id="rechazar-seleccion" class="btn-light-danger btn btn-light-danger p-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Rechazar Seleccion">
                                        <i class="ki-duotone ki-cross-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                                <div class="pe-1">
                                    <input id="select-all" class="form-check-input" type="checkbox" value="1"/>
                                </div>`: `` }`;

        $('#acciones').html(acciones);
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
                    
                    var col3 = `<div class="fw-bold">${formatearFecha2(data[key].FechaUpdated)}</div>
                                <div class="fs-7 fw-bold text-muted">Actualización</div>`;

                    var col4 = `<div class="d-flex gap-2">
                                    <span class="text-gray-900 fw-bold text-capitalize">${data[key].CentroCosto}</span>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Centro de Costo asociado</div>`;

                    var col5= `<div class="d-flex gap-2">
                                    <span class="text-gray-900 text-capitalize fw-bold">${data[key].UsuarioNombre}</span>
                                </div>
                                <div class="fs-7 fw-bold text-muted">Solicitado por</div>`;

                    var estaEnElArray = credenciales.grupos.includes(data[key].GrupoAprobadorId);
                    //console.log(estaEnElArray)

                    var col6 = `<div class="btn-group btn-group-sm" role="group" a="${data[key].Id}" b="${data[key].HistorialId}" c="${data[key].FlujoIdd}" >
                                    <button class="${credenciales.aprobador && estaEnElArray?
                                        `aceptar btn-light-success`:`btn-secondary disabled`
                                    } btn p-1"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Aprobar">
                                        <i class="ki-duotone ki-check-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button class="${credenciales.aprobador && estaEnElArray?
                                        `rechazar btn-light-danger`:`btn-secondary disabled`
                                    } btn btn-light-danger p-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Rechazar">
                                        <i class="ki-duotone ki-cross-circle fs-2hx"> 
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <div class="btn-group btn-group-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Historial">
                                        <button class="historial btn btn-light-primary p-1" data-bs-toggle="modal" data-bs-target="#historialSolicitud">
                                            <i class="ki-duotone ki-watch fs-2x p-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </div>
                                </div>`;

                    var col8 = `${credenciales.aprobador && estaEnElArray?`<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>`: ` `}`;
                        
                    var rowNode =  tablaSolicitudes.row.add( {
                                        "0": col0,
                                        "1": col1,
                                        "2": col2,
                                        "3": col3,
                                        "4": col4,
                                        "5": col5,
                                        "6": col6,
                                        "7": data[key].Id,
                                        "8": col8
                                    } ).node();
                    $(rowNode).attr('id','s'+data[key].Id );
                    $(rowNode).find('td:eq(0)').addClass('col-2 min-w-175px p-1').attr;
                    $(rowNode).find('td:eq(1)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(2)').addClass('col-1 p-0 flujo').attr("abierto",0);
                    $(rowNode).find('td:eq(3)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(4)').addClass('col-2 min-w-175px p-1');
                    $(rowNode).find('td:eq(5)').addClass('col-1 min-w-100px p-1');
                    $(rowNode).find('td:eq(6)').addClass('col-2 text-end p-1');
                    $(rowNode).find('td:eq(7)').addClass('d-none');
                    $(rowNode).find('td:eq(8)').addClass('p-1');
                    
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
    //console.log(solicitudeActivas)
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
                    tablaSolicitudes.clear(); 
                    bloquear();
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    if(data.success){
                        //console.log(data);
                        cantActiva = 0;
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

    $("#select-all").on('change', function(e){
        e.preventDefault();
        e.stopPropagation();
        var checkbox = $('#tabla-solicitudes tbody tr td:last-child input[type="checkbox"]');
        if ($(this).is(':checked')) {
            // Añade la clase deseada cuando el checkbox está seleccionado
                checkbox.prop('checked',true);
                checkbox.closest('tr').addClass("row-selected");
        } else {
            // Remueve la clase si el checkbox está deseleccionado
                checkbox.prop('checked',false);
                checkbox.closest('tr').removeClass("row-selected");
        }
    });

    $('#tabla-solicitudes tbody').on('change','tr td:last-child input[type="checkbox"]',function(e){
        var tr =$(this).closest('tr');
        if ($(this).is(':checked')) {
            tr.addClass("row-selected");
        }else{
            tr.removeClass("row-selected");
        }
    });
    
    
}));