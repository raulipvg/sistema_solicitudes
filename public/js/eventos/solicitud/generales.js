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
                    renderizadoAprobar(data, row);          
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
        //console.log('Rechazar');
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

    $('#aceptar-seleccion').on('click',function(e){
        //console.log("SI");
        let solicitudes=solicitudesSeleccionadas();
        //console.log(solicitudes);

        $.ajax({
            type: 'POST',
            url: AprobarSeleccion,
            data: {
                _token: csrfToken,
                data: {solicitudes}
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
                    //console.log(data);
                    data.forEach( (resp) => {
                        var row1 = tablaSolicitudes.row('#s'+resp.solicitudId);
                        renderizadoAprobar(resp,row1);
                    });                                         
                }else{
                    Swal.fire({
                        text: "Error: "+data.message,
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

    $('#rechazar-seleccion').on('click',function(e){
        //console.log("NO");
        let solicitudes=solicitudesSeleccionadas();
        //console.log(solicitudes);

        $.ajax({
            type: 'POST',
            url: RechazarSeleccion,
            data: {
                _token: csrfToken,
                data: {solicitudes}
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
                    //console.log(data);

                    data.forEach( (resp) => {
                        var row1 = tablaSolicitudes.row('#s'+resp.solicitudId);;
                        cantActiva=cantActiva-1;
                        cantTerminada = cantTerminada+1;
                        $("#activas").text(`ACTIVAS (${cantActiva})`);
                        $("#terminadas").text(`TERMINADAS (${cantTerminada})`);
                        row1.remove().draw();
                        toastr.error("Solicitud Rechazada y Terminada"); 
                    });            
                                                               
                }else{
                    Swal.fire({
                        text: "Error: "+data.message,
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
                        text: "Error al Rechazar las Solicitudes",
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
    

    function solicitudesSeleccionadas(){
        let solicitudes=[];
        $('#tabla-solicitudes .row-selected').each(function (index,item){
            prueba = item.cells[6].childNodes[0];
            //console.log(prueba)
            solicitud ={
                b: prueba.getAttribute("b"),
                c: prueba.getAttribute("c")
            };
            solicitudes.push(solicitud);
            
        });
        return solicitudes;
    }

    function renderizadoAprobar(resp,row){
        var msg='';
        var rowData = row.data();                              
        var col0 = rowData[0];
        var col2= rowData[2];
        var col6 = rowData[6];
        if(resp.flag){
            //celda 0 color estadoSolicitud
            //celda 2 la etapa del flujo
            //celda 6 el bton group atributo b que es el historialId
            //tablaSolicitudes.cell(row, 1).data("1").draw();
            if(resp.estadoSolicitudId == 2){
                var contenedorTemporal = $('<div>').html(col0);
                contenedorTemporal.find('.bg-success').removeClass('bg-success').addClass('bg-warning'); 
                var nuevoHTML = contenedorTemporal.html();
                tablaSolicitudes.cell(row, 0).data(nuevoHTML);
            }
            //Columna del Flujo
            var contenedorTemporal = $('<div>').html(col2);
                contenedorTemporal.find('.badge').text(resp.flujoNombre) 
                var nuevoHTML = contenedorTemporal.html();
                tablaSolicitudes.cell(row, 2).data(nuevoHTML);
            
            //Columna del Botones
            var contenedorTemporal = $('<div>').html(col6);
            contenedorTemporal.find('.btn-group').attr("b",resp.historialId)


            var estaEnElArray = credenciales.grupos.includes(resp.GrupoAprobadorId);
            var btnAprobar = contenedorTemporal.find('.btn-light-success');
            var btnRechazar = contenedorTemporal.find('.btn-light-danger');
            if(estaEnElArray){ 
                btnAprobar.addClass('aceptar btn-light-success').removeClass('disabled btn-secondary');
                btnRechazar.addClass('rechazar btn-light-danger').removeClass('disabled btn-secondary');
            }else{
                btnAprobar.addClass('disabled btn-secondary').removeClass('aceptar btn-light-success');
                btnRechazar.addClass('disabled btn-secondary').removeClass('rechazar btn-light-danger');
                tablaSolicitudes.cell(row,8).data('');
                tr = tablaSolicitudes.row(row).node();
                $(tr).removeClass('row-selected');
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
    }

    
});