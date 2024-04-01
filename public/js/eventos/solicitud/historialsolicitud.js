var formatoFecha={ 
    hour12: false, 
    year: 'numeric', 
    month: '2-digit', 
    day: '2-digit', 
    hour: '2-digit', 
    minute: '2-digit'
};
//
$('#tabla-solicitudes, #tabla-solicitudes-terminadas').on('click','tr td button.historial',function(e){
    obj =$(this).parent().parent();
    var solicitudId = obj.attr('a');        //Id de la solicitud
    var historialId = obj.attr('b');        //Id del historial
    var flujoId = obj.attr('c');            //Id del flujo asociado al movimiento
    
    if ($(this).closest('#tabla-solicitudes').length > 0) {
        cargarHistorial(solicitudId,historialId,flujoId, e,tablaSolicitudes);
    }else if($(this).closest('#tabla-solicitudes-terminadas').length > 0) {
        cargarHistorial(solicitudId,historialId,flujoId,e,tablaSolicitudesTerminadas);
    } 
});

function cargarHistorial(solicitudId,historialId,flujoId,f,tabla){
    
    tr = f.target.closest('tr');
    row = tabla.row(tr);
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = row.cell(row,tabla.column(5)).data();

    var pill = `<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>`;
    solicitante = tempDiv.querySelector('.fs-7').textContent + ': ' +tempDiv.querySelector('span').textContent.toUpperCase();
    $('#Solicitante').html(pill+solicitante);
    
    tempDiv.innerHTML = row.cell(row,tabla.column(0)).data();
    receptor = 'Solicitud para: ' +tempDiv.querySelector('span').textContent.toUpperCase().replace(/^[^\s]+/, '');
    $('#Receptor').html(pill+receptor);

    tempDiv.innerHTML = row.cell(row,tabla.column(3)).data();

    fecha = tempDiv.querySelector('.fs-7').textContent + ': ' +tempDiv.querySelector('.fw-bold').textContent;
    $('#RangoFecha').html(pill+fecha);
    $('#modal-titulo-historialSolicitud').empty().html("Historial Solicitud #"+solicitudId);
    $('#tabla-atributos-solicitud tbody').empty();
    $('#ValorReal').empty();
    $('#lineaTiempo').empty();
    $("#Respaldo").empty();
    $("#RespaldoPadre").hide();

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
                data = data.data;
                //console.log(data);                               
                $('#titulo-flujo').empty().html("Flujo: "+data.query.FlujoNombre);
                $('#Movimiento').text(data.query.MovimientoNombre);     
                //$('#ValorReal').html(pill+'Costo: $'+data.query.costoSolicitud.toLocaleString());
                data.query.Compuesta = JSON.parse(data.query.Compuesta);
                //console.log(data.query.Compuesta);
                data.query.Compuesta.forEach((atr)=>{
                    $('#tabla-atributos-solicitud tbody').append(`
                        <tr>
                            <td class="text-capitalize p-1"> ${atr.Nombre} </td>
                            <td class="text-capitalize p-1"> ${(atr.Cantidad)? atr.Cantidad:''}</td>
                            <td class="p-1"> ${(atr.Simbolo && atr.CostoReal)? atr.Simbolo+' '+atr.CostoReal.toLocaleString() : ''}</td>
                            <td class="text-capitalize p-1"> ${(atr.Descripcion)? atr.Descripcion:''}</td>
                            <td class="text-end p-1"> ${(atr.Fecha1)? atr.Fecha1:''} ${(atr.Fecha2)? '- '+atr.Fecha2: ''}</td>
                        </tr>
                    `);
                });
                if(data.archivo.length > 0 ){
                    data.archivo.forEach((item) => {
                        menu = `<div class="menu-item px-3">
                                    <a href="${item.Url}" target="_blank" class="menu-link px-3">${item.Nombre}</a>
                                </div>`;
                        $("#Respaldo").append(menu);
                    });
                    $("#RespaldoPadre").show();
                }

                estados = data.ordenFlujos;
                footer = '';         
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
                        html += cabecera(fecha,titulo,texto,1)+'<div class="timeline">';
                    }
                    //Si el estado de la solicitud es 3, creará el footer de terminado y se agrega una vez fuera del forEach
                    if(hist.EstadoSolicitudId == 3){
                        fecha = new Date(hist.actualizacion).toLocaleDateString('es-CL',formatoFecha);
                        titulo = 'Terminado';
                        texto = 'Fecha de cierre:'
                        footer = '</div>'+cabecera(fecha,titulo,texto,2);
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

function cabecera(fecha,titulo,texto,flag){

    //header
    if(flag ===1){
        className1= `bg-success`;
        className2= `ki-to-right`;
    //footer
    }else{
        className1= `bg-dark`;
        className2= `ki-abstract-5`;
    }
    html= `
                <div class="d-flex align-items-sm-center mb-1">
                    <div class="symbol symbol-40px me-4">
                        <span class="symbol-label ${className1}">
                            <i class="ki-duotone ${className2} text-white fs-3x"><span class="path1"></span><span class="path2"></span></i>
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