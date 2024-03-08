// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    let validator;
    if(credenciales.puedeRegistrar || credenciales.puedeEditar || credenciales.puedeVer){
        const form = document.getElementById('FormularioArea');
        $("#AlertaErrorArea").hide();
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
                                    max: 100,
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
    }

    if(credenciales.puedeRegistrar){
        // Evento al presionar el Boton de Registrar
        $("#AddBtn").on("click", function (e) {
            //Inicializacion
            //console.log("AddBtn")
            e.preventDefault();
            e.stopPropagation();
            $("#modal-titulo").empty().html("Registrar Area");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);
            //$('#EstadoIdAreaInput').val("").trigger("change").prop("disabled",false);

            $("#AddSubmit").show();
            $("#EditSubmit").hide();
            $("#IdAreaInput").prop("disabled",true);
            $("#AlertaErrorArea").hide();

            validator.resetForm();
            actualizarValidSelect2();
        });

        // Manejador al presionar el submit de Registrar
        const submitButton = document.getElementById('AddSubmit');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();
            e.stopPropagation();

            $("#AlertaErrorArea").hide();
            $("#AlertaErrorArea").empty();
            
            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    actualizarValidSelect2();

                    //console.log('validated!');
                    //status
                    if (status == 'Valid') {
                        // Show loading indication                       
                            let form1= $("#FormularioArea");
                            var fd = form1.serialize();
                            var data = formMap(fd);

                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true; 

                            bloquear();

                            $.ajax({
                                type: 'POST',
                                url: GuardarArea,
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
                                        //location.reload();
                                        cargarDataArea.init(data.area);
                                        $('#registrar').modal('toggle');
                                    }else{
                                        //console.log(data.error);
                                            html = '<ul><li style="">'+data.message+'</li></ul>';
                                            $("#AlertaErrorArea").append(html);                                    
                                            $("#AlertaErrorArea").show();
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
        $("#tabla-area tbody").on("click",'.editar', function (e) {
            e.preventDefault();
            e.stopPropagation();
            //Inicializacion
            $("#modal-titulo").empty().html("Editar Area");
            $("input").val('').prop("disabled",false);
            $('.form-select').val("").trigger("change").prop("disabled",false);

            $("#AddSubmit").hide();
            $("#EditSubmit").show();
            $("#IdAreaInput").prop("disabled",false);
            $("#AlertaErrorArea").hide();

            tr = e.target.closest('tr');
            row = miTablaArea.row(tr);
            validator.resetForm();
            actualizarValidSelect2();

            let id = Number($(this).attr("info"));
            
            $.ajax({
                type: 'POST',
                url: VerArea,
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
                        
                        $("#IdAreaInput").val(data.Id);
                        $("#NombreAreaInput").val(data.Nombre);
                        $("#DescripcionAreaInput").val(data.Descripcion);                
                        $('#EstadoIdAreaInput').val(data.Enabled).trigger("change");
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
                $("#AlertaErrorArea").hide();
                $("#AlertaErrorArea").empty();
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {
                        actualizarValidSelect2();
                        //status
                        if (status == 'Valid') {
                                let form1= $("#FormularioArea");
                                var fd = form1.serialize();
                                var data= formMap(fd);                            

                                $.ajax({
                                    type: 'POST',
                                    url: EditarArea,
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
                                            //console.log(data)
                                            miTablaArea.row(row).remove();
                                            cargarDataArea.init(data.area);
                                            $('#registrar').modal('toggle');
                                            //location.reload();
                                        }else{
                                            html = '<ul><li style="">'+data.message+'</li></ul>';
                                            $("#AlertaErrorArea").append(html);
                                            $("#AlertaErrorArea").show();
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
        $("#tabla-area tbody").on("click",'.ver', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $("#modal-titulo").empty().html("Ver Area");
            $("input").val('').prop("disabled",true);
            $('.form-select').val("").trigger("change").prop("disabled",true);
            $("#AddSubmit").hide();
            $("#EditSubmit").hide();
            $("#IdAreaInput").prop("disabled",false);
            $("#AlertaErrorArea").hide();

            validator.resetForm();
            actualizarValidSelect2();

            let id = Number($(this).attr("info"));
            
            $.ajax({
                type: 'POST',
                url: VerArea,
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
                    //console.log(data);
                    if(data){
                        data=data.data;
            
                        $("#IdAreaInput").val(data.Id);
                        $("#NombreAreaInput").val(data.Nombre);
                        $("#DescripcionAreaInput").val(data.Descripcion);           
                        $('#EstadoIdAreaInput').val(data.Enabled).trigger("change");
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
                                $('#registrar').modal('toggle');
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
                            $('#registrar').modal('toggle');
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
        // Evento al Boton que cambia el estado del area
        $("#tabla-area tbody").on("click", '.estado-area', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var userId =  $(this).closest('td').next().find('a.ver').attr('info');
            var btn = $(this);

            $.ajax({
                type: 'POST',
                url: CambiarEstadoArea,
                data: {
                    _token: csrfToken,
                    data: userId
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
    
    if(credenciales2.puedeVer){
        //EVENTO DEL BOTON + DE LA TABLA Y CREA SUBTABLA
        miTablaArea.on('click', 'td.dt-control', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var tr = e.target.closest('tr');
            var row = miTablaArea.row(tr);
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
                    url: VerFlujos,
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
                        if(data.success){
                            console.log(data)
                            area=data.area;             
                            data = data.data;
                            row.child(format(data,area)).show();
                            $(".estado-flujo").tooltip();
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
                        boton.removeAttr("data-kt-indicator");
                        boton.children().eq(0).show();
                        boton.addClass('active')
                    }
                });
            }

            
        });
    }

    if(credenciales2.puedeEliminar){
    //Evento al presionar el Boton de cambiar estado en la subtabla 
    $("#tabla-area tbody").on("click", '.estado-flujo', function(e){
        e.preventDefault();
        e.stopPropagation();
        //console.log("click")
        var accesoId =$(this).attr("info");
        var btn = $(this);
        //console.log(accesoId)
        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: CambiarEstadoFlujo,
            data: {
                _token: csrfToken,
                data: accesoId
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data.errors);
                if(data.success){
                    const fila = btn.closest('tr');
                    fila.remove(); 
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
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });

    });
    }


});