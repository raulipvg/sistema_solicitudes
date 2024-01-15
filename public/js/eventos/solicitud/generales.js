$(document).ready(function() {
    //BEGIN::EVENTO ACEPTAR ETAPA DEL FLUJO
    $('#tabla-solicitudes').on('click','.aceptar',function(e){
        console.log('Aprobar');
        let obj = $(this).parent();
        let a = obj.attr("a");
        let b = obj.attr("b");
        let c = obj.attr("c");
        //console.log(obj)
        $.ajax({
            type: 'POST',
            url: AprobarSolicitud,
            data: {
                _token: csrfToken,
                data: {a,b,c}
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
                    console.log('todo pulento')
                    
                }else{
                    Swal.fire({
                        text: "Error al Aprobar Solicitud",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
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
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
          });

    

    });
    //END::EVENTO

    //BEGIN::EVENTO RECHAZAR ERAPA DEL FLUJO
    $('#tabla-solicitudes').on('click','.rechazar',function(e){
        console.log('Rechazar');

        $.ajax({
            type: 'POST',
            url: RechazarSolicitud,
            data: {
                _token: csrfToken,
                data: 1
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
                    console.log('todo pulento')
                    
                }else{
                    Swal.fire({
                        text: "Error al Rechazar Solicitud",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
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