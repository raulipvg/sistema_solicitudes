// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    let validator;
    if(credenciales.puedeRegistrar || credenciales.puedeEditar || credenciales.puedeVer){
        const form = document.getElementById('FormularioEstadoFlujo');
        $("#AlertaError").hide();
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
                                    regexp: /^[a-z0-9ñáéíóú\s]+$/i,
                                    message: 'Solo letras y numeros '
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
        $("#AddBtn").on("click", function (e) {
            //Inicializacion
            //console.log("AddBtn")
            e.preventDefault();
            e.stopPropagation();
            $("#modal-titulo").empty().html("Registrar Estado");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            //$('#EstadoIdInput').val("").trigger("change").prop("disabled",false);

            $("#AddSubmit").show();
            $("#EditSubmit").hide();
            $("#IdInput").prop("disabled",true);
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
                            let form1= $("#FormularioEstadoFlujo");
                            var fd = form1.serialize();
                            var data = formMap(fd);                        

                            $.ajax({
                                type: 'POST',
                                url: GuardarEstado,
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
                                        cargarData.init(data.estadosFlujo);
                                        $('#registrar').modal('toggle');
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
    }

    if(credenciales.puedeEditar){
        var tr;
        var row;
        //Evento al presionar el Boton Editar
        $("#tabla-estado tbody").on("click",'.editar', function (e) {
            e.preventDefault();
            e.stopPropagation();
            //Inicializacion
            $("#modal-titulo").empty().html("Editar Estado");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);

            $("#AddSubmit").hide();
            $("#EditSubmit").show();
            $("#IdInput").prop("disabled",false);
            $("#AlertaError").hide();

            tr = e.target.closest('tr');
            row = miTabla.row(tr);
            validator.resetForm();
            actualizarValidSelect2();

            let id = Number($(this).attr("info"));
            $.ajax({
                type: 'POST',
                url: VerEstado,
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
                        data=data.data;
                        
                        $("#IdInput").val(data.Id);
                        $("#NombreInput").val(data.Nombre);
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

        // Manejador al presionar el submit de Editar
        const submitEditButton = document.getElementById('EditSubmit');
        submitEditButton.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#AlertaError").hide();
                $("#AlertaError").empty();
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {
                        actualizarValidSelect2();
                        //status
                        if (status == 'Valid') {
                                let form1= $("#FormularioEstadoFlujo");
                                var fd = form1.serialize();
                                var data= formMap(fd);
                                
                                $.ajax({
                                    type: 'POST',
                                    url: EditarEstado,
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
                                            miTabla.row(row).remove();
                                            cargarData.init(data.estadosFlujo);
                                            $('#registrar').modal('toggle');
                                        }else{
                                            html = '<ul><li style="">'+data.message+'</li></ul>';
                                            $("#AlertaError").append(html);
                                            $("#AlertaError").show();
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
        // Evento al Boton que cambia el estado del "Estado"
        $("#tabla-estado tbody").on("click", '.estado-estado', function (e) {
            e.preventDefault();
            e.stopPropagation();

            tr = e.target.closest('tr');
            row = miTabla.row(tr).data();
            const userId =  row[0];
            var btn = $(this);

            $.ajax({
                type: 'POST',
                url: CambiarEstado,
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