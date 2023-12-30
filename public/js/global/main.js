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

    function botonEstado(tooltip, className, estado){
        var btn = '<button class="btn btn-sm '+className+' fs-7 text-uppercase justify-content-center p-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="'+tooltip+'">'+
                        '<span class="indicator-label">'+estado+'</span>'+
                        '<span class="indicator-progress">'+
                            '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                        '</span>'+
                   '</button>';
        return btn;
    }

    function botonAcciones(modal,id){
        var btn ='<div class="btn-group btn-group-sm" role="group">'+
                    '<a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#'+modal+'" info="'+id+'">Ver</a>'+
                    '<a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#'+modal+'" info="'+id+'">Editar</a>'+
                '</div>';
        return btn;
    }

    function botonVerDetalle(tooltip){
        var btn =   '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="'+tooltip+'">'+
                        '<i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>'+
                        '<i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>'+
                        '<span class="indicator-label"></span>'+
                        '<span class="indicator-progress">'+
                            '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                        '</span>'+
                    '</button>';
        return btn;
    }

 