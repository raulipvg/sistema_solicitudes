$(document).ready(function() {   
    let ConsolidadoId =0;
    let MovId =0;

    $("#ConsultarBtn").on('click', function(e){
        TotalCC= [];
        console.log('Consultar')
        var Empresa = $('#EmpresaIdInput').val();
        var CC = $('#CentroCostoIdInput').val();
        var Movimiento = $('#MovimientoIdInput').val();
        var Consolidado = $('#ConsolidadoIdInput').val();

        $.ajax({
            type: 'POST',
            url: VerConsolidados,
            data: {
                _token: csrfToken,
                data: {
                    Empresa,
                    CC,
                    Movimiento,
                    Consolidado
                }
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {                                    
                if(data.success){
                    console.log(data)
                    //var a = data.querySolicitud[2].CostoMoneda;
                    //console.log(JSON.parse(a));
                    miTablaDetalle.clear();
                    cargarData.init(data.querySolicitud, data.tipoCambio)
                    ConsolidadoId = Consolidado;
                    MovId = Movimiento;
                    var html = ``;

                    data.tipoCambio.forEach( (item) => {
                            html+= `<span class="card-label fw-bold text-gray-800">${item.Simbolo}: </span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">${item.ToCLP.toLocaleString()} </span>`
                    });
                
                    $("#tipo-cambio").empty().prepend(html);
                }else{
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
            },
            error: function () {
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });
    });

    miTablaDetalle.on('click', 'td.dt-control', function (e) {
        //console.log('Detalles Asociados');
        e.preventDefault();
        e.stopPropagation();
 
        var tr = e.target.closest('tr');
        var row = miTablaDetalle.row(tr);
        var boton =  $(e.currentTarget).children();

        var a= boton.attr('data-a');
        var b= boton.attr('data-b');
        var c= boton.attr('data-c');
        var d = MovId;
        //$(this).prev().find('a.ver').attr("info")

        if (row.child.isShown()) {
            // This row is already open - close it
            boton.removeClass('active')
            row.child.hide();
            return;
        }
        else {
            // Open this row             
            $.ajax({
                type: 'POST',
                url: VerDetallesAsociados,
                data: {
                    _token: csrfToken,
                    data: { a,b,c, d}
                },
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() {
                    bloquear();
                    KTApp.showPageLoading();
                    boton.children().eq(0).hide();
                    boton.attr("data-kt-indicator", "on");
                },
                success: function (data) {
                    if(data.success){                            
                        boton.children().eq(0).show();
                        boton.addClass('active');                        
                        data = data.data;                        
                        row.child(format(data)).show();

                        var tbody = boton.closest('table').find('tbody');
                        tbody.find('[data-bs-toggle="tooltip"]').tooltip();
                    }else{
                        boton.children().eq(0).show();
                        boton.removeClass('active');                        
                        Swal.fire({
                            text: "Error: "+ data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    }
                },
                error: function () {
                    boton.children().eq(0).show();
                    boton.removeClass('active');
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                    boton.removeAttr("data-kt-indicator");
                    //boton.children().eq(0).show();
                    //boton.addClass('active')
                }
            });
        }

        
    });

    miTablaDetalle.on('click','tr.group td button.ver-solicitudes', function(e) {

        console.log('Solicitudes Aprobadas');
        var a = $(e.currentTarget).attr("data-a");
        $("#modal-titulo-historialSolicitud").text('Solicitudes Aprobadas al Centro de Costo');
        tablaSolicitudesTerminadas.clear().draw();
        $.ajax({
            type: 'POST',
            url: VerSolicitudesAsociadas,
            data: {
                _token: csrfToken,
                data: {
                    a, ConsolidadoId, MovId
                } 
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
                    $("#modal-titulo-historialSolicitud").text('Solicitudes Aprobadas al CC: '+data.solicitudes[0].CentroCosto)
                    cargarDataTerminada.init(data.solicitudes);                        
                }else{
                    Swal.fire({
                        text: "Error al Cargar Solicitudes Asociadas",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        },
                    }).then((result) => {
                        // Verificar si el botón de confirmación fue presionado
                        if (result.isConfirmed) {
                            // lógica aquí al presionar OK;
                            $('#solicitudes').modal('toggle');
                        }
                    });
                }
            },
            error: function () {;
                Swal.fire({
                    text: "Error al Cargar Solicitudes Asociadas",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    },
                }).then((result) => {
                    // Verificar si el botón de confirmación fue presionado
                    if (result.isConfirmed) {
                        // lógica aquí al presionar OK
                        $('#solicitudes').modal('toggle');
                    }
                });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });
        tablaSolicitudesTerminadas.column(6).visible(false)
        tablaSolicitudesTerminadas.column(7).visible(false)
    })
})