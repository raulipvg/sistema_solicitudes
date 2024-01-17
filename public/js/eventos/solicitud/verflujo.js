//Evento en el clic en la columna donde está el flujo de la tabla en solicitudes activas
$('#tabla-solicitudes').on('click','.flujo',function(e){
    var tr = e.target.closest('tr');
    var row = tablaSolicitudes.row(tr);
    //Si no está abierta la fila con el estado de flujo, la abrirá.
    if($(this).attr('abierto') == '0'){
        $(this).attr('abierto','1');
        
        var solicitudId = $(this).parent().find('.btn-group').attr('a');        //Id de la solicitud
        var historialId = $(this).parent().find('.btn-group').attr('b');        //Id del historial
        var flujoId = $(this).parent().find('.btn-group').attr('c');            //Id del flujo asociado al movimiento
        llamaTabla(solicitudId,historialId,flujoId, row);
    }
    else{
        $(this).attr('abierto','0');
        row.child.hide();
        return;
    }
});

//Evento en el clic en la columna donde está el flujo de la tabla en solicitudes terminadas
$('#tabla-solicitudes-terminadas').on('click','.flujo',function(e){
    var tr = e.target.closest('tr');
    var row = tablaSolicitudesTerminadas.row(tr);
    //Si no está abierta la fila con el estado de flujo, la abrirá.
    if($(this).attr('abierto') == '0'){
        $(this).attr('abierto','1');
        
        var solicitudId = $(this).parent().find('.btn-group').attr('a');        //Id de la solicitud
        var historialId = $(this).parent().find('.btn-group').attr('b');        //Id del historial
        var flujoId = $(this).parent().find('.btn-group').attr('c');            //Id del flujo asociado al movimiento

        llamaTabla(solicitudId,historialId,flujoId, row);

    }
    else{
        $(this).attr('abierto','0');
        row.child.hide();
        return;
    }

});

//Evento en el clic en la columna donde está el botón de aceptar/rechazar de la tabla en solicitudes activas
$('#tabla-solicitudes').on('click','.aceptar, .rechazar',function(e){
    console.log("funcionó")
    var tr = e.target.closest('tr');
    var row = tablaSolicitudes.row(tr);
    //Si está abierta la fila con el estado de flujo, actualizará.
    if($(this).parent().parent().parent().find('.flujo').attr('abierto') == '1'){
        console.log("encontrado")
        row.child.hide();
        var solicitudId = $(this).attr('a');        //Id de la solicitud
        var historialId = $(this).attr('b');        //Id del historial
        var flujoId = $(this).attr('c');            //Id del flujo asociado al movimiento
        llamaTabla(solicitudId,historialId,flujoId, row);
    }
});

//función que llena la tabla de flujos
function llamaTabla(solicitudId, historialId, flujoId, row){
    
    $.ajax({
        type: 'POST',
        url: DataTestSolicitud,
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
                console.log(data.data)
                row.child(format(data.data)).show();

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
            $(this).attr('abierto','0');
            row.child.hide();
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

function format(data) {   
    var html=
            `<div class="d-flex justify-content-center">
                <div class="card hover-elevate-up shadow-sm parent-hover" style=" width: 80%;">
                <table id="services_table" class="table table-row-dashed">
                    <thead class="services-info">
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase justify-content-center gs-0">
                            <th class="p-0 ps-3">Flujo: ${data.nombreFlujo}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">`;

        html = html + AgregarTR(data);

    html=  html+'</tbody></table></div></div>';
    return html;   
}

function AgregarTR(data){
    var historial = data.historial;
    var ordenFlujos = data.ordenFlujos
    var html = `<td>
                    <ul class="step-wizard-list">`;
    var contar = 1;
    var usuario;
    ordenFlujos.forEach((orden) => {
        usuario = '-';
        estado = '';
        currentItem = '';
        hist = historial.find(h => h.EstadoFlujoId == orden.Id);
        if(hist){
            // Si el tipo/estado es aprobado
            if(hist.estadoEtapa == 1){
                estado = 'success';
                usuario = hist.Usuario;
                currentItem = '';
            }
            // Si el tipo/estado es rechazado
            else if(hist.estadoEtapa == 2){
                estado = 'cancel';
                currentItem = 'current-item-cancel';
                usuario = hist.Usuario;
            }
            // Si el tipo/estado es en curso
            else if(hist.estadoEtapa == 3){
                currentItem = 'current-item';
            }
        }
        
        html +=
                        `<li class="step-wizard-item ${currentItem}">
                            <span class="text-capitalize">${usuario}</span>
                            <span class="${estado} progress-count">${contar}</span>
                            <span class="progress-label text-capitalize"">${orden.Nombre}</span>
                        </li>`;
        contar++;
    });
    
    html +=        `</ul>
                </td>`;
    return html;
}