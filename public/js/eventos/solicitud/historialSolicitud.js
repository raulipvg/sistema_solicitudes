$('#tabla-solicitudes').on('click','.historial',function(e){
    console.log('historial');
    solicitudId = $(this).parent().parent().find('.aceptar').attr('info');
    var movimientoId = 1;

    $.ajax({
        type: 'POST',
        url: getHistorial,
        data: {
            _token: csrfToken,
            data: {solicitudId, movimientoId}
        },
        //content: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function() {
            bloquear();
            KTApp.showPageLoading();
        },
        success: function (data) {
            //console.log(data)
            if(data.success){
                $('#modal-titulo-historialSolicitud').empty().html("Historial Solicitud "+solicitudId);
                data = data.data;
                estados = data.ordenFlujos;
                $('#lineaTiempo').empty();
                var html;
                data.historial.forEach((hist)=>{
                    html = '<div class="m-0">'+
                                    '<div class="d-flex align-items-sm-center mb-5">' +
                                        '<div class="symbol symbol-45px me-4">' +
                                            '<span class="symbol-label bg-primary">'+
                                                '<i class="ki-duotone ki-ship text-inverse-primary fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>' +
                                            '</span>'+
                                        '</div>'+
                                        '<div class="d-flex align-items-center flex-row-fluid flex-wrap">'+
                                            '<div class="flex-grow-1 me-2">'+
                                            '<a href="#" class="text-gray-500 fs-6 fw-semibold">'+hist.creacion+'</a>'+
                                            '<span class="text-gray-800 fw-bold d-block fs-4">'+'Iniciado'+'</span>'+
                                        '</div>';
                    
                    if(hist.tipo == 0){
                        color = 'danger';
                        html +=          '<span class="badge badge-lg badge-light-'+color+' fw-bold my-2 fs-8">Rechazado</span>';
                    }
                    else if(hist.tipo == 1){
                        color = 'success';
                        html +=          '<span class="badge badge-lg badge-light-'+color+' fw-bold my-2 fs-8">Aceptado</span>';
                    }
                    else{
                        color = 'warning';
                        html +=          '<span class="badge badge-lg badge-light-'+color+' fw-bold my-2 fs-8">En curso</span>';
                    }
                    html+=          '</div></div>';

                    if(hist.creacion != hist.actualizacion){
                        estados.forEach((estadoFlujo)=>{
                            if(estadoFlujo.Id == hist.estadoFlujoId){
                                html += 
                                    '<div class="timeline">'+
                                        '<div class="timeline-item align-items-center mb-7">'+
                                            '<div class="timeline-line mt-1 mb-n6 mb-sm-n7"></div>'+

                                            '<div class="timeline-icon">'+
                                                '<i class="ki-duotone ki-cd fs-2 text-'+color+'"><span class="path1"></span><span class="path2"></span></i>'+
                                            '</div>'+

                                            '<div class="timeline-content m-0">'+

                                                ' <span class="fs-6 text-gray-500 fw-semibold d-block">'+hist.actualizacion+'</span>'+ //titulo  

                                                '<span class="fs-6 fw-bold text-gray-800 text-capitalize">'+estadoFlujo.Nombre+'</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                            }
                        });
                    }
                    html +='</div>';
                    
                    if(hist.tipo == 1){
                        html += '<div class="separator separator-dashed my-6"></div>';
                    }else if(hist.tipo == 0){

                    }
                })
                $('#lineaTiempo').html(html);
                console.log(data);

            }else{                       
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
        }
    })

});