$(document).ready(function() {

    if(credenciales['Flujo'].puedeVer){
        GetFlujos();
        $("#tab-flujo").on('click', function(e){
            //console.log('flujo');
            GetFlujos();
        });
    }
    
    if(credenciales['EstadoFlujo'].puedeVer){
        $("#tab-estado").on('click', function(e){
            //console.log('estado');
            $.ajax({
                type: 'GET',
                url: VerTodoEstado,
                data: { 
                        _token: csrfToken
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {                
                    bloquear();
                    KTApp.showPageLoading();
                    miTablaEstado.clear();
                    miTablaEstado.draw();
                },
                success: function (data) {
                    if(data.success){                   
                        cargarDataEstado.init(data.data);
                    }else{
                        Swal.fire({
                            text: "Error",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    }
                },
                error: function (e) {
                    //console.log(e);
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
            });
        });
    }

    if(credenciales['Area'].puedeVer){
        $("#tab-area").on('click', function(e){
            //console.log('area');
            $.ajax({
                type: 'GET',
                url: VerTodoArea,
                data: { 
                        _token: csrfToken
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {                
                    bloquear();
                    KTApp.showPageLoading();
                    miTablaArea.clear();
                    miTablaArea.draw();
                },
                success: function (data) {
                    if(data.success){
                        //location.reload();                    
                        cargarDataArea.init(data.data);
                    }else{
                        Swal.fire({
                            text: "Error",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    }
                },
                error: function (e) {
                    //console.log(e);
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
            });
        });
    }

    function GetFlujos(){
        $.ajax({
            type: 'GET',
            url: VerTodoFlujo,
            data: { 
                    _token: csrfToken
                },
            dataType: "json",
            //content: "application/json; charset=utf-8",
            beforeSend: function() {                
                bloquear();
                KTApp.showPageLoading();
                miTablaFlujo.clear();
                miTablaFlujo.draw();
            },
            success: function (data) {
                if(data.success){                   
                    cargarDataFlujo.init(data.data);                
                }else{
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
            },
            error: function (e) {
                //console.log(e);
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
        });
    }
});