const t = document.getElementById("kt_modal_update_role");
const n = new bootstrap.Modal(t);

$(document).ready(function() {
    const form = document.getElementById('FormularioGrupo');
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'Nombre': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 20,
                                message: 'Entre 3 y 20 caracteres'
                            },
                            regexp: {
                                regexp: /^[a-z0-9ñáéíóú\s]+$/i,
                                message: 'Solo letras y numeros'
                            }
                        }
                    },
                    'Descripcion': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 20,
                                message: 'Entre 3 y 100 caracteres'
                            },
                            regexp: {
                                regexp: /^[a-z0-9ñáéíóú\s]+$/i,
                                message: 'Solo caracteres de la A-Z y 0-9'
                            }
                        }
                    },
                    'Enabled': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
    );

     // Evento al presionar el Boton de Registrar
    $("#AddBtnGrupo").on("click", function (e) {
        //Inicializacion
        //console.log("AddBtn")
        e.preventDefault();
        e.stopPropagation();
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);
        //$('#EstadoIdInput').val("").trigger("change").prop("disabled",false);
        $("#AlertaError").hide();
        validator.resetForm();
        actualizarValidSelect2();
    });

    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById('AddSubmit');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();

        $("#AlertaError").hide();
        $("#AlertaError").empty();
        
        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#FormularioGrupo");
                        var fd = form1.serialize();
                        var data = formMap(fd);

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true; 

                        bloquear();

                        $.ajax({
                            type: 'POST',
                            url: GuardarGrupo,
                            data: { 
                                    _token: csrfToken,    
                                    data: data 
                                },
                            dataType: "json",
                            //content: "application/json; charset=utf-8",
                            beforeSend: function() {
                                KTApp.showPageLoading();
                            },
                            success: function (data) {
                                if(data.success){
                                    //console.log("exito");
                                     location.reload();
                                }else{
                                    //console.log(data.error);
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                        $("#AlertaError").append(html);                                    
                                        $("#AlertaError").show();
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
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        }
    });

    //Evento al presionar el Boton Editar
    $("#contenedor").on("click",'.editar-grupo', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Inicializacion
        //$("#modal-titulo").empty().html("Editar Usuario");
        $("input").val('').prop("disabled",false);
        $('.form-check-input').prop('checked', false);

       // $("#AlertaError").hide();
       // $("#AlertaError").hide();

        //validator.resetForm();
        //actualizarValidSelect2();

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
                    data= data.data; 
                    console.log(data);
                    $("#NombreGrupoInput").val(data.Nombre);
                    $("#IdGrupoInput").val(data.Id);

                    for (const key in data.privilegios) {
                        //var option = new Option(data[key].Nombre, data[key].Id);
                        //select.append(option);
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
               
                //blockUI.release();
                //$("#modal-update").html(data);
                //$.getScript(updateGrupo);
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

     // Evento al Boton que cambia el estado del usuario
     $("#contenedor").on("click", '.estado-grupo', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var grupoId =  $(this).attr('data-info');
        var btn = $(this);
        console.log(grupoId)
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
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('INACTIVO')
                    }else{
                        btn.removeClass('btn-light-warning').addClass('btn-light-success');
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
    

});