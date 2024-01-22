
//console.log(t)
if(credencialesGrupo.puedeEditar){
    var KTUsersUpdatePermissions = (function () {
        
        e = t.querySelector("#kt_modal_update_role_form")
        
        return {
            init: function (t,n) {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: { 
                            Nombre: { 
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
                                        regexp: /^[a-z0-9ñáéíóú\s]+$/i,
                                        message: 'Solo letras y numeros'
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
                            }) },
                    });
                    t.querySelector('[data-kt-roles-modal-action="close"]').addEventListener("click", (t) => {
                        t.preventDefault(),
                            Swal.fire({
                                text: "¿Estás seguro de cerrar?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Si",
                                cancelButtonText: "No",
                                customClass: { 
                                    confirmButton: "btn btn-dark", 
                                    cancelButton: "btn btn-active-light" 
                                },
                            }).then(function (t) {
                                t.value && n.hide();
                            });
                    }),
                        t.querySelector('[data-kt-roles-modal-action="cancel"]').addEventListener("click", (t) => {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "¿Estás seguro de cancelar?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Si",
                                    cancelButtonText: "No",
                                    customClass: { 
                                        confirmButton: "btn btn-dark", 
                                        cancelButton: "btn btn-active-light" 
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (e.reset(), n.hide())
                                        : "cancel" === t.dismiss &&
                                        Swal.fire({ 
                                            text: "¡Tu formulario no ha sido cancelado!", 
                                            icon: "error", 
                                            buttonsStyling: !1, 
                                            confirmButtonText: "OK", 
                                            customClass: { 
                                                confirmButton: "btn btn-dark" } 
                                            });
                                });
                        });
                    const i = t.querySelector('[data-kt-roles-modal-action="submit"]');
                    i.addEventListener("click", function (t) {
                        t.preventDefault(),
                            o &&
                                o.validate().then(function (t) {
                                    //console.log("validated!"),
                                        "Valid" == t
                                            ? (i.setAttribute("data-kt-indicator", "on"),
                                            (i.disabled = !0),
                                            Editar() 
                                            )
                                            : Swal.fire({
                                                text: "Lo siento, parece que se han detectado algunos errores. Por favor, inténtalo de nuevo.",
                                                icon: "error",
                                                buttonsStyling: !1,
                                                confirmButtonText: "OK",
                                                customClass: { 
                                                    confirmButton: "btn btn-dark" 
                                                },
                                            });
                                });
                    });
                })(),
                    (() => {
                        const t = e.querySelector("#kt_roles_select_all"),
                            n = e.querySelectorAll('[type="checkbox"]');
                        t.addEventListener("change", (t) => {
                            n.forEach((e) => {
                                e.checked = t.target.checked;
                            });
                        });
                    })();
            },
        };
    })();

    KTUsersUpdatePermissions.init(t,n);

    function Editar(){
        //console.log("editamos");
        let form1=document.getElementById('kt_modal_update_role_form');;

        const formData = new FormData(form1);
        const personas = [];
        const persona = {};

        formData.forEach((valor, clave) => {
        const matches = clave.match(/Privilegio\[(\d+)\]\[(\w+)\]/);
        if (matches && matches.length === 3) {
            const [, indice, propiedad] = matches;
            if (!persona[indice]) {
            persona[indice] = {};
            persona[indice]["PrivilegioId"]= indice;
            }
            if(valor == "" && propiedad != "Id")valor=1;
            persona[indice][propiedad] = valor;
        }
        });

        // Agregar los objetos Persona al array personas
        for (const indice in persona) {
        if (Object.hasOwnProperty.call(persona, indice)) {
            personas.push(persona[indice]);
        }
        }
        
        grupo={};
        grupo.Nombre=$("#NombreGrupoInput").val();
        console.log($("#IdGrupoInput").val())
        grupo.Id= $("#IdGrupoInput").val();
        grupo.GrupoPrivilegio = personas;

        personas.Nombre= $("#NombreGrupoInput").val()
        personas.Id =$("#IdGrupoInput").val()

        $.ajax({
            type: 'POST',
            url: EditarGrupoPrivilegio,
            data: {
                _token: csrfToken,
                data: grupo
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function() {
                bloquear();
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data);
                //blockUI.release();
                //$("#modal-update").html(data);
                if(data.success){
                    location.reload();
                }else{
                    html = '<ul><li style="">'+data.message+'</li></ul>';
                    $("#AlertaErrorGrupo").append(html);                                    
                    $("#AlertaErrorGrupo").show();
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
                            $('#kt_modal_update_role').modal('toggle');
                    });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });

    }

}




