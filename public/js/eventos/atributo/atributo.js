// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    let validator;
    if(credenciales.puedeRegistrar || credenciales.puedeEditar || credenciales.puedeVer){
        const form = document.getElementById('FormularioAtributo');
        $("#AlertaErrorAtr").hide();
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
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
                                    regexp: /^[a-zñáéíóú\s]+$/i,
                                    message: 'Solo letras de la A-Z '
                                }
                            }
                        },
                        'ValorReferencia': {
                            validators: {
                                notEmpty: {
                                    message: 'Requerido'
                                },
                                digits: {
                                    message: 'Digitos'
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
                        },
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
    }

    if(credenciales.puedeRegistrar){
        // Evento al presionar el Boton de Registrar
        $("#AddBtnAtr").on("click", function (e) {
            //Inicializacion
            //console.log("AddBtnAtr")
            e.preventDefault();
            e.stopPropagation();
            $("#modal-titulo-atr").empty().html("Registrar Atributo");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            //$('#EstadoIdAtInput').val("").trigger("change").prop("disabled",false);

            $("#AddSubmitAtr").show();
            $("#EditSubmitAtr").hide();
            $("#IdInputAtr").prop("disabled",true);
            $("#AlertaErrorAtr").hide();

            validator.resetForm();
            actualizarValidSelect2();
        });


        // Manejador al presionar el submit de Registrar
        const submitButton = document.getElementById('AddSubmitAtr');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();
            e.stopPropagation();
            $("#NombreAtInput").prop("disabled",false);

            $("#AlertaErrorAtr").hide();
            $("#AlertaErrorAtr").empty();
            
            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    actualizarValidSelect2();
                    //console.log('validated!');
                    //status
                    if (status == 'Valid') {
                        // Show loading indication                       
                            let form1= $("#FormularioAtributo");
                            var fd = form1.serialize();
                            var data = formMap(fd);                       
                            $.ajax({
                                type: 'POST',
                                url: GuardarAtributo,
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
                                        //console.log("exito");
                                        //location.reload();
                                        cargarData.init(data.atributo);
                                        $('#registrar-atributo').modal('toggle');
                                    }else{
                                        //console.log(data.error);
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                        $("#AlertaErrorAtr").append(html);                                    
                                        $("#AlertaErrorAtr").show();
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
    }

    if(credenciales.puedeEditar){
        var tr;
        var row;
        //Evento al presionar el Boton Editar
        $("#tabla-atributo tbody").on("click",'.editar', function (e) {
            e.preventDefault();
            e.stopPropagation();
            //Inicializacion
            $("#modal-titulo-atr").empty().html("Editar Atributo");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);

            $("#AddSubmitAtr").hide();
            $("#EditSubmitAtr").show();
            $("#IdInputAtr").prop("disabled",false);
            $("#NombreAtInput").prop("disabled",false);
            $("#AlertaErrorAtr").hide();

            tr = e.target.closest('tr');
            row = tablaAtributo.row(tr);        
            validator.resetForm();
            actualizarValidSelect2();

            let id = Number($(this).attr("info"));
            bloquear();
            $.ajax({
                type: 'POST',
                url: VerAtributo,
                data: {
                    _token: csrfToken,
                    data: id},
                //content: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    //blockUI.release();
                    if(data.success){                    
                        data=data.data;
                        
                        $("#IdInputAtr").val(data.Id);
                        $("#NombreAtInput").val(data.Nombre);
                        $("#ValorReferenciaInput").val(data.ValorReferencia);
                        $('#EstadoIdAtInput').val(data.Enabled).trigger("change");
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
                                $('#registrar-atributo').modal('toggle');
                        });
                    }
                },
                error: function () {
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
                                $('#registrar-atributo').modal('toggle');
                            });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });
            
        });

        // Manejador al presionar el submit de Editar
        const submitEditButton = document.getElementById('EditSubmitAtr');
        submitEditButton.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#AlertaErrorAtr").hide();
                $("#AlertaErrorAtr").empty();
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {
                        actualizarValidSelect2();
                        //status
                        if (status == 'Valid') {
                                let form1= $("#FormularioAtributo");
                                var fd = form1.serialize();
                                var data= formMap(fd);                           

                                $.ajax({
                                    type: 'POST',
                                    url: EditarAtributo,
                                    data: {
                                        _token: csrfToken,
                                        data: data},
                                    //content: "application/json; charset=utf-8",
                                    dataType: "json",
                                    beforeSend: function() {
                                        bloquear();
                                        KTApp.showPageLoading();
                                    },
                                    success: function (data) {                                    
                                        if(data.success){
                                            //location.reload();
                                            tablaAtributo.row(row).remove();
                                            cargarData.init(data.atributo);
                                            $('#registrar-atributo').modal('toggle');
                                        }else{
                                            html = '<ul><li style="">'+data.message+'</li></ul>';
                                            $("#AlertaErrorAtr").append(html);
                                            $("#AlertaErrorAtr").show();
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
                                });
                            } 
                    });
                }
        });
    }

    if(credenciales.puedeEliminar){
        // Evento al Boton que cambia el estado del "Atributo"
        $("#tabla-atributo tbody").on("click", '.estado-atributo', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var userId =  $(this).closest('td').next().find('a.editar').attr('info');
            var btn = $(this);

            $.ajax({
                type: 'POST',
                url: CambiarEstadoAtributo,
                data: {
                    _token: csrfToken,
                    data: userId},
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
    }

});