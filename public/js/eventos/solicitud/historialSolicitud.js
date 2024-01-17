var formatoFecha={ 
    timeZone: 'UTC', 
    hour12: false, 
    year: 'numeric', 
    month: '2-digit', 
    day: '2-digit', 
    hour: '2-digit', 
    minute: '2-digit'
};

$('#tabla-solicitudes').on('click','.historial',function(e){
    var solicitudId = $(this).parent().parent().attr('a');        //Id de la solicitud
    var historialId = $(this).parent().parent().attr('b');        //Id del historial
    var flujoId = $(this).parent().parent().attr('c');            //Id del flujo asociado al movimiento

    tr = e.target.closest('tr');
    row = tablaSolicitudes.row(tr);
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(5)).data();
    var pill = `<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>`
    solicitante = tempDiv.querySelector('.fs-7').textContent + ' ' +tempDiv.querySelector('a').textContent;
    $('#Solicitante').html(pill+solicitante);
    
    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(0)).data();
    receptor = 'Receptor: ' +tempDiv.querySelector('a').textContent;
    $('#Receptor').html(pill+receptor);

    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(3)).data();
    console.log(tempDiv);
    fecha = tempDiv.querySelector('.fs-7').textContent + ': ' +tempDiv.querySelector('.fw-bold').textContent;
    $('#RangoFecha').html(pill+fecha);
    
    cargarHistorial(solicitudId,historialId,flujoId);

});

$('#tabla-solicitudes-terminadas').on('click','.historial',function(e){
    var solicitudId = $(this).parent().parent().attr('a');        //Id de la solicitud
    var historialId = $(this).parent().parent().attr('b');        //Id del historial
    var flujoId = $(this).parent().parent().attr('c');            //Id del flujo asociado al movimiento

    tr = e.target.closest('tr');
    row = tablaSolicitudesTerminadas.row(tr);
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(5)).data();
    var pill = `<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>`
    solicitante = tempDiv.querySelector('.fs-7').textContent + ' ' +tempDiv.querySelector('a').textContent;
    $('#Solicitante').html(pill+solicitante);
    
    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(0)).data();
    receptor = 'Receptor: ' +tempDiv.querySelector('a').textContent;
    $('#Receptor').html(pill+receptor);

    tempDiv.innerHTML = row.cell(row,tablaSolicitudes.column(3)).data();
    console.log(tempDiv);
    fecha = tempDiv.querySelector('.fs-7').textContent + ': ' +tempDiv.querySelector('.fw-bold').textContent;
    $('#RangoFecha').html(pill+fecha);
    cargarHistorial(solicitudId,historialId,flujoId);

});

function cargarHistorial(solicitudId,historialId,flujoId){

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
                $('#titulo-flujo').empty().html("Flujo: "+data.data.flujoNombre);
                data = data.data;
                estados = data.ordenFlujos;
                footer = '';
                
                $('#lineaTiempo').empty();
                var html,color,usuario = '';
                
                html = `<div class="m-0">`
                data.historial.forEach((hist)=>{
                    if(hist.EstadoSolicitudId != 2){
                        if(hist.EstadoSolicitudId == 1){
                            fecha = new Date(hist.creacion).toLocaleDateString(formatoFecha);
                            titulo = 'Iniciado';
                            texto = 'Fecha de creación:'
                            html += cabecera(fecha,titulo,texto)+'<div class="timeline">';
                        }
                        else if(hist.EstadoSolicitudId == 3){
                            fecha = new Date(hist.actualizacion).toLocaleDateString(formatoFecha);
                            titulo = 'Terminado';
                            texto = 'Fecha de cierre:'
                            footer = '</div>'+cabecera(fecha,titulo,texto);
                        }
                    }

                    if(hist.EstadoEtapaFlujoId == 1){
                        color = 'success';
                        tipo = 'Aprobado';
                        usuario = `<span class="fs-6 text-gray-500 fw-semibold d-block text-capitalize"> Responsable: ${hist.Usuario}</span>
                        <span class="fs-7 text-gray-500 fw-semibold d-block">Actualización: ${new Date(hist.actualizacion).toLocaleDateString(formatoFecha)}</span>`;
                    }
                    else if(hist.EstadoEtapaFlujoId == 2){
                        color = 'danger';
                        tipo = 'Rechazado';
                        usuario = `<span class="fs-6 text-gray-500 fw-semibold d-block"> Responsable: ${hist.Usuario}</span>
                        <span class="fs-6 text-gray-500 fw-semibold d-block">Actualización: ${new Date(hist.actualizacion).toLocaleDateString(formatoFecha)}</span>`;
                    }
                    else if(hist.EstadoEtapaFlujoId == 3){
                        color = 'warning';
                        tipo = 'Pendiente';
                        usuario = '';
                    }
                        
                    var estadoFlujo = estados.find(estado=> estado.EstadoId == hist.estadoFlujoId);

                    html += 
                            `
                                <div class="timeline-item align-items-center mb-7">
                                    <div class="timeline-line mt-1 mb-n6 mb-sm-n7"></div>

                                    <div class="timeline-icon">
                                        <i class="ki-duotone ki-cd fs-2 text-${color}"><span class="path1"></span><span class="path2"></span></i>
                                    </div>

                                    <div class="timeline-content m-0">

                                        <span class="fs-7 text-gray-500 fw-semibold d-block">${new Date(hist.creacion).toLocaleDateString(formatoFecha)}</span>

                                        <span class="fs-6 fw-bold text-gray-800 text-capitalize">${estadoFlujo.EstadoNombre}</span>
                                        <span class='badge badge-lg badge-light-${color} fw-bold my-2 fs-8'> ${tipo} </span>
                                        ${usuario}
                                    </div>
                                </div>`;
                    
                    html += footer;
                });
                $('#lineaTiempo').html(html);

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
}

function cabecera(fecha,titulo,texto){
    html= `
                <div class="d-flex align-items-sm-center mb-5">
                    <div class="symbol symbol-45px me-4">
                        <span class="symbol-label bg-primary">
                        <i class="ki-duotone ki-ship text-inverse-primary fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                        <div class="flex-grow-1 me-2">
                            <a href="#" class="text-gray-500 fs-7 fw-semibold"> ${texto} ${fecha} </a>
                            <span class="text-gray-800 fw-bold d-block fs-4">${titulo}</span>
                        </div>
                    </div>
                </div>`;
    return html;
}