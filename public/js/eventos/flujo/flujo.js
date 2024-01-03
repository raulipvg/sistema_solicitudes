var KTDraggableMultiple = {
    init: function () {
        !(function () {
            var e = document.querySelectorAll(".draggable-zone");
            if (0 === e.length) return !1;
            new Draggable.Sortable(e, { 
                draggable: ".draggable", 
                handle: ".draggable .draggable-handle", 
                mirror: { appendTo: "body", 
                constrainDimensions: !0 } });
        })();
    },
};
KTUtil.onDOMContentLoaded(function () {
    KTDraggableMultiple.init();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/   
});
$("#AlertaErrorFlujo").hide();
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

    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById('AddSubmitFlujo');
    submitButton.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#AlertaErrorFlujo").hide();
        $("#AlertaErrorFlujo").empty();
        console.log("Nuevo FLujo oyeee")

        let lista = {
                Nombre : $("#NombreInput").val(),
                AreaId : $("#AreaIdInput").val(),
                GrupoId : $("#GrupoIdInput").val(),
                ordenFlujo: []
        }
        
        var i=0;
        $("#nuevoFlujo .draggable").each(function (index) {    
            let info = $(this).attr("data-info");
            if( i== 0){
                pivot =0; //Inicio
            }else{
                pivot =1;
            }
            var ordenFlujo = {
                Nivel: i,
                EstadoFlujoId: $(this).attr("data-info"),
                Pivot: pivot                 
            }
            lista.ordenFlujo.push(ordenFlujo);
            i=i+1;
        });     

        if (validator) {
            validator.validate().then(function (status) {
                actualizarValidSelect2();
                if( lista.ordenFlujo.length < 2 ){
                    html = '<ul><li style="">Minimo 2 Estados</li></ul>';
                    $("#AlertaErrorFlujo").append(html);                                    
                    $("#AlertaErrorFlujo").show();
                    console.log('demasiaio chico tu flujo po oe')
                    return;
                }
                key = lista.ordenFlujo.length-1;
                lista.ordenFlujo[key].Pivot=2; //Terminado           
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
