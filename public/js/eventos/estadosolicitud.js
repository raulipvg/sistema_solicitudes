// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    const form = document.getElementById('Formulario1');
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
                                regexp: /^[a-zñáéíóú\s]+$/i,
                                message: 'Solo letras de la A-Z '
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

    //const target = document.querySelector("#div-bloquear");
    //const blockUI = new KTBlockUI(target)

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
                        let form1= $("#Formulario1");
                        var fd = form1.serialize();
                        var data = formMap(fd);

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true; 

                        bloquear();

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

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        bloquear();
        $.ajax({
            type: 'POST',
            url: VerEstado,
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
                            let form1= $("#Formulario1");
                            var fd = form1.serialize();
                            var data= formMap(fd);
                            bloquear();

                            $.ajax({
                                type: 'POST',
                                url: EditarEstado,
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
                                         location.reload();
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
    
    // Evento al Boton que cambia el estado del "Estado"
    $("#tabla-estado tbody").on("click", '.estado-estado', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var userId =  $(this).closest('td').next().find('a.ver').attr('info');
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

/*
    //Evento al presionar el Boton de cambiar estado en la subtabla 
    $("#tabla-estado tbody").on("click", '.editar-estado', function(e){
        e.preventDefault();
        e.stopPropagation();
        //console.log("click")
        var accesoId =$(this).attr("info");
        var btn = $(this);
        //console.log(accesoId)
        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: EditarAcceso,
            data: {
                _token: csrfToken,
                data: accesoId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data.errors);
                if(data.success){
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('Inactivo')
                    }else{
                        btn.removeClass('btn-light-warning').addClass('btn-light-success');
                        btn.find("span.indicator-label").first().text('Activo')
                    }   
                }else{
                    btn.removeAttr("data-kt-indicator");
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
                //alert('Error');
                btn.removeAttr("data-kt-indicator");
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
        });

    });

    let clickFlag = true;
    // Add event listener for opening and closing details
    miTabla.on('click', 'td.dt-control', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if(!clickFlag ){
            //console.log('blokiao')
            return;
        }
        clickFlag=false;

        var tr = e.target.closest('tr');
        var row = miTabla.row(tr);
        var cell = row.cell(tr, 6); // Elegir bien el numero de colmuna que está el boton + (parte de la col 0)
        var boton= $(cell.node()).find('button');
        var userId= $(this).prev().find('a.editar').attr("info")

        if (row.child.isShown()) {
            // This row is already open - close it
            boton.removeClass('active')
            row.child.hide();
        }
        else {
            // Open this row             
            $.ajax({
                type: 'POST',
                url: VerAcceso,
                data: {
                    _token: csrfToken,
                    data: userId},
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
                    
                        data = data.data;
                        //row.child(format(data)).show();
                        $(".editar-acceso").tooltip();
                        $(".dar-acceso").tooltip();
                    }else{
                        //console.log(data.message)
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
                    boton.removeAttr("data-kt-indicator");
                    boton.children().eq(0).show();
                    boton.addClass('active')
                }
            });
        }

        
    });

    const target2 = document.querySelector("#div-bloquear2");
    const blockUI2 = new KTBlockUI(target2);

    //Evento al presion el boton de Registrar ACCESO en la subtabla
    $("#tabla-estado tbody").on("click",'.registrar-acceso', function(e) {
        //console.log('click')
        e.preventDefault();
        e.stopPropagation();
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaError2").hide();
        validator2.resetForm();
        actualizarValidSelect2();
        //console.log($(this).attr("data-info"))
        $("#EstadoIdInput").val($(this).attr("data-info"));
        var userId= $(this).attr("data-info")
        blockUI2.block();
        $.ajax({
            type: 'POST',
            url: ComunidadSinAcceso,
            data: {
                _token: csrfToken,
                data: userId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                blockUI2.release();
                if(data.success){
                    //console.log(data.data);               
                    data = data.data;
                    var select = $('#ComunidadIdInput2');
                    select.empty();
                    // Agrega las opciones al select
                    var option = new Option('', '');
                    select.append(option);      
                    for (const comunidad in data) {
                            var option = new Option(data[comunidad].Nombre, data[comunidad].Id);
                            select.append(option);                        
                    }
                }else{
                    //console.log(data.message)
                    html = '<ul><li style="">'+data.message+'</li></ul>';
                    $("#AlertaError2").append(html);

                    $("#AlertaError2").show();
                   //console.log("error");
                }
            },
            error: function () {
                //alert('Error');
                blockUI2.release();
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
        });

        



    });
    
    //Evento al presionar el Boton Submit del modal de Registrar NUEVO ACCESO
    const submitButton2 = document.getElementById('AddSubmit-acceso');
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        console.log('guardar')
        $("#AlertaError2").hide();
        $("#AlertaError2").empty();
        
        // Validate form before submit
        if (validator2) {
            validator2.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#Formulario-Acceso");
                        var fd = form1.serialize();
                        const pairs = fd.split('&');

                        const keyValueObject = {};
                       
                        for (let i = 0; i < pairs.length; i++) {
                            const pair = pairs[i].split('=');
                            const key = decodeURIComponent(pair[0]);
                            const value = decodeURIComponent(pair[1]);
                            keyValueObject[key] = value;
                        }

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;     
                        // Remove loading indication
                        //submitButton.removeAttribute('data-kt-indicator');
                        // Enable button
                        //submitButton.disabled = true;
                        blockUI2.block();
                        $.ajax({
                            type: 'POST',
                            url: GuardarAcceso,
                            data: { 
                                    _token: csrfToken,    
                                    data: keyValueObject 
                                },
                            dataType: "json",
                            //content: "application/json; charset=utf-8",
                            beforeSend: function() {
                                
                            },
                            success: function (data) {
                                //console.log(data.errors);
                                blockUI2.release();
                                if(data.success){
                                    //console.log("exito");
                                     location.reload();
                                }else{
                                    //console.log(data.error);
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                       $("#AlertaError2").append(html);

                                    
                                    $("#AlertaError2").show();
                                    
                                   //console.log("error");
                                }
                            },
                            error: function (e) {
                                //console.log(e)
                                //alert('Error');
                                blockUI2.release();

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
                        });
                    // form.submit(); // Submit form
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        }
    });
*/
});