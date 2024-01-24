const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
var loadingEl = document.createElement("div");

    function bloquear(){
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `<span class="spinner-border text-primary" role="status"></span>
                               <span class="text-gray-800 fs-6 fw-semibold mt-5">Cargando...</span>`;
    }

    function actualizarValidSelect2(){
        
        $('.form-select').each( function () {
            var valid = $(this).hasClass("is-valid");
            var invalid =$(this).hasClass("is-invalid");
            if(valid){
                $(this).next().children().children().removeClass("is-invalid").addClass("is-valid");
            }
            if(invalid){
                $(this).next().children().children().removeClass("is-valid").addClass("is-invalid");
            }
            if(!valid && !invalid){
                $(this).next().children().children().removeClass("is-valid");
                $(this).next().children().children().removeClass("is-invalid");
            }
        });
    }

    function formMap(fd){
        var pairs = fd.split('&');
        var keyValueObject = {};
        
        for (let i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            var key = decodeURIComponent(pair[0]);
            var value = decodeURIComponent(pair[1]);
            keyValueObject[key] = value;
        }
        return keyValueObject;
    }
    
    function formatearFecha(fecha){
        var date = new Date(fecha);
        // Obtener el día, mes y año
        var dia = date.getDate();
        var mes = date.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
        var anio = date.getFullYear();
        // Formatear la fecha como "DD-MM-YYYY"
        var fechaFormateada = dia + "-" + (mes < 10 ? "0" : "") + mes + "-" + anio;
    
        return fechaFormateada;
    }

    function formatearFecha2(fecha) {
        var mesesAbreviados = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    
        var date = new Date(fecha);
        // Obtener el día, mes y año
        var dia = date.getDate();
        var mes = mesesAbreviados[date.getMonth()]; // Obtener el mes abreviado
        var anio = date.getFullYear();
        // Formatear la fecha como "DD-Mes-YYYY"
        var fechaFormateada = dia+" "+mes+" "+anio;
    
        return fechaFormateada;
    }

    function llenarSelect2(data,select){
        select.empty();
        var option = new Option('','');
        select.append(option);
        for (const key in data) {
            var textoCapitalizado = (data[key].Nombre).toUpperCase();
            var option = new Option(textoCapitalizado, data[key].Id);
            select.append(option);                        
        }
    }

    function botonEstado(tooltip, className, estado){
        var btn = `
                    <button class="btn btn-sm ${className} fs-7 text-uppercase justify-content-center p-1" 
                            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="${tooltip}">
                        <span class="indicator-label">${estado}</span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>
                `;
        return btn;
    }

    function botonAcciones(modal,id){
        var btn =   `
                    <div class="btn-group btn-group-sm" role="group">
                        ${credenciales.puedeVer ? `<a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#${modal}" info="${id}">Ver</a>` : ''}
                        ${credenciales.puedeEditar ? `<a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#${modal}" info="${id}">Editar</a>` : ''}
                    </div>
                    `;
        return btn;
    }

    function botonAcciones2(modal,id){
        var btn =   `
                    <div class="btn-group btn-group-sm" role="group">
                        ${credencialesUsuario.puedeVer ? `<a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#${modal}" info="${id}">Ver</a>` : ''}
                        ${credencialesUsuario.puedeEditar ? `<a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#${modal}" info="${id}">Editar</a>` : ''}
                    </div>
                    `;
        return btn;
    }

    

    function botonAccion(modal,id){
        var btn =   `
                    <div class="btn-group btn-group-sm" role="group">
                        ${credenciales.puedeEditar ? `<a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#${modal}" info="${id}">Editar</a>` : ''}
                    </div>
                    `;
        return btn;
    }

    function botonVerDetalle(tooltip){
        var btn =   `
                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" 
                            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="${tooltip}">
                        <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                        <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                        <span class="indicator-label"></span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>
                    `;
        return btn;
    }

    function botonModal(modal,tooltip,id){
        var btn =   `
                    <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="${tooltip}">
                        <a class="btn btn-sm btn-icon btn-light btn-active-light-primary h-25px w-25px dar-acceso" type="button" data-bs-toggle="modal" data-bs-target="${modal}" info="${id}">
                            <i class="ki-duotone ki-plus fs-3 m-0"></i>
                        </a>
                    </div>
                    `;
        return btn;
    }
    
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        };

    