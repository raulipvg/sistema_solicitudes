// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$(document).ready(function() {
    const form = document.getElementById('FormularioPersona');
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
                    'Apellido': {
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
                    'CentroCostoId': {
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

    const form2 = document.getElementById('FormularioAccesoSistema');
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validatorAcceso = FormValidation.formValidation(
            form2,
            {
                fields: {
                    'Username': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 4,
                                max: 25,
                                message: 'Entre 4 y 25 caracteres'
                            }
                        }
                    },
                    'Password': {
                        validators: {
                            stringLength: {
                                min: 8,
                                max: 100,
                                message: 'Entre 8 y 50 caracteres'
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

     // Evento al presionar el Boton de Registrar Persona
    $("#AddBtn").on("click", function (e) {
        //Inicializacion
        e.preventDefault();
        e.stopPropagation();
        $("#modal-titulo").empty().html("Registrar Persona");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);
        //$('#EstadoIdInput').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").show();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",true);
        $("#AlertaError").hide();

        $.ajax({
            type: 'POST',
            url: VerCC,
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
                    llenarSelect2(data.option, $('#CentroCostoInput') );                                      
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
                        let form1= $("#FormularioPersona");
                        var fd = form1.serialize();
                        var data = formMap(fd);
                        
                        $.ajax({
                            type: 'POST',
                            url: GuardarPersona,
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
                                    cargarData.init(data.persona);
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
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                            }
                        });
                    
                }
            });
        }
    });

    var tr;
    var row;
    //Evento al presionar el Boton Editar
    $("#tabla-persona tbody").on("click",'.editar', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Persona");
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
            url: VerPersona,
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
                    //console.log(data)
                    dataselect=data.option; 
                    data=data.data;
                    $("#IdInput").val(data.Id);
                    $("#NombreInput").val(data.Nombre);
                    $("#ApellidoInput").val(data.Apellido);
                    $("#RutInput").val(data.Rut);
                    $('#EstadoIdInput2').val(data.Enabled).trigger("change");

                    llenarSelect2(dataselect, $('#CentroCostoInput') );  
                    $('#CentroCostoInput').val(data.CentroCostoId).trigger("change");
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
                            let form1= $("#FormularioPersona");
                            var fd = form1.serialize();
                            var data= formMap(fd);                       

                            $.ajax({
                                type: 'POST',
                                url: EditarPersona,
                                data: {
                                    _token: csrfToken,
                                    data: data
                                },
                                //content: "application/json; charset=utf-8",
                                dataType: "json",
                                beforeSend: function() {
                                    bloquear();
                                    KTApp.showPageLoading();
                                },
                                success: function (data) {                                    
                                    if(data.success){
                                        miTabla.row(row).remove();
                                        cargarData.init(data.persona);
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

    //Evento al presionar el Boton VER
    $("#tabla-persona tbody").on("click",'.ver', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $("#modal-titulo").empty().html("Ver Persona");
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
            url: VerPersona,
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
                    $("#ApellidoInput").val(data.Apellido);
                    $("#RutInput").val(data.Rut);
                    $('#EstadoIdInput2').val(data.Enabled).trigger("change");
                    $('#CentroCostoInput').val(data.CentroCostoId).trigger("change");
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
    $("#tabla-persona tbody").on("click", '.estado-persona', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var userId =  $(this).closest('td').next().find('a.ver').attr('info');
        var btn = $(this);

        $.ajax({
            type: 'POST',
            url: CambiarEstadoPersona,
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
    
    // Evento al presionar el Boton de Dar Acceso (Crear Usuario)
   $("#tabla-persona tbody").on("click", '.dar-acceso' , function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AlertaError2").hide();
        validatorAcceso.resetForm();
        actualizarValidSelect2();

        var parentDiv = $(this).closest('div');
        // Encontrar el elemento hermano anterior dentro del mismo <td>
        var siblingLink = parentDiv.parent().prev().find('.ver');
        var infoValue = siblingLink.attr('info');
        
        $("#PersonaIdInput").val(infoValue);
   });

       // Manejador al presionar el submit de Registrar
       const submitAccesoButton = document.getElementById('AddSubmit-acceso-sistema');
       submitAccesoButton.addEventListener('click', function (e) {
           // Prevent default button action
           e.preventDefault();
           e.stopPropagation();
           $("#AlertaError2").hide();
           $("#AlertaError2").empty();
           
           // Validate form before submit
           if (validatorAcceso) {
                validatorAcceso.validate().then(function (status) {
                    actualizarValidSelect2();
                   //console.log('validated!');
                   //status
                   if (status == 'Valid') {
                       // Show loading indication                       
                           let form1= $("#FormularioAccesoSistema");
                           var fd = form1.serialize();
                           var data = formMap(fd);
                           $.ajax({
                               type: 'POST',
                               url: DarAccesoPersona,
                               data: { 
                                       _token: csrfToken,    
                                       data: data 
                                   },
                               dataType: "json",
                               //content: "application/json; charset=utf-8",
                               beforeSend: function() {
                                    submitAccesoButton.setAttribute('data-kt-indicator', 'on');
                                    submitAccesoButton.disabled = true; 
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
                                   submitAccesoButton.removeAttribute('data-kt-indicator');
                                   submitAccesoButton.disabled = false;
                               }
                           });
                   }
               });
           }
       });

});