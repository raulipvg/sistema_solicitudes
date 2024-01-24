$(document).ready(function() {
    
    //BEGIN::EVENTO ACEPTAR ETAPA DEL FLUJO
    $('#tabla-solicitudes').on('click','.aceptar',function(e){
        //console.log('Aprobar');
        let obj = $(this).parent();
        //let a = obj.attr("a");
        let b = obj.attr("b");
        let c = obj.attr("c");
        //console.log(obj)

        tr = e.target.closest('tr');
        row = tablaSolicitudes.row(tr);
        var aux = row.data();
        var col0 = aux[0];
        var col2= aux[2];
        var col6 = aux[6];
        
        //console.log(col0) 
        //col0.removeClass("bg-success").addClass("bg-warning");
        //console.log(col0.prop('outerHTML'));
        //tablaSolicitudes.cell(row,0).data(col0.prop('outerHTML')).draw();
      
        $.ajax({
            type: 'POST',
            url: AprobarSolicitud,
            data: {
                _token: csrfToken,
                data: {b,c}
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {                        
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                if(data.success){
                    data= data.data;
                    var msg;
                    //console.log(data)                                    
                    //Solicitud en Estado Etapa Pendiente
                    if(data.flag){
                        //celda 0 color estadoSolicitud
                        //celda 2 la etapa del flujo
                        //celda 6 el bton group atributo b que es el historialId
                        //tablaSolicitudes.cell(row, 1).data("1").draw();
                        if(data.estadoSolicitudId == 2){
                            var contenedorTemporal = $('<div>').html(col0);
                            contenedorTemporal.find('.bg-success').removeClass('bg-success').addClass('bg-warning'); 
                            var nuevoHTML = contenedorTemporal.html();
                            tablaSolicitudes.cell(row, 0).data(nuevoHTML);
                        }
                        //Columna del Flujo
                        var contenedorTemporal = $('<div>').html(col2);
                            contenedorTemporal.find('.badge').text(data.flujoNombre) 
                            var nuevoHTML = contenedorTemporal.html();
                            tablaSolicitudes.cell(row, 2).data(nuevoHTML);
                        
                        //Columna del Botones
                        var contenedorTemporal = $('<div>').html(col6);
                        contenedorTemporal.find('.btn-group').attr("b",data.historialId)


                        var estaEnElArray = credenciales.grupos.includes(data.GrupoAprobadorId);
                        var btnAprobar = contenedorTemporal.find('.btn-light-success');
                        var btnRechazar = contenedorTemporal.find('.btn-light-danger');
                        if(estaEnElArray){ 
                            btnAprobar.addClass('aceptar').removeClass('disabled');
                            btnRechazar.addClass('rechazar').removeClass('disabled');
                        }else{
                            btnAprobar.addClass('disabled').removeClass('aceptar');
                            btnRechazar.addClass('disabled').removeClass('rechazar');
                        }
                        var nuevoHTML = contenedorTemporal.html();
                        tablaSolicitudes.cell(row, 6).data(nuevoHTML);
                        //tablaSolicitudes.cell(row, 6).node().querySelector('[data-bs-toggle="tooltip"]').tooltip();
                        $(tablaSolicitudes.cell(row, 6).node().querySelectorAll('[data-bs-toggle="tooltip"]')).each(function () {
                            $(this).tooltip();
                        });
                        tablaSolicitudes.draw();
                        msg="Etapa de la Solicitud Aprobada";

                    }else{
                        //Solicitud en Estado Etapa Terminada
                        cantActiva= cantActiva-1;
                        cantTerminada= cantTerminada+1;
                        $("#activas").text(`ACTIVAS (${cantActiva})`);
                        $("#terminadas").text(`TERMINADAS (${cantTerminada})`);
                        row.remove().draw();
                        msg="Solicitud Aprobada y Terminada"
                    }
                    
                    toastr.success(msg);
                    
                    
                }else{
                    Swal.fire({
                        text: "Error al Aprobar: "+data.message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    }).then((result) => {
                        if(result.isConfirmed && data.message.length === 39 ){
                            location.reload();
                        }
                    });
                }
            },
            error: function () {;
                Swal.fire({
                        text: "Error al Aprobar Solicitud",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
            },
            complete: function() {
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
          });

    

    });
    //END::EVENTO

    //BEGIN::EVENTO RECHAZAR ETAPA DEL FLUJO
    $('#tabla-solicitudes').on('click','.rechazar',function(e){
        console.log('Rechazar');
        let obj = $(this).parent();
        //let a = obj.attr("a");
        let b = obj.attr("b");
        let c = obj.attr("c");

        tr = e.target.closest('tr');
        row = tablaSolicitudes.row(tr);

        $.ajax({
            type: 'POST',
            url: RechazarSolicitud,
            data: {
                _token: csrfToken,
                data: {b,c}
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() { 
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                if(data.success){
                    data= data.data;                                    
                    //console.log('todo pulento');
                    cantActiva=cantActiva-1;
                    cantTerminada = cantTerminada+1;
                    $("#activas").text(`ACTIVAS (${cantActiva})`);
                    $("#terminadas").text(`TERMINADAS (${cantTerminada})`);
                    row.remove().draw();
                    toastr.error("Solicitud Rechazada y Terminada");
                    
                }else{
                    Swal.fire({
                        text: "Error al Rechazar: "+data.message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    }).then((result) => {
                        if(result.isConfirmed && data.message.length === 39 ){
                            location.reload();
                        }
                    });
                }
            },
            error: function () {;
                Swal.fire({
                        text: "Error al Rechazar Solicitud",
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
    

    });
    //END::EVENTO

    
});