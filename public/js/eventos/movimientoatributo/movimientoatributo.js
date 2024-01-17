$(document).ready(function() {
    var form = document.getElementById('form-movimiento-atributo');
    const validator = FormValidation.formValidation(
        form,
        {
            fields: {
                'MovimientoId': {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        digits: {
                            message: 'Digitos'
                        }
                    }            
                },
                'AtributoId': {
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

    $("#tabla-movimiento tbody").on("click",'.registrar-movAtributo', function(e) {

        e.preventDefault();
        e.stopPropagation();
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaErrorMovAtr").hide();
        validator.resetForm();
        actualizarValidSelect2();
        var movimientoId= $(this).attr("data-info")
        
        $("#modal-titulo-asignar-grupo").empty();
        btnAddAtributo= $(this);
        

        $.ajax({
            type: 'POST',
            url: VerAtributosFaltantes,
            data: {
                _token: csrfToken,
                data: movimientoId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                bloquear();
            },
            success: function (data) {
                if(data.success){
                    $("#modal-titulo-asignar-grupo").html("Movimiento: "+data.nombre);

                    llenarSelect2(data.movimientos, $('#MovimientoIdInputAtr') );
                    $('#MovimientoIdInputAtr').val(movimientoId).trigger("change").prop("disabled",true);
                    data = data.data;
                    llenarSelect2(data,$('#AtributoIdInputMov'))
                }else{
                    html = '<ul><li style="">'+data.message+'</li></ul>';
                    $("#AlertaError2").append(html);
                    $("#AlertaError2").show();
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
                bloquear();
            }
        });
    });

    const submitButton = document.getElementById('AddSubmitMovAtr');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        // Validate form before submit
        $("#AlertaErrorMovAtr").hide();
        $("#AlertaErrorMovAtr").empty(); 
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                //status
                if (status == 'Valid') {
                    var data = {
                        AtributoId : $('#AtributoIdInputMov').val(),
                        MovimientoId : $('#MovimientoIdInputAtr').val(),
                    }

                    $.ajax({
                        type: 'POST',
                        url: GuardarMovimientoAtributo,
                        data: { 
                            _token: csrfToken,    
                            data: data 
                        },
                        dataType: "json",
                        //content: "application/json; charset=utf-8",
                        beforeSend: function() {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true; 
                            bloquear();
                            KTApp.showPageLoading();
                        },
                        success: function (data) {
                            if(data.success){
                                $('.form-select').val("").trigger("change").prop("disabled",false);
                                var tbody = btnAddAtributo.closest('table').find('tbody');
                                Swal.fire({
                                    text: "Movimientos y atributos agregados con éxito.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-danger btn-cerrar"
                                    }
                                });
                                $('#AtributoIdInput').next().children().children().removeClass("is-valid");
                                $('#MovimientoIdInput').next().children().children().removeClass("is-invalid");
                                actualizarValidSelect2();
                                data.data.forEach(fila =>{
                                    tbody.append(AgregarTR(fila.Id, fila.Nombre, fila.ValorReferencia));
                                    tbody.find('[data-bs-toggle="tooltip"]').tooltip();
                                
                                })

                                $('#registrar-movAtributo').modal('toggle');
                            }else{
                                Swal.fire({
                                    text: data.message,
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
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                        }
                    });
                }
            });
        }
    });

})