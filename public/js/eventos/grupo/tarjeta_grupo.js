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

});
