// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    const form = document.getElementById('FormularioEmpresa');
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
                    'Rut': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 9,
                                max: 10,
                                message: 'Entre 9 y 10 caracteres'
                            },
                            callback: {
                                message: 'Rut Inválido',
                                callback: function(input) {
                                    var rutCompleto = input.value;
                                    if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto)) return false;

                                    var tmp = rutCompleto.split('-');
                                    var digv = tmp[1];
                                    var rut = tmp[0];
                                    if (digv == 'K') digv = 'k';
                                    return (dv(rut) == digv);

                                    function dv(T) {
                                        var M = 0, S = 1;
                                        for (; T; T = Math.floor(T / 10))
                                            S = (S + T % 10 * (9 - M++ % 6)) % 11;
                                        return S ? S - 1 : 'k';
                                    }
                                }
                            }
                            
                        }
                    },
                    'Email': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            emailAddress: {
                                message: 'Email inválido'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                                message: 'Formato inválido'
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
                },plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
    );

    const form2 = document.getElementById('Formulario-CC');
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator2 = FormValidation.formValidation(
            form2,
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

    //const target = document.querySelector("#div-bloquear");
    //const blockUI = new KTBlockUI(target)

     // Evento al presionar el Boton de Registrar Empresa
    $("#AddBtn").on("click", function (e) {
        //Inicializacion
        e.preventDefault();
        e.stopPropagation();
        $("#modal-titulo").empty().html("Registrar Empresa");
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
                        let form1= $("#FormularioEmpresa");
                        var fd = form1.serialize();
                        var data = formMap(fd);
                        
                        $.ajax({
                            type: 'POST',
                            url: GuardarEmpresa,
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
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                            }
                        });
                    
                }
            });
        }
    });

    //Evento al presionar el Boton Editar
    $("#tabla-empresa tbody").on("click",'.editar', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Empresa");
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
            url: VerEmpresa,
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
                if(data.success){ 
                    data=data.data;
                    $("#IdInput").val(data.Id);
                    $("#NombreInput").val(data.Nombre);
                    $("#RutInput").val(data.Rut);
                    $("#CorreoInput").val(data.Email);
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
                            let form1= $("#FormularioEmpresa");
                            var fd = form1.serialize();
                            var data= formMap(fd);
                            bloquear();

                            $.ajax({
                                type: 'POST',
                                url: EditarEmpresa,
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

    //Evento al presionar el Boton VER
    $("#tabla-empresa tbody").on("click",'.ver', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $("#modal-titulo").empty().html("Ver Empresa");
        $("input").val('').prop("disabled",true);
        $('.form-select').val("").trigger("change").prop("disabled",true);
        $("#AddSubmit").hide();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        
        $.ajax({
            type: 'POST',
            url: VerEmpresa,
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
        
                    $("#IdInput").val(data.Id);
                    $("#NombreInput").val(data.Nombre);
                    $("#RutInput").val(data.Rut);
                    $("#CorreoInput").val(data.Email);
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
    
    // Evento al Boton que cambia el estado de la empresa
    $("#tabla-empresa tbody").on("click", '.estado-empresa', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var userId =  $(this).closest('td').next().find('a.ver').attr('info');
        var btn = $(this);

        $.ajax({
            type: 'POST',
            url: CambiarEstadoEmpresa,
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
    
    //EVENTO DEL BOTON + DE LA TABLA Y CREA SUBTABLA
    miTabla.on('click', 'td.dt-control', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var tr = e.target.closest('tr');
        var row = miTabla.row(tr);
        var cell = row.cell(tr, 6); // Elegir bien el numero de colmuna que está el boton + (parte de la col 0)
        var boton= $(cell.node()).find('button');
        var userId= $(this).prev().find('a.editar').attr("info")

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
                url: VerCentroCosto,
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
                        row.child(format(data)).show();
                        $(".editar-acceso").tooltip();
                        $(".dar-acceso").tooltip();
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
    //Evento al presion el boton de Registrar CC en la subtabla
    $("#tabla-empresa tbody").on("click",'.registrar-cc', function(e) {
        //console.log('click')
        e.preventDefault();
        e.stopPropagation();
        $('#NombreInput2').val('');
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaError2").hide();

        validator2.resetForm();
        actualizarValidSelect2();
        //console.log($(this).attr("data-info"))
        $("#EmpresaIdInput").val($(this).attr("data-info"));
        var EmpresaIdInput= $(this).attr("data-info");
    });
    
    //Evento al presionar el Boton Submit del modal de Registrar NUEVO Centro de Costo
    const submitButton2 = document.getElementById('AddSubmit-cc');
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        //console.log('guardar')
        $("#AlertaError2").hide();
        $("#AlertaError2").empty();      
        // Validate form before submit
        if (validator2) {
            validator2.validate().then(function (status) {
                 actualizarValidSelect2();
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#Formulario-CC");
                        var fd = form1.serialize();
                        var data = formMap(fd);
                        $.ajax({
                            type: 'POST',
                            url: GuardarCentroCosto,
                            data: { 
                                    _token: csrfToken,    
                                    data: data 
                            },
                            dataType: "json",
                            //content: "application/json; charset=utf-8",
                            beforeSend: function() {
                                bloquear();
                                KTApp.showPageLoading();
                            },
                            success: function (data) {
                                if(data.success){
                                    //console.log("exito");
                                     location.reload();
                                }else{
                                    //console.log(data.error);
                                    html = '<ul><li style="">'+data.message+'</li></ul>';
                                    $("#AlertaError2").append(html);                                    
                                    $("#AlertaError2").show();
                                }
                            },
                            error: function (e) {
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

    //Evento al presionar el Boton de cambiar estado en la subtabla 
    $("#tabla-empresa tbody").on("click", '.editar-acceso', function(e){
        e.preventDefault();
        e.stopPropagation();
        //console.log("click")
        var accesoId =$(this).attr("info");
        var btn = $(this);
        //console.log(accesoId)
        
        $.ajax({
            type: 'POST',
            url: DeleteUsuarioGrupo,
            data: {
                _token: csrfToken,
                data: accesoId
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                btn.attr("data-kt-indicator", "on");
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


});