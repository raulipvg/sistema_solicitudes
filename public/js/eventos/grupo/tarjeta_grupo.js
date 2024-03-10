let t,n;
if(credenciales['Grupo'].puedeEditar){
    t = document.getElementById("kt_modal_update_role");
    n = new bootstrap.Modal(t);
}

$(document).ready(function() {
    if(credenciales['Grupo'].puedeEditar){
        //Evento al presionar el Boton Editar
        $("#contenedor").on("click",'.editar-grupo', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $("input").val('').prop("disabled",false);
            $('.form-check-input').prop('checked', false);
            $("#AlertaErrorGrupo").hide();

            let id = Number($(this).attr("data-info"));
            
            $.ajax({
                type: 'POST',
                url: VerGrupoEdit,
                data: {
                    _token: csrfToken,
                    data: id
                },
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() {
                    bloquear();
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    if(data.success){
                        console.log(data);
                        llenarSelect2(data.movimientos,$("#MovimientoId"))
                        llenarSelect2(data.grupos,$("#GrupoId"))
                        
                        $('#MovimientoId').val(data.gruposmovimientos).trigger("change");
                        $('#GrupoId').val(data.gruposaut).trigger("change");
                        //$('#MovimientoId').val(13).trigger("change");
                        data= data.data; 
                        
                        $("#NombreGrupoInput").val(data.Nombre);
                        $("#IdGrupoInput").val(data.Id);

                        for (const key in data.privilegios) {
                            $("#IdPrivilegio"+data.privilegios[key].Id).val(data.privilegios[key].pivot.Id)

                            var privilegioTr= $("#IdPrivilegio"+data.privilegios[key].Id).closest('tr');
                            var ver =privilegioTr.find('input[name="GrupoPrivilegio['+data.privilegios[key].Id+'][Ver]"]');
                            var registrar =privilegioTr.find('input[name="GrupoPrivilegio['+data.privilegios[key].Id+'][Registrar]"]');
                            var editar =privilegioTr.find('input[name="GrupoPrivilegio['+data.privilegios[key].Id+'][Editar]"]');
                            var eliminar =privilegioTr.find('input[name="GrupoPrivilegio['+data.privilegios[key].Id+'][Eliminar]"]');
                            
                            (data.privilegios[key].pivot.Ver == 1)?ver.prop('checked', true):0;
                            (data.privilegios[key].pivot.Registrar == 1)?registrar.prop('checked', true):0;
                            (data.privilegios[key].pivot.Editar == 1)?(editar.prop('checked', true)):0;
                            (data.privilegios[key].pivot.Eliminar == 1)?(eliminar.prop('checked', true)):0;
                            
                            //console.log(data.privilegios[key]) 
                            //console.log(ver)                       
                        }  
                    }else{
                        Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    $(".btn-cerrar").on("click", function () {
                            //console.log("Error");
                            $('#kt_modal_update_role').modal('toggle');
                        })
                    }
                },
                error: function () {;
                    Swal.fire({
                                text: "Error de Carga",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-danger btn-cerrar"
                                }
                            });
                    $(".btn-cerrar").on("click", function () {
                                //console.log("Error");
                                $('#kt_modal_update_role').modal('toggle');
                            });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });
            
        });
    }
    if(credenciales['Grupo'].puedeEliminar){
        // Evento al Boton que cambia el estado del usuario
        $("#contenedor").on("click", '.estado-grupo', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var grupoId =  $(this).attr('data-info');
            var btn = $(this);
            //console.log(grupoId)
            $.ajax({
                type: 'POST',
                url: CambiarEstadoGrupo,
                data: {
                    _token: csrfToken,
                    data: grupoId
                },
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() {
                    btn.attr("data-kt-indicator", "on");
                    btn.prop("disabled",true);
                },
                success: function (data) {
                    if(data.success){
                        if(btn.hasClass('btn-success')){
                            btn.removeClass('btn-success').addClass('btn-warning');
                            btn.find("span.indicator-label").first().text('INACTIVO')
                        }else{
                            btn.removeClass('btn-warning').addClass('btn-success');
                            btn.find("span.indicator-label").first().text('ACTIVO')
                        }   
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
                    btn.removeAttr("data-kt-indicator");
                    btn.prop("disabled",false);
                }
            });

        });
    }


});
