$(document).ready(function() {
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
              if(data.success){
                  data= data.data; 
                  //console.log(data);
                 // $("#NombreGrupoInput").val(data.Nombre);
                  //$("#IdGrupoInput").val(data.Id);                                   
                  for (const key in data) {                                 
                      //console.log(data[key]);
                      var btn= '<a type="button" class="btn btn-light-dark movimiento-atributo mb-2 mx-1 text-capitalize" data-id="'+data[key].Id+'" data-caract="'+data[key].Caracteristica+'" data-valor="'+data[key].ValorReferencia+'" >'+data[key].Nombre+'</a>';
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
      var MovAtributoId= $(this).attr("data-id");
      if( $(this).hasClass("active") ){
        $(this).removeClass("active");
        $('#Mov'+MovAtributoId+'').remove();
        //console.log("ta activo")
      }else{
      $(this).addClass("active");
      var Nombre = $(this).text();
      
      var Caracteristica = $(this).attr("data-caract");
      var Costo = $(this).attr("data-valor")

      var html =       `<div id="Mov`+MovAtributoId+`" class="row compuesta justify-content-center">
                            <div class="col-md-4 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="text" class="form-control text-capitalize" placeholder="Ingrese el nombre" id="NombreInput" name="Nombre" value="`+Nombre+`" disabled />
                                    <label for="NombreInput" class="form-label">Nombre</label>
                                </div>
                                <input hidden type="number" id="MovimientoAtributoIdInput" name="MovimientoAtributoId" value="`+MovAtributoId+`" />
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="CaracteristicaInput" name="Caracteristica" value="`+Caracteristica+`" />
                                    <label for="NombreInput" class="form-label">Caracteristica</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="form-floating fv-row">
                                    <input type="number" class="form-control" placeholder="Ingrese el Costo" id="CostoRealInput" name="CostoReal" value="`+Costo+`" />
                                    <label for="CostoRealInput" class="form-label">Costo</label>
                                </div>
                            </div>
                        </div>`;

      $("#contenedor-movimiento-2").append(html);
      }
      
    });
    //END::EVENTO

    //BEGIN::EVENTO BTN DE REALIZAR SOLICITUD QUE LIMPIA LOS INPUTS Y SELECT2
    $('#NuevaSolicitud').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation()
        $("#crearSolicitud input").val('').prop("disabled",false);
        $('#crearSolicitud .form-select').val("").trigger("change").prop("disabled",false);
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
                        var Caracteristica = $(this).find('[name="Caracteristica"]').val();
                        var CostoReal = $(this).find('[name="CostoReal"]').val();
                        CostoSolicitud = CostoSolicitud+ parseInt(CostoReal);

                        var obj = {
                        MovimientoAtributoId: MovimientoAtributoId,
                        Caracteristica: Caracteristica,
                        CostoReal: CostoReal
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
   

});