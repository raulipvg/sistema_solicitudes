// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    let validator;
    if(credenciales['MovimientoAtributo'].puedeRegistrar || credenciales['MovimientoAtributo'].puedeEditar || credenciales['MovimientoAtributo'].puedeVer){
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
                                    max: 50,
                                    message: 'Entre 3 y 50 caracteres'
                                },
                                regexp: {
                                    regexp: /^[a-z-ñáéíóú\s]+$/i,
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
                        'TipoMonedaId': {
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

    if(credenciales['MovimientoAtributo'].puedeRegistrar){
        // Evento al presionar el Boton de Registrar
        $("#AddBtnAtr").on("click", function (e) {
            //Inicializacion
            //console.log("AddBtnAtr")
            e.preventDefault();
            e.stopPropagation();
            $("#modal-titulo-atr").empty().html("Registrar Atributo");
            $("#NombreAtInput, #ValorReferenciaInput").val('').prop("disabled",false);
            $("#CheckMoneda, #CheckCantidad, #CheckDescripcion").prop("checked",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            $("#radioFecha").prop("checked",true);
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
                            var data = formMap2(fd);                       
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

    if(credenciales['MovimientoAtributo'].puedeEditar){
        var tr;
        var row;
        //Evento al presionar el Boton Editar
        $("#tabla-atributo tbody").on("click",'.editar', function (e) {
            e.preventDefault();
            e.stopPropagation();
            //Inicializacion
            $("#modal-titulo-atr").empty().html("Editar Atributo");
            $("#NombreAtInput, #ValorReferenciaInput").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            $("#CheckMoneda, #CheckCantidad, #CheckDescripcion").prop("checked",false);
            $("#radioFecha").prop("checked",true);

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
                        $('#TipoMonedaIdAtInput').val(data.TipoMonedaId).trigger("change");

                        data.atributoTipo= JSON.parse(data.atributoTipo);
                        data.atributoTipo.forEach(element => {
                            var input;                                
                            if(element.TipoId ===1 ){
                                input='#CheckMoneda';                               
                            }else if(element.TipoId ===2){
                                input='#CheckCantidad';
                            }else if(element.TipoId === 3){
                                input='#CheckDescripcion';
                            }else if(element.TipoId === 4){
                                input='#radioMes';
                            }else if(element.TipoId === 5){
                                input='#radioRango';
                            }else if(element.TipoId === 6){
                                input='#radioAno';
                            }else if(element.TipoId === 7){
                                input='#radioFecha';
                            }
                            $(input).prop("checked",true);
                            $(input).attr("data-info",element.Id)
                        });
                        //console.log(data);
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
                                var data = formMap2(fd);                            

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

    if(credenciales['MovimientoAtributo'].puedeEliminar){
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
                            btn.find("span.indicator-label").first().text('DESHABILITADO')
                        }else{
                            btn.removeClass('btn-light-warning').addClass('btn-light-success');
                            btn.find("span.indicator-label").first().text('HABILITADO')
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