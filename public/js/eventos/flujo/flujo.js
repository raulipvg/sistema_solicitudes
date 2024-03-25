$(document).ready(function() {

    const form = document.getElementById('FormularioFlujo');
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
                            message: 'Entre 3 y 150 caracteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9$%-_.!#*(),ñáéíóú\s]+$/,
                            message: 'Solo letras, numeros y simbolos '
                        }
                    }
                },
                'AreaId': {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        digits: {
                            message: 'Digitos'
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

    miTablaFlujo.on("click",'.estado-flujo', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Cambio Estado")

        tr = e.target.closest('tr');
        row = miTablaFlujo.row(tr).data();
        const flujoId =  row[0];
        var btn = $(this);

            $.ajax({
                type: 'POST',
                url: CambiarEstadoFlujo,
                data: {
                    _token: csrfToken,
                    data: flujoId},
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

    var row;
    miTablaFlujo.on("click",'.editar', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $("#modal-titulo-flujo").empty().html("Editar Flujo");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#IdFlujoInput").prop("disabled",false);
        $("#AlertaErrorFlujo").hide();
        $("#AlertaErrorFlujoPaso2").hide();
        $("#EditSubmitFlujo").show();      
        $("#nuevoFlujo").empty()

        tr = e.target.closest('tr');
        row = miTablaFlujo.row(tr).data();
        validator.resetForm();
        actualizarValidSelect2();

        let id = Number(row[0]);
        
        $.ajax({
            type: 'POST',
            url: VerFlujoId,
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
                console.log(data);
                //blockUI.release();
                if(data.success){         ;           
                    llenarSelect2(data.areas, $('#AreaIdInput'));  
                    llenarSelect2(data.grupos, $('#GrupoIdInput'));
                    grupos=data.grupos;             
                    data=data.data;
                    
                    $("#IdFlujoInput").val(data.Id);
                    $("#NombreFlujoInput").val(data.Nombre);                
                    $('#EstadoIdFlujoInput').val(data.Enabled).trigger("change");
                    $('#AreaIdInput').val(data.AreaId).trigger("change");
                    $('#GrupoIdInput').val(data.GrupoId).trigger("change");

                    data.Etapa = JSON.parse(data.Etapa);
                    data.Etapa.forEach( (item,index,array) => {
                        html = `
                            <div class="etapas mx-2" data-info="${item.OrdenFlujoId }">
                                <div class="card bg-dark align-items-center align-self-center justify-content-center px-2">
                                    <div class="d-flex flex-column">
                                        <div class="card-estado py-1">
                                            <select name="Enabled" class="form-select form-select-sm form-select-solid select2-negro" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" data-dropdown-parent="#editar-flujo">
                                                <option></option>
                                                ${llenarSeleccionar(grupos,item.GrupoId )}
                                            </select>
                                        </div>
                                        <div class="min-h-40px d-flex align-items-center justify-content-center">
                                            <span class="text-white fw-semibold fs-6 text-uppercase">${ item.Nombre }</span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            ${(index != array.length-1)? `->`:``}
                            `;
                        $("#nuevoFlujo").append(html);
                    });
                    $('.select2-negro').select2();
                    
                }else{
                    Swal.fire({
                        text: "Error al Cargar el Flujo",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        },
                    }).then((result) => {
                        // Verificar si el botón de confirmación fue presionado
                        if (result.isConfirmed) {
                            // lógica aquí al presionar OK;
                            $('#editar-flujo').modal('toggle');
                        }
                    });

                }
            },
            error: function () {;
                Swal.fire({
                    text: "Error al Cargar el Flujo",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    },
                }).then((result) => {
                    // Verificar si el botón de confirmación fue presionado
                    if (result.isConfirmed) {
                        // lógica aquí al presionar OK;
                        $('#editar-flujo').modal('toggle');
                    }
                });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });


    });

    miTablaFlujo.on("click",'.ver', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $("#modal-titulo-flujo").empty().html("Ver Flujo");
        $("input").val('').prop("disabled",true);
        $('.form-select').val("").trigger("change").prop("disabled",true);

        $("#IdFlujoInput").prop("disabled",false);
        $("#AlertaErrorFlujo").hide();
        $("#AlertaErrorFlujoPaso2").hide();
        $("#EditSubmitFlujo").hide();        
        $("#nuevoFlujo").empty()

        tr = e.target.closest('tr');
        row = miTablaFlujo.row(tr).data();
        validator.resetForm();
        actualizarValidSelect2();

        let id = Number(row[0]);
        
        $.ajax({
            type: 'POST',
            url: VerFlujoId,
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
                console.log(data);
                //blockUI.release();
                if(data.success){         ;           
                    llenarSelect2(data.areas, $('#AreaIdInput'));  
                    llenarSelect2(data.grupos, $('#GrupoIdInput'));
                    grupos=data.grupos;             
                    data=data.data;
                    
                    $("#IdFlujoInput").val(data.Id);
                    $("#NombreFlujoInput").val(data.Nombre);                
                    $('#EstadoIdFlujoInput').val(data.Enabled).trigger("change");
                    $('#AreaIdInput').val(data.AreaId).trigger("change");
                    $('#GrupoIdInput').val(data.GrupoId).trigger("change");

                    data.Etapa = JSON.parse(data.Etapa);
                    data.Etapa.forEach( (item,index,array) => {
                        html = `
                            <div class="etapas mx-2" data-info="${item.OrdenFlujoId }">
                                <div class="card bg-dark align-items-center align-self-center justify-content-center px-2">
                                    <div class="d-flex flex-column">
                                        <div class="card-estado py-1">
                                            <select name="Enabled" disabled class="form-select form-select-sm form-select-solid select2-negro" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" data-dropdown-parent="#editar-flujo">
                                                <option>${grupos.find( grupo => grupo.Id === item.GrupoId).Nombre.toUpperCase()}</option>
                                            </select>
                                        </div>
                                        <div class="min-h-40px d-flex align-items-center justify-content-center">
                                            <span class="text-white fw-semibold fs-6 text-uppercase">${ item.Nombre }</span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            ${(index != array.length-1)? `->`:``}
                            `;
                        $("#nuevoFlujo").append(html);
                    });
                    //$('.select2-negro').select2();
                }else{
                    Swal.fire({
                        text: "Error al Cargar el Flujo",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        },
                    }).then((result) => {
                        // Verificar si el botón de confirmación fue presionado
                        if (result.isConfirmed) {
                            // lógica aquí al presionar OK;
                            $('#editar-flujo').modal('toggle');
                        }
                    });

                }
            },
            error: function () {;
                Swal.fire({
                    text: "Error al Cargar el Flujo",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    },
                }).then((result) => {
                    // Verificar si el botón de confirmación fue presionado
                    if (result.isConfirmed) {
                        // lógica aquí al presionar OK;
                        $('#editar-flujo').modal('toggle');
                    }
                });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });
    });

    const submitButton = document.getElementById('EditSubmitFlujo');
    submitButton.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('editar flujo');

        $("#AlertaErrorFlujo").hide();
        $("#AlertaErrorFlujoPaso2").hide(); 

        if (validator) {
            validator.validate().then(function (status) {
                actualizarValidSelect2();                         
                //status
                if (status == 'Valid') {
                    //Show loading indication                       
                    //console.log('validated!');
                    //console.log(lista)

                    lista = {
                        Id: $("#IdFlujoInput").val(),
                        Nombre : $("#NombreFlujoInput").val(),
                        AreaId : $("#AreaIdInput").val(),
                        GrupoId : $("#GrupoIdInput").val(),
                        Enabled: $("#EstadoIdFlujoInput").val(),
                        ordenFlujo: []
                    }; 

                    $("#nuevoFlujo .etapas").each(function (index) {
                        let info = $(this).attr("data-info");
                        let select = $(this).find('select[name="Enabled"]');

                        var ordenFlujo={
                            Id: $(this).attr("data-info"),
                            GrupoId: $(this).find('select[name="Enabled"]').val()
                        };
                        lista.ordenFlujo.push(ordenFlujo);
                    });
                    $.ajax({
                        type: 'POST',
                        url: EditarFlujo,
                        data: { 
                                _token: csrfToken,    
                                data: lista
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
                                //console.log(data);
                                miTablaFlujo.row(row).remove();
                                cargarDataFlujo.init(data.data);
                                $('#editar-flujo').modal('toggle');
                            }else{
                                //console.log(data.error);
                                html = '<ul><li style="">'+data.message+'</li></ul>';
                                $("#AlertaErrorFlujo").append(html);                                    
                                $("#AlertAlertaErrorFlujoaError").show();
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

    function llenarSeleccionar(grupos,id){
        let optionsHTML = '';
        grupos.forEach(group => {
            optionsHTML += `<option value="${group.Id}" ${ (group.Id == id)?`selected`:``}>${(group.Nombre).toUpperCase()}</option>`;
        });
        return optionsHTML;
    }

});