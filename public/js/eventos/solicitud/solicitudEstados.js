$(document).ready(function(e){
    let tablaSolicitudes = $('#kt_widget_table_3').DataTable();
    
    
    //Evento en el clic en la columna donde está el flujo de la tabla, es necesario agregar la clase flujo, cambiar el id de la tabla!
    $('#kt_widget_table_3 .flujo').on('click',function(e){
        //console.log('aquí')
        var tr = e.target.closest('tr');
        var row = tablaSolicitudes.row(tr);
        //Si no está abierta la fila con el estado de flujo, la abrirá.
        if($(this).attr('abierto') == '0'){
            $(this).attr('abierto','1');
            
            var solicitudId = $(this).parent().find('.aceptar').attr('info');
            console.log(solicitudId);
            var movimientoId = 1;


            $.ajax({
                type: 'POST',
                url: DataTestSolicitud,
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
                        console.log(data.data);
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
        }
        else{
            $(this).attr('abierto','0');
            row.child.hide();
            return;
        }

    })
})

function format(data) {   
    var html=
    '<div class="d-flex justify-content-center">'+
        '<div class="card hover-elevate-up shadow-sm parent-hover" style=" width: 80%;">'+
        '<table id="services_table" class="table table-row-dashed">'+
            '<thead class="services-info">'+
               '<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">'+
                    '<th class="p-0 ps-3">Flujo: '+data.flujo.Nombre+'</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody class="fw-bold text-gray-600">';

        html = html + AgregarTR(data);

    html=  html+'</tbody></table></div></div>';
    return html;   
}

function AgregarTR(data){
    var historial = data.historial;
    var ordenFlujos = data.ordenFlujos
    var html = '<td><ul class="step-wizard-list">';
    var contar = 1;
    var usuario = '-';
    ordenFlujos.forEach((orden) => {
        usuario = '-';
        estado = null;
        currentItem = null;
        historial.forEach((hist)=>{
            // Si el tipo/estado es rechazado
            if(hist.estadoFlujoId == orden[0].Id && hist.tipo == 0){
                estado = 'cancel';
                currentItem = 'current-item-cancel';
                usuario = hist.usuario;
                return;
            }
            // Si el tipo/estado es aprobado
            else if(hist.estadoFlujoId == orden[0].Id && hist.tipo == 1){
                estado = 'success';
                usuario = hist.usuario;
                return;
            }
            // Si el tipo/estado es en curso
            else if(hist.estadoFlujoId == orden[0].Id && hist.tipo == 2){
                currentItem = 'current-item';
                return;
            }
        })
        html +=
                    '<li class="step-wizard-item '+currentItem+'">'+
                        '<span class="text-capitalize">'+usuario+'</span>'+
                        '<span class="success progress-count '+estado+'">'+contar+'</span>'+
                        '<span class="progress-label text-capitalize" info="'+orden[0].Id+'">'+orden[0].Nombre+'</span>'+
                    '</li>';
        contar++;
    });
    
    html += '</ul></td>';
    
    return html;
}