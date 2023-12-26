const t = document.getElementById("kt_modal_update_role");
const n = new bootstrap.Modal(t);
$(document).ready(function() {

$("#contenedor").on("click",'.editar-grupo', function (e) {
    e.preventDefault();
    e.stopPropagation();
    //Inicializacion
    //$("#modal-titulo").empty().html("Editar Usuario");
    $("input").val('').prop("disabled",false);
    $('.form-select').val("").trigger("change").prop("disabled",false);

   // $("#AlertaError").hide();

    //validator.resetForm();
    //actualizarValidSelect2();

    let id = Number($(this).attr("data-info"));
    
    $.ajax({
        type: 'POST',
        url: VerGrupoEdit,
        data: {
            _token: csrfToken,
            data: id
        },
        //content: "application/json; charset=utf-8",
        dataType: "HTML",
        beforeSend: function() {
            bloquear();
            KTApp.showPageLoading();
        },
        success: function (data) {
            //console.log(data);
            //blockUI.release();
            $("#modal-update").html(data);
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

// Evento al Boton que cambia el estado del usuario
$("#contenedor").on("click", '.estado-grupo', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var grupoId =  $(this).attr('data-info');
    var btn = $(this);
    console.log(grupoId)
    $.ajax({
        type: 'POST',
        url: CambiarEstadoGrupo,
        data: {
            _token: csrfToken,
            data: grupoId
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


});
