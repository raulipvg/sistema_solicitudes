var formatoFecha={ 
    hour12: false, 
    year: 'numeric', 
    month: '2-digit', 
    day: '2-digit', 
    hour: '2-digit', 
    minute: '2-digit'
};
//
$('#tabla-solicitudes').on('click','.historial',function(e){
    var solicitudId = $(this).parent().parent().attr('a');        //Id de la solicitud
    var historialId = $(this).parent().parent().attr('b');        //Id del historial
    var flujoId = $(this).parent().parent().attr('c');            //Id del flujo asociado al movimiento

    
    cargarHistorial(solicitudId,historialId,flujoId, e,tablaSolicitudes);

});

$('#tabla-solicitudes-terminadas').on('click','.historial',function(e){
    var solicitudId = $(this).parent().parent().attr('a');        //Id de la solicitud
    var historialId = $(this).parent().parent().attr('b');        //Id del historial
    var flujoId = $(this).parent().parent().attr('c');            //Id del flujo asociado al movimiento

    
    cargarHistorial(solicitudId,historialId,flujoId,e,tablaSolicitudesTerminadas);

});

function cargarHistorial(solicitudId,historialId,flujoId,f,tabla){
    $('#tabla-atributos-solicitud tbody').empty();
    tr = f.target.closest('tr');
    row = tabla.row(tr);
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = row.cell(row,tabla.column(5)).data();

    var pill = `<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>`
    solicitante = tempDiv.querySelector('.fs-7').textContent + ' ' +tempDiv.querySelector('a').textContent;
    $('#Solicitante').html(pill+solicitante);
    
    tempDiv.innerHTML = row.cell(row,tabla.column(0)).data();
    receptor = 'Solicitud para: ' +tempDiv.querySelector('a').textContent;
    $('#Receptor').html(pill+receptor);

    tempDiv.innerHTML = row.cell(row,tabla.column(3)).data();

    fecha = tempDiv.querySelector('.fs-7').textContent + ': ' +tempDiv.querySelector('.fw-bold').textContent;
    $('#RangoFecha').html(pill+fecha);


    $.ajax({
        type: 'POST',
        url: getHistorial,
        data: {
            _token: csrfToken,
            data: {solicitudId, historialId, flujoId}
        },

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
                $('#ValorReal').empty().html(pill+'Costo: $'+data.costoSolicitud);
                var valorRef = 0;
                data.costoPorAtributo.forEach((atr)=>{
                    valorRef += atr.ValorReferencia;
                    $('#tabla-atributos-solicitud tbody').append(`
                        <tr>
                            <td class="text-capitalize p-1"> ${atr.Nombre} </td>
                            <td class="p-1"> $ ${atr.ValorReferencia} </td>
                        </tr>
                    `);
                });

                estados = data.ordenFlujos;
                footer = '';

                $('#lineaTiempo').empty();
                var html,color,usuario = '';
                var primerEstado = true;
                html ='<div class="m-0">';
                data.historial.forEach((hist)=>{
                    linea='';
                    //Si es el primer estado que lee, agregará la cabecera de iniciado
                    if(primerEstado){
                        primerEstado = false;
                        fecha = new Date(hist.creacion).toLocaleDateString('es-CL',formatoFecha);
                        titulo = 'Iniciado';
                        texto = 'Fecha de creación:'
                        html += cabecera(fecha,titulo,texto)+'<div class="timeline">';
                    }
                    //Si el estado de la solicitud es 3, creará el footer de terminado y se agrega una vez fuera del forEach
                    if(hist.EstadoSolicitudId == 3){
                        fecha = new Date(hist.actualizacion).toLocaleDateString('es-CL',formatoFecha);
                        titulo = 'Terminado';
                        texto = 'Fecha de cierre:'
                        footer = '</div>'+cabecera(fecha,titulo,texto);
                    }

                    if(hist.EstadoEtapaFlujoId == 1){
                        color = 'success';
                        tipo = 'Aprobado';
                        usuario = `<span class="fs-6 text-gray-500 fw-semibold d-block text-capitalize"> Responsable: ${hist.Usuario}</span>
                        <span class="fs-7 text-gray-500 fw-semibold d-block">Actualización: ${new Date(hist.actualizacion).toLocaleDateString('es-CL',formatoFecha)}</span>`;
                        hist.EstadoSolicitudId==3 ? linea = '' : linea = '<div class="timeline-line mt-1 mb-n6 mb-sm-n7"></div>';   // Si la solicitud está terminada, no agrega la línea al final del flujo, en caso contrario, si
                    }
                    else if(hist.EstadoEtapaFlujoId == 2){
                        color = 'danger';
                        tipo = 'Rechazado';
                        usuario = `<span class="fs-6 text-gray-500 fw-semibold d-block"> Responsable: ${hist.Usuario}</span>
                        <span class="fs-6 text-gray-500 fw-semibold d-block">Actualización: ${new Date(hist.actualizacion).toLocaleDateString('es-CL',formatoFecha)}</span>`;
                    }
                    else if(hist.EstadoEtapaFlujoId == 3){
                        color = 'warning';
                        tipo = 'Pendiente';
                        usuario = '';
                    }
                        
                    var estadoFlujo = estados.find(estado=> estado.EstadoId == hist.estadoFlujoId);

                    html += 
                            `
                                <div class="timeline-item align-items-center mb-5">
                                    ${linea}

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
                });
                html += footer;
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
                <div class="d-flex align-items-sm-center mb-1">
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