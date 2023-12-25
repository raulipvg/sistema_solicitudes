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
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").hide();
        $("#EditSubmit").show();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        
        $.ajax({
            type: 'POST',
            url: VerUsuario,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data);
                //blockUI.release();
                if(data.success){
                    console.log(data)
                    dataselect=data.option;
                    data=data.data;
                    
                    $("#IdInput").val(data.Id);
                    $("#UsernameInput").val(data.Username);
                    $("#PasswordInput").val("********");

                    $("#NombreInput").val(data.Nombre);
                    $("#ApellidoInput").val(data.Apellido);
                    $("#RutInput").val(data.Rut);
                    $("#CorreoInput").val(data.Email);
                  
                    var select = $('#CentroCostoInput');
                    select.empty();
                    for (const key in dataselect) {
                            var option = new Option(dataselect[key].Nombre, dataselect[key].Id);
                            select.append(option);                        
                    }                    
                    $('#CentroCostoInput').val(data.CentroCostoId).trigger("change");
                    $('#EstadoIdInput').val(data.Enabled).trigger("change");
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
                            $('#registrar').modal('toggle');
                    });
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
                            $('#registrar').modal('toggle');
                     });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });
        
    });


});