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


    const submitButton = document.getElementById('AddSubmitMovAtr');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                //status
                if (status == 'Valid') {
                    var data = {
                        AtributoId : $('#AtributoIdInput').val(),
                        MovimientoId : $('#MovimientoIdInput').val(),
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