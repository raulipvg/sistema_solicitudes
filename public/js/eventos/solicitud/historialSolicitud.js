$('#tabla-solicitudes').on('click','.historial',function(e){
    var solicitudId = $(this).parent().parent().attr('a');        //Id de la solicitud
    var historialId = $(this).parent().parent().attr('b');        //Id del historial
    var flujoId = $(this).parent().parent().attr('c');            //Id del flujo asociado al movimiento

    $.ajax({
        type: 'POST',
        url: getHistorial,
        data: {
            _token: csrfToken,
            data: {solicitudId, historialId, flujoId}
        },
        //content: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function() {
            bloquear();
            KTApp.showPageLoading();
        },
        success: function (data) {
            if(data.success){
                $('#modal-titulo-historialSolicitud').empty().html("Historial Solicitud "+solicitudId);
                data = data.data;
                estados = data.ordenFlujos;
                $('#lineaTiempo').empty();
                var html,color;
                data.historial.forEach((hist)=>{
                    html = `<div class="m-0">`
                    //Si corresponde al inicio del historial
                    if(hist.EstadoSolicitudId == 1){
                        html = `
                                <div class="d-flex align-items-sm-center mb-5">
                                    <div class="symbol symbol-45px me-4">
                                        <span class="symbol-label bg-primary">
                                           <i class="ki-duotone ki-ship text-inverse-primary fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <div class="flex-grow-1 me-2">
                                            <a href="#" class="text-gray-500 fs-6 fw-semibold"> ${hist.creacion} </a>
                                            <span class="text-gray-800 fw-bold d-block fs-4">Iniciado</span>
                                        </div>
                                    </div>
                                </div>`;
                    }
                        if(hist.EstadoEtapaFlujoId == 1){
                            color = 'danger';
                            tipo = 'Rechazado'
                            
                        }
                        else if(hist.EstadoEtapaFlujoId == 2){
                            color = 'success';
                            tipo = 'Aprobado'
                        }
                        else{
                            color = 'warning';
                            tipo = 'En curso';
                        }
                    
                    if(hist.creacion != hist.actualizacion){
                        var estadoFlujo = estados.find(estado=> estado.EstadoId == hist.estadoFlujoId);
                            
                        if(estadoFlujo.EstadoId == hist.estadoFlujoId){
                            html += 
                                `<div class="timeline">
                                    <div class="timeline-item align-items-center mb-7">
                                        <div class="timeline-line mt-1 mb-n6 mb-sm-n7"></div>

                                        <div class="timeline-icon">
                                            <i class="ki-duotone ki-cd fs-2 text-${color}"><span class="path1"></span><span class="path2"></span></i>
                                        </div>

                                        <div class="timeline-content m-0">

                                             <span class="fs-6 text-gray-500 fw-semibold d-block">${hist.actualizacion}</span>

                                            <span class="fs-6 fw-bold text-gray-800 text-capitalize">${estadoFlujo.EstadoNombre}</span>
                                            <span class='badge badge-lg badge-light-${color} fw-bold my-2 fs-8'> ${tipo} </span>
                                        </div>
                                    </div>
                               </div>`;
                        }
                    }
                    html += '</div>';
                    
                })
                $('#lineaTiempo').html(html);
                //console.log(data);

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