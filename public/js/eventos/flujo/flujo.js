$("#AlertaErrorFlujo").hide();
var KTDraggableMultiple = {
    init: function () {
        !(function () {
            var e = document.querySelectorAll(".draggable-zone");
            if (0 === e.length) return !1;
            var draggable =  new Draggable.Sortable(e, { 
                draggable: ".draggable:not(.select-prueba)", 
                handle: ".draggable .draggable-handle:not(.select-prueba)", 
                mirror: { appendTo: "body", 
                constrainDimensions: !0 } });
                draggable.on('sortable:stop', function (evt) {
                    var oldContainer = evt.oldContainer; // Contenedor original
                    var newContainer = evt.newContainer; // Nuevo contenedor
                    if (oldContainer !== newContainer) {                        
                        //console.log('El elemento se movió a otro contenedor');
                        var originalSource = evt.dragEvent.originalSource.querySelector('.cardcito');
                        //console.log(originalSource)
                        //var originalSource = oldContainer.querySelector('.card-header');
                        var nuevoContenedorId= newContainer.getAttribute('id');
                        if( nuevoContenedorId == 'nuevoFlujo'){
                            //console.log('mostramos el header')
                            originalSource.removeAttribute('hidden');
                            originalSource.style.display= 'block';
                        }else{
                            originalSource.setAttribute('hidden', true)
                            console.log('Escondemos el header');
                        }                        
                    }
                });
        })();

        
    },
};

KTUtil.onDOMContentLoaded(function () {
    KTDraggableMultiple.init();

  
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/   
});

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
                            message: 'Entre 3 y 20 caracteres'
                        },
                        regexp: {
                            regexp: /^[a-zñáéíóú\s]+$/i,
                            message: 'Solo letras de la A-Z '
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
    // Stepper lement
    const element = document.querySelector("#kt_stepper_flujo");
    var options = {startIndex: 1};
    // Initialize Stepper
    const stepper = new KTStepper(element,options);

    
    let lista={};
    // Handle next step
    stepper.on("kt.stepper.next", function (stepper) {        
        $("#AlertaErrorFlujoPaso2").hide();
        $("#AlertaErrorFlujoPaso2").empty();

        var paso = stepper.getCurrentStepIndex();
        if( paso ==1 ){                     
            if (validator) {
                validator.validate().then(function (status) {
                    actualizarValidSelect2();   
                    if (status == 'Valid') {                      
                        //console.log('validated!');
                        stepper.goNext(); // go next step
                    }
                });
            }
        }else if(paso == 2){
            lista = {
                Nombre : $("#NombreInput").val(),
                AreaId : $("#AreaIdInput").val(),
                GrupoId : $("#GrupoIdInput").val(),
                ordenFlujo: []
            };         
            var i=0;
            $("#nuevoFlujo .draggable").each(function (index) {    
                let info = $(this).attr("data-info");
                //PIVOT= 1 ES INICO, PIVOT= 2 INTERMEDIO, PIVOT= 3 FINAL
                ( i== 0)?pivot =0:pivot=1;

                var ordenFlujo = {
                    Nivel: i,
                    EstadoFlujoId: info,
                    Pivot: pivot                 
                }
                lista.ordenFlujo.push(ordenFlujo);
                i=i+1;
            });
            if( lista.ordenFlujo.length < 2 ){
                html = '<ul><li style="">Minimo 2 Estados</li></ul>';
                $("#AlertaErrorFlujoPaso2").append(html);                                    
                $("#AlertaErrorFlujoPaso2").show();
                return;
            }else{
                key = lista.ordenFlujo.length-1;
                lista.ordenFlujo[key].Pivot=2; //FINAL 
                stepper.goNext();
            }
                
        }    
        stepper.goNext() 
    });
    // Handle previous step
    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });

    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById('AddSubmitFlujo');
    submitButton.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#AlertaErrorFlujo").hide();
        $("#AlertaErrorFlujo").empty();
        console.log("Nuevo FLujo oyeee")
          
        if (validator) {
            validator.validate().then(function (status) {
                actualizarValidSelect2();
                         
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                    console.log('validated!');
                    console.log(lista)
                    $.ajax({
                        type: 'POST',
                        url: GuardarFlujo,
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
                                location.reload();
                                //cargarData.init(data.usuario);
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
});
