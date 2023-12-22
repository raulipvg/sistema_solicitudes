"use strict";
var KTUsersUpdatePermissions = (function () {
    const t = document.getElementById("kt_modal_update_role"),
        e = t.querySelector("#kt_modal_update_role_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: { role_name: { 
                        validators: { 
                            notEmpty: {
                                 message: "El Nombre del Grupo es requerido" 
                                } 
                            } 
                        } 
                    },
                    plugins: { 
                        trigger: new FormValidation.plugins.Trigger(), 
                        bootstrap: new FormValidation.plugins.Bootstrap5({ 
                            rowSelector: ".fv-row", 
                            eleInvalidClass: "", 
                            eleValidClass: "" 
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
                                console.log("validated!"),
                                    "Valid" == t
                                        ? (i.setAttribute("data-kt-indicator", "on"),
                                          (i.disabled = !0),
                                          setTimeout(function () {
                                              i.removeAttribute("data-kt-indicator"),
                                                  (i.disabled = !1),
                                                  Swal.fire({ 
                                                    text: "¡El formulario ha sido enviado exitosamente!", 
                                                    icon: "success", 
                                                    buttonsStyling: !1, 
                                                    confirmButtonText: "OK", 
                                                    customClass: { 
                                                        confirmButton: "btn btn-dark" 
                                                    } }).then(
                                                      function (t) {
                                                          t.isConfirmed && n.hide();
                                                      }
                                                  );
                                          }, 2e3))
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
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePermissions.init();
});
