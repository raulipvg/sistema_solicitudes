$(document).ready(function() {

    if(credenciales.realizar){
        var fechaMinima = new Date();
        var fechaMaxima = new Date();
        fechaMaxima.setFullYear(fechaMaxima.getFullYear() + 1);
        
        //$("#contFecha").hide();
        /*
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
        */

        // Función para generar las opciones del select
        function generateOptions(data, monedaId) {
            var optionsHtml = ``;
            var className;            
            for (const key in data) {
                className= (data[key].Id == monedaId)?'selected':'';
                optionsHtml += `<option value="${data[key].Id}" ${className}>${data[key].Simbolo}</option>`;                        
            }                  
            return optionsHtml;
        }

        const form = document.getElementById('FormularioSolicitud');
        let validator;
        $("#AlertaError").hide();
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        function initializeValidator(form) { 
            return FormValidation.formValidation(
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
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: 'is-invalid',
                            eleValidClass: 'is-valid'
                        })
                    },
                }
            )
        }
        function destroyValidator(validator) {
            if (validator) {
                validator.destroy();
            }
        }
       

        let tipoMoneda;
        let movId= 0;
        let fecha;
        let movimientoAtributos;
        let consolidadoMesId= 0;
        //EVENTO SELECT2 PARA SELECCIONAR EL MOVIMIENTO Y APAREZCAN LOS MOVIMIENTOS ATRIBUTOS A SELECCIONAR
        $('#MovimientoInput').on('select2:select', function (e) {
            var data = e.params.data;
            //var config =  data.element.getAttribute('data-config');
            //console.log(data);
            //console.log(config);
            movId= data.id;
            $("#AlertaErrorSolicitud").hide();

            //Configuracion de la Fecha
            /*
            if(config == 1){ //Año
                fecha = flatpickr("#Fecha", {
                    altInput: true,
                    altFormat: "Y", // Formato de visualización solo para el año
                    dateFormat: "Y", // Formato de fecha para el valor del campo, solo para el año
                    mode: "single", // Cambia a modo "single" para mostrar solo un campo de fecha
                    locale: "es",
                    minDate: "2022",
                    maxDate: "2024"
                });
                $("#contFecha").show();

            }else if( config == 2){ //Mes
                fecha = $("#Fecha").flatpickr({
                    altInput: true,
                    altFormat: "F, Y",
                    dateFormat: "Y-m-d",
                    mode: "single",
                    locale: "es",
                    minDate: fechaMinima,
                    maxDate: fechaMaxima
                });
                var flatpickrInput = fecha.altInput;
                flatpickrInput.setAttribute("name", "Fecha2");
                $("#contFecha").show();

            }else if( config == 3){ //Rango
                fecha = $("#Fecha").flatpickr({
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
                $("#contFecha").show();
            }
            */
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
                consolidadoMesId = data.consolidado;
                if(data.success){
                    data= data.data;
                    movimientoAtributos= data;                                                                         
                    for (const key in data) {                                 
                        //console.log(data[key]);
                        var btn= `<a type="button" class="btn btn-light-dark movimiento-atributo mb-2 mx-1 text-capitalize" 
                                    data-id="${data[key].Id}"  data-valor="${data[key].ValorReferencia}" data-moneda="${data[key].TipoMonedaId}">
                                    ${data[key].Nombre}</a>`;
                        $("#contenedor-movimiento").append(btn);
                        movimientoAtributos[key].atributoTipo =JSON.parse(movimientoAtributos[key].atributoTipo)                                     
                    } 
                    $("#elegir-movimientos").show(); 
                    //console.log(movimientoAtributos); 

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
                        //fecha.clear();
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
                            //fecha.clear();
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
    
            if( $(this).hasClass("active") ){
                $(this).removeClass("active");
                if (validator.fields[`Descripcion[${MovAtributoId}]`]) {
                    validator.removeField(`Descripcion[${MovAtributoId}]`);
                }                
                if (validator.fields[`CostoReal[${MovAtributoId}]`]) {
                    validator.removeField(`CostoReal[${MovAtributoId}]`);
                }                
                if (validator.fields[`TipoMonedaId[${MovAtributoId}]`]) {
                    validator.removeField(`TipoMonedaId[${MovAtributoId}]`);
                }                
                if (validator.fields[`Cantidad[${MovAtributoId}]`]) {
                    validator.removeField(`Cantidad[${MovAtributoId}]`);
                }                
                if (validator.fields[`Fecha[${MovAtributoId}]`]) {
                    validator.removeField(`Fecha[${MovAtributoId}]`);
                }
                $(`#Mov${MovAtributoId}`).remove();
            }else{                
                $(this).addClass("active");  
                MovAtributo= buscarMovimientoAtributo(movimientoAtributos, MovAtributoId);
                //MovAtributo.atributoTipo= JSON.parse(MovAtributo.atributoTipo);
                //console.log(MovAtributo);                 
                //console.log(tipoMoneda)
                var html =       `<div id="Mov${MovAtributoId}" class="d-flex flex-row compuesta mb-1 border-bottom">
                                        <div class="pb-1">
                                            <div class="form-floating fv-row">
                                                <input type="text" class="form-control form-control-solid text-capitalize input-size" placeholder="Ingrese el nombre" id="NombreInput[${MovAtributoId}]" name="Nombre" value="${MovAtributo.Nombre}" disabled />
                                                <label for="NombreInput[${MovAtributoId}]" class="form-label">Nombre</label>
                                            </div>
                                            <input hidden type="number" id="MovimientoAtributoIdInput[${MovAtributoId}]" name="MovimientoAtributoId" value="${MovAtributoId}" />
                                        </div>
                                        ${generarInputAtributoTipo(MovAtributo)}                                        
                                    </div>`;
                
                $("#contenedor-movimiento-2").append(html);
                selector= '#Fecha\\['+MovAtributoId+'\\]';

                MovAtributo.atributoTipo.find( function (item) {
                    if(item.TipoId === 1){ //Costo + Moneda
                        //console.log('Tiene tipo 1');
                        validacionesForm(MovAtributoId,1)
                    }
                    if(item.TipoId ==2){ // Tiene Cantidad
                        //console.log('Tiene tipo 2');
                        validacionesForm(MovAtributoId,2)
                    }
                    if(item.TipoId ===3){ // Tiene Descripcion
                        //console.log('Tiene tipo 3');
                        validacionesForm(MovAtributoId,3)
                    }

                    if(item.TipoId ===4){ //MES
                        fecha = $(selector).flatpickr({
                            altInput: true,
                            altFormat: "F, Y",
                            dateFormat: "Y-m-d",
                            mode: "single",
                            locale: "es",
                            minDate: fechaMinima,
                            maxDate: fechaMaxima,
                            required: true
                        });
                        validacionesForm(MovAtributoId,4)
                        //console.log("4");
                    }else if(item.TipoId ===5){ // RANGO
                        fecha = $(selector).flatpickr({
                            altInput: true,
                            altFormat: "j F, Y",
                            dateFormat: "Y-m-d",
                            mode: "range",
                            locale: "es",
                            minDate: fechaMinima,
                            maxDate: fechaMaxima,
                            required: true
                        });
                        validacionesForm(MovAtributoId,5)
                        //console.log("5");
                    }else if(item.TipoId === 6){ // AÑO
                        fecha = flatpickr(selector, {
                            altInput: true,
                            altFormat: "Y", // Formato de visualización solo para el año
                            dateFormat: "Y", // Formato de fecha para el valor del campo, solo para el año
                            mode: "single", // Cambia a modo "single" para mostrar solo un campo de fecha
                            locale: "es",
                            minDate: fechaMinima,
                            maxDate: fechaMaxima,
                            required: true
                        });
                        validacionesForm(MovAtributoId,6)
                        //console.log("6");
                    }


                })

                //validacionesForm(MovAtributoId);           
                //var flatpickrInput = fecha.altInput;
                //flatpickrInput.setAttribute("name", "Fecha2");          
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
        
        function buscarMovimientoAtributo(data, Id){
            return data.find( function (item) {
                return item.Id == Id;
            })
        }

        function generarInputAtributoTipo(MovAtributo){
            var html=``;
            MovAtributo.atributoTipo.forEach(element => {                
                switch (element.TipoId){
                    case 1: //Moneda
                    html= html +`<div class="">
                                            <div class="form-floating fv-row">
                                                <select id="Select${MovAtributo.Id}"  name="TipoMonedaId[${MovAtributo.Id}]" class="form-select form-select-transparent input-size" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                                    ${generateOptions(tipoMoneda,MovAtributo.TipoMonedaId)}                                               
                                                </select>
                                                <label for="Select${MovAtributo.Id}" class="form-label">Moneda</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating fv-row">
                                                <input class="form-control form-control-transparent costos-reales input-size pe-10" placeholder="Ingrese el Costo" id="CostoReal[${MovAtributo.Id}]" inputmode="decimal" style="text-align: right;" name="CostoReal[${MovAtributo.Id}]" value="${MovAtributo.ValorReferencia}" />
                                                <label for="CostoReal[${MovAtributo.Id}]" class="form-label">Costo</label>
                                            </div>
                                        </div>`;
                        break;
                    case 2: // Cantidad
                    html= html +`<div class="col-md-1">
                                    <div class="form-floating fv-row">
                                        <input class="form-control form-control-transparent costos-reales input-size pe-6" placeholder="Ingrese la Cantidad" id="Cantidad[${MovAtributo.Id}]" type="number" style="text-align: right;" name="Cantidad[${MovAtributo.Id}]" value="1" />
                                        <label for="Cantidad[${MovAtributo.Id}]" class="form-label">Cant.</label>
                                    </div>
                                </div>`;
                        break;
                    case 3: // Descripcion
                        html = html + `<div class="col">
                                            <div class="form-floating fv-row">
                                                <input type="text" class="form-control form-control-transparent input-size" placeholder="Ingrese el detalle" id="Descripcion[${MovAtributo.Id}]" name="Descripcion[${MovAtributo.Id}]" value="" />
                                                <label for="Descripcion[${MovAtributo.Id}]" class="form-label">Detalle</label>
                                            </div>
                                        </div> `;
                        break;
                    case 4: // Mes
                        html = html +`<div class="col">
                                        <div class="form-floating fv-row">
                                            <input id="Fecha[${MovAtributo.Id}]" class="form-control form-control-transparent input-size" name="Fecha[${MovAtributo.Id}]" placeholder="Pick date range"  />
                                            <label for="Fecha[${MovAtributo.Id}]" class="form-label">Mes</label>
                                        </div>
                                    </div>`;
                        break;
                    case 5: // Rango
                        html = html +`<div class="col">
                                        <div class="form-floating fv-row">
                                            <input id="Fecha[${MovAtributo.Id}]" class="form-control form-control-transparent input-size" name="Fecha[${MovAtributo.Id}]" placeholder="Pick date range"  />
                                            <label for="Fecha[${MovAtributo.Id}]" class="form-label">Rango de Fechas</label>
                                        </div>
                                    </div>`;
                        break;
                    case 6: // Año
                        html = html +`<div class="col">
                                        <div class="form-floating fv-row">
                                            <input id="Fecha[${MovAtributo.Id}]" class="form-control form-control-transparent input-size" name="Fecha[${MovAtributo.Id}]" placeholder="Pick date range"  />
                                            <label for="Fecha[${MovAtributo.Id}]" class="form-label">Año</label>
                                        </div>
                                    </div>`;
                        break;
                    case 7: // Sin Fecha
                        break;
                }
            });
            return html;
            
        }

        function validacionesForm(MovAtributoId,tipoId){

            if(tipoId ===1){ //COSTO + MONEDA

                //Antiguo, cuando era DESCRIPCION O COSTO
                /*validaCosto = {
                    validators:{
                        digits: {
                            message: 'Digitos',
                        },
                        callback:{
                            callback : function(input){
                                var descripcion = input.element.form.querySelector('[name="Descripcion' + input.field.match(/\[\d+\]/) + '"]').value;
                                var costoReal = input.element.form.querySelector('[name="CostoReal' + input.field.match(/\[\d+\]/) + '"]').value;
                                // Verifica si al menos uno de los campos no está vacío
                                if (descripcion.trim() == '' && costoReal.trim() == '') {
                                    
                                    return {
                                        valid: false,
                                        message: 'Debe completar costo y/o detalle'
                                    }
                                } else if(descripcion.trim() == '' && costoReal.trim() <=0){            //característica vacía y costo real cero (o menor)
                                    
                                    return {
                                        valid: false,
                                        message: 'El costo debe ser mayor a 0'
                                    };
                                }
                                return {
                                    valid: true
                                };
                            }
                        }
                    }
                };
                */
    
                validaCosto = {
                    validators:{
                        notEmpty: {
                            message: 'Requerido'
                        },
                        digits: {
                            message: 'Digitos',
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
                validator.addField(`CostoReal[${MovAtributoId}]`, validaCosto);
                validator.addField(`TipoMonedaId[${MovAtributoId}]`, validaMoneda);
            }else if(tipoId ===2){ // CANTIDAD
                
                validaCantidad = {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        digits: {
                            message: 'Digitos'
                        }
                    }
                };
                validator.addField(`Cantidad[${MovAtributoId}]`, validaCantidad);
            }else if(tipoId ===3){ // DESCRIPCION
                /*Antiguo
                validaDetalle = {
                    validators:{
                        regexp: {
                            regexp: /^[a-zA-Z0-9 -ñáéíóú\s]+$/,
                            message: 'Solo letras y números'
                        },
                        callback: {
                            callback: function(input){
                                console.log('hola')
                                var descripcion = input.element.form.querySelector('[name="Descripcion' + input.field.match(/\[\d+\]/) + '"]').value;
                                var costoReal = input.element.form.querySelector('[name="CostoReal' + input.field.match(/\[\d+\]/) + '"]').value;
                                // Verifica si al menos uno de los campos no está vacío
                                if (descripcion.trim() == '' && costoReal.trim() == '') {
                                    return {
                                        valid: false,
                                        message: 'Debe completar costo y/o detalle'
                                    }
                                }
                                return {
                                    valid: true
                                };
                            
                            }
                        }
                    }
                };
                */
                validaDetalle = {
                    validators:{
                        notEmpty: {
                            message: 'Requerido'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9 -ñáéíóú\s]+$/,
                            message: 'Solo letras y números'
                        },
                    }
                };
                validator.addField(`Descripcion[${MovAtributoId}]`, validaDetalle);
            }else if(tipoId >= 4 && tipoId < 7){ // FECHAS
                validaFecha = {
                    validators:{
                        notEmpty: {
                            message: 'Requerido'
                        }
                    }
                };
                validator.addField(`Fecha[${MovAtributoId}]`, validaFecha);
            }

            
            

        }
        //BEGIN::EVENTO BTN DE REALIZAR SOLICITUD QUE LIMPIA LOS INPUTS Y SELECT2
        $('#NuevaSolicitud').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            //destroyValidator(validator);
            validator = initializeValidator(form);
            validator.resetForm();
            $("#crearSolicitud input").val('').prop("disabled",false);
            $('#crearSolicitud .form-select').val("").trigger("change").prop("disabled",false);
            actualizarValidSelect2();
            $("#AlertaErrorSolicitud").hide();
            $("#AlertaErrorSolicitud").empty();
            $("#contenedor-movimiento").empty();
            $("#contenedor-movimiento-2").empty();
            $("#elegir-movimientos").hide();
        });
        //END::EVENTO

        //BEGIN::EVENTO QUE CAPTURA LA DATA Y LA ENVIA AL CONTROLADOR
        $('#FormularioSolicitud').submit( function (e) {
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
                        
                            //let fechasSeleccionadas = fecha.selectedDates;                                        
                            //fechaDesde = formatearFecha(fechasSeleccionadas[0]);
                            //fechaHasta = formatearFecha(fechasSeleccionadas[1]);
                            data = {
                                compuesta: [],        
                                solicitud: {
                                PersonaId: $("#PersonaIdInput").val(),
                                CentroCostoId: $("#CentroCostoIdInput").val(),
                                CostoSolicitud: 0,
                                //FechaDesde: fechaDesde,
                                //FechaHasta: fechaHasta,
                                ConsolidadoMesId: consolidadoMesId //ARREGLAR PROXIMO SPRINT
                                },
                                movimiento: movId
                            };
                            //var CostoSolicitud= 0;
                            var aux=0
                            $("#contenedor-movimiento-2 .compuesta").each(function (index) {
                                
                                var MovimientoAtributoId =  $(this).find('[name="MovimientoAtributoId"]').val();
                                var CostoReal = $(this).find('[name^="CostoReal"]').val();
                                var TipoMonedaId = $(this).find('[name^="TipoMonedaId"]').val();
                                var Descripcion = $(this).find('[name^="Descripcion"]').val();
                                var Cantidad = $(this).find('[name^="Cantidad"]').val();
                                selector = '#Fecha\\['+MovimientoAtributoId+'\\]';
                                var Fecha = $(selector);

                                
                                if(Fecha.length > 0){
                                    Fecha1 = formatearFecha(Fecha[0]._flatpickr.selectedDates[0]);
                                    Fecha2 = formatearFecha(Fecha[0]._flatpickr.selectedDates[1]?Fecha[0]._flatpickr.selectedDates[1]:false);
                                    if(!Fecha2){
                                        MovAtributoAux= buscarMovimientoAtributo(movimientoAtributos, MovimientoAtributoId);
                                        var atributoTipoMes = MovAtributoAux.atributoTipo.find(item => item.TipoId === 4) !== undefined;
                                        var atributoTipoAno = MovAtributoAux.atributoTipo.find(item => item.TipoId === 6) !== undefined;
                                        if(atributoTipoMes){
                                            var year = Fecha[0]._flatpickr.selectedDates[0].getFullYear();
                                                var month = Fecha[0]._flatpickr.selectedDates[0].getMonth() + 1; // Se suma 1 porque los meses en JavaScript van de 0 a 11
                                                // Obtener el último día del mes sumando 1 mes y luego retrocediendo 1 día
                                                var ultimoDia = new Date(year, month, 0);
                                                Fecha1 = formatearFecha(new Date(year, month-1, 1));
                                                Fecha2 = formatearFecha(ultimoDia);
                                                //console.log("4");
                                        }else if(atributoTipoAno){
                                                // Obtener el año y mes de la fecha dada
                                                var year = Fecha[0]._flatpickr.selectedDates[0].getFullYear();
                                                // Obtener el último día del mes sumando 1 mes y luego retrocediendo 1 día
                                                var ultimoDia = new Date(year, 11, 31);
                                                Fecha1 = formatearFecha(new Date(year, 0, 1));
                                                Fecha2 = formatearFecha(ultimoDia);
                                                //console.log("6")
                                        }
                                    }
                                    
                                }else{
                                    Fecha1 = null;
                                    Fecha2 = null;
                                }
                                //CostoSolicitud = CostoSolicitud+ parseInt(CostoReal);

                                var obj = {
                                    MovimientoAtributoId: MovimientoAtributoId,
                                    Descripcion: Descripcion,
                                    CostoReal: CostoReal,
                                    TipoMonedaId: TipoMonedaId,
                                    Cantidad: Cantidad,
                                    Fecha1: Fecha1,
                                    Fecha2: Fecha2
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
                            //data.solicitud.CostoSolicitud = CostoSolicitud;

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
                                        //fecha.clear();
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
                                            //fecha.clear();
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
                                                //fecha.clear();
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
           //fecha.clear();
        })
        //BEGIN::EVENTO
    }
});