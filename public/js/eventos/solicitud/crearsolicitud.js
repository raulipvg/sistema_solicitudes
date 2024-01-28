$(document).ready(function() {

    if(credenciales.realizar){
        var fechaMinima = new Date();
        var fechaMaxima = new Date();
        fechaMaxima.setFullYear(fechaMaxima.getFullYear() + 1);

        let fecha = $("#Fecha").flatpickr({
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",
            mode: "range",
            locale: "es",
            minDate: fechaMinima,
            maxDate: fechaMaxima
        });
        var flatpickrInput = fecha.altInput;
        flatpickrInput.setAttribute("name", "Fecha2");

        // Función para generar las opciones del select
        function generateOptions(data, monedaId) {
            var optionsHtml = '';
            var className;            
            // Aquí puedes reemplazar el rango 1 a 10 con tus valores o lógica necesarios
            for (const key in data) {
                className= (data[key].Id == monedaId)?'selected':'';
                optionsHtml += `<option value="${data[key].Id}" ${className}>${data[key].Simbolo}</option>`;                        
            }                  
            return optionsHtml;
        }

        const form = document.getElementById('FormularioSolicitud');
        $("#AlertaError").hide();
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        const validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'PersonaId': {
                            validators: {
                                notEmpty: {
                                    message: 'Requerido'
                                },
                                digits: {
                                    message: 'Digitos'
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
                        'Fecha': {
                            validators: {
                            notEmpty: {
                                message: 'La fecha es requerida',
                            }
                            },
                        },
                        'Fecha2': {
                            validators: {
                            notEmpty: {
                                message: ' '
                            }
                            },
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

        const unoNoVacio = function(){
            return {
                validate: function(input){
                    var caracteristica = input.element.form.querySelector('[name="Caracteristica' + input.field.match(/\[\d+\]/) + '"]').value;
                    var costoReal = input.element.form.querySelector('[name="CostoReal' + input.field.match(/\[\d+\]/) + '"]').value;
                    // Verifica si al menos uno de los campos no está vacío
                    if (caracteristica.trim() !== '' || costoReal.trim() !== '') {
                        return {
                            valid: true
                        };
                    } else {
                        return {
                            valid: false,
                            message: 'Debe completar al menos uno de los campos'
                        };
                    }
                }
            }
        }

        validator.registerValidator('alMenosUnoNoVacio', unoNoVacio);

        let tipoMoneda;
        let movId= 0;
        //EVENTO SELECT2 PARA SELECCIONAR EL MOVIMIENTO Y APAREZCAN LOS MOVIMIENTOS ATRIBUTOS A SELECCIONAR
        $('#MovimientoInput').on('select2:select', function (e) {
            var data = e.params.data;
            movId= data.id;
            $("#AlertaErrorSolicitud").hide();
            $.ajax({
            type: 'POST',
            url: VerMovimientoAtributo,
            data: {
                _token: csrfToken,
                data: data.id
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                $("#contenedor-movimiento").empty();
                $("#contenedor-movimiento-2").empty();  
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                tipoMoneda = data.tipomoneda;
                if(data.success){
                    data= data.data; 
                    //console.log(data);                                                     
                    for (const key in data) {                                 
                        //console.log(data[key]);
                        var btn= `<a type="button" class="btn btn-light-dark movimiento-atributo mb-2 mx-1 text-capitalize" data-id="${data[key].Id}"  data-valor="${data[key].ValorReferencia}" data-moneda="${data[key].TipoMonedaId}" >${data[key].Nombre}</a>`;
                        $("#contenedor-movimiento").append(btn);                                     
                    } 
                    $("#elegir-movimientos").show(); 

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
                        fecha.clear();
                        $('#kt_modal_update_role').modal('toggle');
                    })
                }
                
                //blockUI.release();
                //$("#modal-update").html(data);
                //$.getScript(updateGrupo);
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
                            fecha.clear();
                            $('#kt_modal_update_role').modal('toggle');
                        });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
            });
        });

        //BEGIN::EVENTO SELECCION DE MOVIMIENTOS-ATRIBUTOS PARA LA SOLICITUD, SE CREAN FORMULARIOS
        $('#contenedor-movimiento').on('click', '.movimiento-atributo', function (e) {
        //console.log("dasd")
            var Nombre = $(this).text();
            var MovAtributoId= $(this).attr("data-id");
            var Costo = $(this).attr("data-valor");
            var MonedaId = $(this).attr("data-moneda");

            if( $(this).hasClass("active") ){
                $(this).removeClass("active");
                validator.removeField(`Caracteristica[${MovAtributoId}]`);
                validator.removeField(`CostoReal[${MovAtributoId}]`);
                validator.removeField(`TipoMonedaId[${MovAtributoId}]`);
                $(`#Mov${MovAtributoId}`).remove();
            }else{
                $(this).addClass("active");                    
                console.log(tipoMoneda)
                var html =       `<div id="Mov${MovAtributoId}" class="col-md-10 row compuesta justify-content-center">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-floating fv-row">
                                                <input type="text" class="form-control text-capitalize input-size" placeholder="Ingrese el nombre" id="NombreInput[${MovAtributoId}]" name="Nombre" value="${Nombre}" disabled />
                                                <label for="NombreInput[${MovAtributoId}]" class="form-label">Nombre</label>
                                            </div>
                                            <input hidden type="number" id="MovimientoAtributoIdInput[${MovAtributoId}]" name="MovimientoAtributoId" value="${MovAtributoId}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-floating fv-row">
                                                <input type="text" class="form-control input-size" placeholder="Ingrese el detalle" id="Caracteristica[${MovAtributoId}]" name="Caracteristica[${MovAtributoId}]" value="" />
                                                <label for="Caracteristica[${MovAtributoId}]" class="form-label">Detalle</label>
                                            </div>
                                        </div>                                    
                                        <div class="col-md-2 mb-2">
                                            <div class="form-floating fv-row">
                                                <select id="Select${MovAtributoId}"  name="TipoMonedaId[${MovAtributoId}]" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                                    ${generateOptions(tipoMoneda,MonedaId)}                                               
                                                </select>
                                                <label for="Select${MovAtributoId}" class="form-label">Moneda</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-floating fv-row">
                                                <input class="form-control costos-reales input-size" placeholder="Ingrese el Costo" id="CostoReal[${MovAtributoId}]" inputmode="decimal" style="text-align: right;" name="CostoReal[${MovAtributoId}]" value="${Costo}" />
                                                <label for="CostoReal[${MovAtributoId}]" class="form-label">Costo</label>
                                            </div>
                                        </div>
                                    </div>`;
                
                $("#contenedor-movimiento-2").append(html);
                
                validaCaract = {
                    validators:{
                        regexp: {
                            regexp: /^[a-zA-Z0-9 -ñáéíóú\s]+$/,
                            message: 'Solo letras y números'
                        },
                        alMenosUnoNoVacio: {
                            message: 'Debe completar al menos uno de los campos'
                        }
                    }
                };

                validaCosto = {
                    validators:{
                        digits: {
                            message: 'Digitos'
                        },
                        alMenosUnoNoVacio: {
                            message: ' '
                        }
                    }
                };

                validaMoneda = {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        digits: {
                            message: 'Digitos'
                        }
                    }
                };
                validator.addField(`Caracteristica[${MovAtributoId}]`, validaCaract);
                validator.addField( `CostoReal[${MovAtributoId}]`, validaCosto);
                validator.addField( `TipoMonedaId[${MovAtributoId}]`, validaMoneda);
                //console.log(validator.fields)
                Inputmask("decimal", {
                    alias: 'numeric',
                    rightAlignNumerics: false,
                    numericInput: true,
                    radixPoint: ',',
                    groupSeparator: '.',
                    autoGroup: true,
                    digits: 0,
                    autoUnmask: true,
                    onBeforeMask: function (value, opts) {
                        // Convierte el valor a un formato adecuado con puntos como separadores de miles
                        return value.toLocaleString();
                    }
                }).mask("#contenedor-movimiento-2 .costos-reales");

                $("#contenedor-movimiento-2 .form-select").each(function() {
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).select2('destroy');
                    }
                });
                $("#contenedor-movimiento-2 .form-select").select2({
                    minimumResultsForSearch: Infinity
                });
            }
        
        });
        //END::EVENTO

        //BEGIN::EVENTO BTN DE REALIZAR SOLICITUD QUE LIMPIA LOS INPUTS Y SELECT2
        $('#NuevaSolicitud').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $("#crearSolicitud input").val('').prop("disabled",false);
            $('#crearSolicitud .form-select').val("").trigger("change").prop("disabled",false);
            //fecha.clear();
            validator.resetForm();
            actualizarValidSelect2();
            $("#AlertaErrorSolicitud").hide();
            $("#AlertaErrorSolicitud").empty();
            $("#contenedor-movimiento").empty();
            $("#contenedor-movimiento-2").empty();
            $("#elegir-movimientos").hide();
        });
        //END::EVENTO

        //BEGIN::EVENTO QUE CAPTURA LA DATA Y LA ENVIA AL CONTROLADOR
        $('#AddSubmitSolicitud').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();     
            $("#AlertaErrorSolicitud").hide();
            $("#AlertaErrorSolicitud").empty();
        
            // Validate form before submit
            if (validator) {
                    validator.validate().then(function (status) {
                        actualizarValidSelect2();
                        //console.log('validated!');
                        //status
                        if (status == 'Valid') {
                        
                            let fechasSeleccionadas = fecha.selectedDates;                                        
                            fechaDesde = formatearFecha(fechasSeleccionadas[0]);
                            fechaHasta = formatearFecha(fechasSeleccionadas[1]);
                            data = {
                                compuesta: [],        
                                solicitud: {
                                PersonaId: $("#PersonaIdInput").val(),
                                CentroCostoId: $("#CentroCostoIdInput").val(),
                                CostoSolicitud: 0,
                                FechaDesde: fechaDesde,
                                FechaHasta: fechaHasta,
                                ConsolidadoMesId: 1 //ARREGLAR PROXIMO SPRINT
                                },
                                movimiento: movId
                            };
                            var CostoSolicitud= 0;
                            var aux=0
                            $("#contenedor-movimiento-2 .compuesta").each(function (index) {
                                
                                var MovimientoAtributoId =  $(this).find('[name="MovimientoAtributoId"]').val();
                                var Caracteristica = $(this).find('[name^="Caracteristica"]').val();
                                var CostoReal = $(this).find('[name^="CostoReal"]').val();
                                var TipoMonedaId = $(this).find('[name^="TipoMonedaId"]').val();
                                CostoSolicitud = CostoSolicitud+ parseInt(CostoReal);

                                var obj = {
                                MovimientoAtributoId: MovimientoAtributoId,
                                Caracteristica: Caracteristica,
                                CostoReal: CostoReal,
                                TipoMonedaId: TipoMonedaId
                                }
                                data.compuesta.push(obj);
                                aux= aux+1;
                            });
                            //VALIDADOR DE CONDICION
                            if(aux== 0){
                                html = '<ul><li style="">Debe elegir atributos para realizar la solicitud</li></ul>';
                                $("#AlertaErrorSolicitud").append(html);                                    
                                $("#AlertaErrorSolicitud").show();
                                return;
                            }
                            data.solicitud.CostoSolicitud = CostoSolicitud;

                            //console.log(data)
                            $.ajax({
                                type: 'POST',
                                url: RealizarSolicitud,
                                data: {
                                    _token: csrfToken,
                                    data: data
                                },
                                //content: "application/json; charset=utf-8",
                                dataType: "json",
                                beforeSend: function() {
                                    //$("#contenedor-movimiento").empty();  
                                    bloquear();
                                    KTApp.showPageLoading();
                                },
                                success: function (data) {
                                    if(data.success){
                                        data= data.data;
                                        //console.log(data);
                                        cargarDataActiva.init(data);
                                        $('#crearSolicitud').modal('toggle');
                                        fecha.clear();
                                        toastr.success("Solicitud Realizada!");
                                    }else{
                                        Swal.fire({
                                            text: "Error al realizar la solicitud",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "OK",
                                            customClass: {
                                                confirmButton: "btn btn-danger btn-cerrar"
                                            }
                                        });
                                        $(".btn-cerrar").on("click", function () {
                                            //console.log("Error");
                                            fecha.clear();
                                            $('#crearSolicitud').modal('toggle');
                                        })
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
                                                fecha.clear();
                                                $('#crearSolicitud').modal('toggle');
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
        //END::EVENTO

        //BEGIN::EVENTO PARA CARGAR SELECT2 DE CENTRO DE COSTO SEGÚN PERSONA
        $('#PersonaIdInput').on('select2:select', function(e){
            bloquear();
            KTApp.showPageLoading();
            var ccId = $(e.params.data.element).attr('info');

            $('#CentroCostoIdInput').val(ccId).trigger('change.select2');

            KTApp.hidePageLoading();
            loadingEl.remove();
        })
        //END::EVENTO

        //BEGIN::EVENTO PARA LIMPIAR CAMPO DE FECHA SIN PASAR POR VALIDATOR
        $(".cerrar").on("click", function(){
            fecha.clear();
        })
        //BEGIN::EVENTO
    }
});