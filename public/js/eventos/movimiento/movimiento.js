// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    let validator;
    if(credenciales.puedeRegistrar || credenciales.puedeEditar || credenciales.puedeVer){
        const form = document.getElementById('FormularioMovimiento');
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
                                    regexp: /^[a-zA-Z0-9ñáéíóú\s]+$/,
                                    message: 'Solo letras y números '
                                }
                            }
                        },
                        'GrupoId': {
                            validators: {
                                notEmpty: {
                                    message: 'Requerido'
                                },
                                digits: {
                                    message: 'Digitos'
                                }
                            }
                        },
                        'FlujoId': {
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
        $("#addBtnMovimiento").on("click", function (e) {
            //Inicializacion
            //console.log("addBtnMovimiento")
            e.preventDefault();
            e.stopPropagation();
            $("#modal-titulo").empty().html("Registrar Movimiento");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            //$('#EstadoIdInput').val("").trigger("change").prop("disabled",false);

            $("#AddSubmitMov").show();
            $("#EditSubmitMov").hide();
            $("#IdInput").prop("disabled",true);
            $("#AlertaError").hide();

            $.ajax({
                type: 'POST',
                url: VerGruposFlujosMovimiento,
                data: {
                    _token: csrfToken,
                    data: null},
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
                        var select = $('#GrupoIdInput');
                        llenarSelect2(data.grupos, $('#GrupoIdInput') );
                        llenarSelect2(data.flujos, $('#FlujoIdInput') );
                        
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
                                $('#registrar-movimiento').modal('toggle');
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
                                $('#registrar-movimiento').modal('toggle');
                        });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });

            validator.resetForm();
            actualizarValidSelect2();
        });

        // Manejador al presionar el submit de Registrar
        const submitButton = document.getElementById('AddSubmitMov');
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
                            let form1= $("#FormularioMovimiento");
                            var fd = form1.serialize();
                            var data = formMap(fd);

                            $.ajax({
                                type: 'POST',
                                url: GuardarMovimiento,
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
                                        cargarDataMovimiento.init(data.movimiento);
                                        $('#registrar-movimiento').modal('toggle');
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
        //Evento al presionar el Boton Editar
        $("#tabla-movimiento tbody").on("click",'.editar', function (e) {
            e.preventDefault();
            e.stopPropagation();
            //Inicializacion
            $("#modal-titulo").empty().html("Editar Movimiento");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);

            $("#AddSubmitMov").hide();
            $("#EditSubmitMov").show();
            $("#IdInput").prop("disabled",false);
            $("#AlertaError").hide();

            validator.resetForm();
            actualizarValidSelect2();

            let id = Number($(this).attr("info"));
            

            bloquear();
            $.ajax({
                type: 'POST',
                url: VerMovimiento,
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

                        llenarSelect2(data.grupos, $('#GrupoIdInput') );
                        llenarSelect2(data.flujos, $('#FlujoIdInput') );
                        
                        $("#IdInput").val(data.Id);
                        $("#NombreInput").val(data.Nombre);
                        $('#GrupoIdInput').val(data.GrupoId).trigger("change");
                        $('#FlujoIdInput').val(data.FlujoId).trigger("change");
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
                                $('#registrar-movimiento').modal('toggle');
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
                                $('#registrar-movimiento').modal('toggle');
                        });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });
            
        });

        var tr;
        var row;
        // Manejador al presionar el submit de Editar
        const submitEditButton = document.getElementById('EditSubmitMov');
        submitEditButton.addEventListener('click', function (e) {
            tr = e.target.closest('tr');
            row = tablaMovimiento.row(tr);
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
                        let form1= $("#FormularioMovimiento");
                        var fd = form1.serialize();
                        var data= formMap(fd);
                        bloquear();

                        $.ajax({
                            type: 'POST',
                            url: EditarMovimiento,
                                data: {
                                    _token: csrfToken,
                                    data: data},
                                    //content: "application/json; charset=utf-8",
                            dataType: "json",
                            beforeSend: function() {
                                KTApp.showPageLoading();
                            },
                            success: function (data) {                                    
                                if(data.success){
                                    tablaMovimiento.row(row).remove();
                                    cargarDataMovimiento.init(data.movimiento);
                                    $('#registrar-movimiento').modal('toggle');
                                }else{
                                    // html = '<ul><li style="">'+data.message+'</li></ul>';
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
    if(credenciales.puedeVer){ 
        //Evento al presionar el Boton VER
        $("#tabla-movimiento tbody").on("click",'.ver', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $("#modal-titulo").empty().html("Ver Movimiento");
            $("input").val('').prop("disabled",true);
            $('.form-select').val("").trigger("change").prop("disabled",true);
            $("#AddSubmitMov").hide();
            $("#EditSubmitMov").hide();
            $("#IdInput").prop("disabled",false);
            $("#AlertaError").hide();

            validator.resetForm();
            actualizarValidSelect2();



            let id = Number($(this).attr("info"));
            $.ajax({
                type: 'POST',
                url: VerMovimiento,
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
                    if(data){
                        
                        data=data.data;
                        llenarSelect2(data.grupos, $('#GrupoIdInput') );
                        llenarSelect2(data.flujos, $('#FlujoIdInput') );
                        
                        $("#IdInput").val(data.Id);
                        $("#NombreInput").val(data.Nombre);
                        $('#GrupoIdInput').val(data.GrupoId).trigger("change");
                        $('#FlujoIdInput').val(data.FlujoId).trigger("change");
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
                                //console.log("Error");
                                $('#registrar-movimiento').modal('toggle');
                        });
                    }
                },
                error: function () {
                    //blockUI.release();
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
                            console.log("Error");
                            $('#registrar-movimiento').modal('toggle');
                    });
                },
                complete: function(){
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                }
            });


        });
    }
    
    if(credenciales.puedeEliminar){
        // Evento al Boton que cambia el estado del "Movimiento"
        $("#tabla-movimiento tbody").on("click", '.estado-movimiento', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var userId =  $(this).closest('td').next().find('a.ver').attr('info');
            var btn = $(this);

            $.ajax({
                type: 'POST',
                url: CambiarEstadoMovimiento,
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

    if(credenciales.puedeVer){ 
        //EVENTO DEL BOTON + DE LA TABLA Y CREA SUBTABLA
        tablaMovimiento.on('click', 'td.dt-control', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var tr = e.target.closest('tr');
            var row = tablaMovimiento.row(tr);
            var cell = row.cell(tr, 6); // Elegir bien el numero de colmuna que está el boton + (parte de la col 0)
            var boton= $(cell.node()).find('button');
            var userId= $(this).prev().find('a.ver').attr("info")

            if (row.child.isShown()) {
                // This row is already open - close it
                boton.removeClass('active')
                row.child.hide();
                return;
            }
            else {
                // Open this row             
                $.ajax({
                    type: 'POST',
                    url: VerMovimientoAtributo,
                    data: {
                        _token: csrfToken,
                        data: userId
                    },
                    //content: "application/json; charset=utf-8",
                    dataType: "json",
                    beforeSend: function() {
                        bloquear();
                        KTApp.showPageLoading();
                        boton.children().eq(0).hide();
                        boton.attr("data-kt-indicator", "on");
                    },
                    success: function (data) {
                        //console.log(data)
                        if(data.success){  
                            boton.children().eq(0).show();
                            boton.addClass('active')
                            movimiento= data.movimiento;
                            data = data.data;

                            row.child(format(data,movimiento)).show();

                            var tbody = boton.closest('table').find('tbody');
                            tbody.find('[data-bs-toggle="tooltip"]').tooltip();

                            //$(".editar-acceso").tooltip();
                            //$(".dar-acceso").tooltip();
                        }else{
                            boton.children().eq(0).show();
                            boton.removeClass('active');                        
                            Swal.fire({
                                text: "Error: "+ data.message,
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
                        boton.children().eq(0).show();
                        boton.removeClass('active');
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
                        boton.removeAttr("data-kt-indicator");
                    }
                });
            }
        });
    }

});