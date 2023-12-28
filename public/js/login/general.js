"use strict";
var KTSigninGeneral = function() {
    var t, e, r;
    return {
        init: function() {
            t = document.querySelector("#kt_sign_in_form"),
            e = document.querySelector("#kt_sign_in_submit"),
            r = FormValidation.formValidation(t, {
                fields: {
                    'Email': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            emailAddress: {
                                message: 'Email inválido'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                                message: 'Formato inválido'
                            }
                        }
                    }, 
                    'Password': {
                        validators: {
                            notEmpty: {
                                message: "Requerido"
                            },
                            stringLength: {
                                min: 8,
                                max: 100,
                                message: 'Entre 8 y 50 caracteres'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }),
            !function(t) {
                try {
                    return new URL(t),
                    !0
                } catch(t) {
                    return !1
                }
            } (e.closest("form").getAttribute("action")) ? e.addEventListener("click", (function(i) { //URL VALIDA
                i.preventDefault(),
                r.validate().then((function(r) {
                    "Valid" == r ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, setTimeout((function() {
                        e.removeAttribute("data-kt-indicator"),
                        e.disabled = !1,
                        Swal.fire({
                            text: "¡Has iniciado sesión correctamente!",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok!",
                            customClass: {
                                confirmButton: "btn btn-dark"
                            }
                        }).then((function(e) {
                            if (e.isConfirmed) {
                                t.querySelector('[name="email"]').value = "",
                                t.querySelector('[name="password"]').value = "";
                                var r = t.getAttribute("data-kt-redirect-url");
                                r && (location.href = r)
                            }
                        }))
                    }), 2e3)) : Swal.fire({
                        text: "Lo siento, parece que se detectaron algunos errores, por favor inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn btn-dark"
                        }
                    })
                }))
            })) : e.addEventListener("click", (function(i) {
                i.preventDefault(),
                r.validate().then((function(r) {
                    "Valid" == r ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, axios.post(e.closest("form").getAttribute("action"), new FormData(t)).then((function(e) {
                        if (e) {
                            t.reset(),
                            Swal.fire({
                                text: "¡Has iniciado sesión correctamente!",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-dark"
                                }
                            });
                            const e = t.getAttribute("data-kt-redirect-url");
                            e && (location.href = e)
                        } else Swal.fire({
                            text: "Lo siento, el correo electrónico o la contraseña son incorrectos, por favor inténtalo de nuevo.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-dark"
                            }
                        })
                    })).
                    catch((function(t) {
                        Swal.fire({
                            text: "Lo siento, parece que se detectaron algunos errores, por favor inténtalo de nuevo.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-dark"
                            }
                        })
                    })).then((() => {
                        e.removeAttribute("data-kt-indicator"),
                        e.disabled = !1
                    }))) : Swal.fire({
                        text: "Lo siento, parece que se detectaron algunos errores, por favor inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-dark"
                        }
                    })
                }))
            }))
        }
    }
} ();
KTUtil.onDOMContentLoaded((function() {
    KTSigninGeneral.init()
}));