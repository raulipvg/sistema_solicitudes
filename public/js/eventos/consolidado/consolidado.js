$(document).ready(function() {

    var html = '';

    var primerCC = 'rounded-top-1';
    
    centroCostoNombre = 'centro de costo 1'
    cabecera = `
                    <!--begin::Item-->
                        <div class="accordion-item rounded-top-1">
                            <!--begin::Header-->
                            <div class="accordion-header py-2 d-flex bg-dark-2 ${primerCC}" data-bs-toggle="collapse" data-bs-target="#accordion-gastos-adm" aria-expanded="false">
                                <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                <div class="col-12 pe-5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="fs-3 fw-bold mb-0 text-white text-uppercase">${centroCostoNombre}</h3>
                                        <div class="fs-3 fw-bold mb-0 pe-7 text-white text-uppercase">

                                        </div>
                                    </div>

                                </div>

                            </div>
                        <!--end::Header-->
    `
    primerCC = '';
    movimiento1 = {
        Nombre:'movimiento 1',
        atributos : {
            atributo1 : {
                Nombre : 'atributo 1',
                Cantidad : 4,
                Tipo_moneda : 'USD$',
                Total : 1000
            },
            atributo2 : {
                Nombre : 'atributo 2',
                Cantidad : 4,
                Tipo_moneda : 'UF',
                Total : 1000
            },
            atributo3 : {
                Nombre : 'atributo 3',
                Cantidad : 4,
                Tipo_moneda : 'CLP$',
                Total : 1000
            }
        }
    }
    
    totalAtributo1 = 10000
    atributo2 = 'atributo 2'
    cuerpo = `
        <!--begin::Body-->
        <div id="accordion-centocosto" class="fs-6 px-5 collapse show" data-bs-parent="#centroscostos" >
            <div class="table-responsive">
                <table class="table table-hover table-row-bordered gy-5">
                    <thead>
                        <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                            <th colspan="5" class="p-2">${movimiento1.Nombre}</th>
                            <th colspan="5" class="p-2">${"Cantidad"}</th>
                            <th colspan="5" class="p-2">${"Total"}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600 fs-6">
                                <tr>
                                    <td colspan="5" class="py-0 px-2 text-capitalize">${movimiento1.atributos.atributo1.Nombre}</td> <!--Nombre -->
                                    <td colspan="5"class="py-0 text-capitalize">${movimiento1.atributos.atributo1.Cantidad}</td> <!--Cantidad de atributo-->
                                    <td colspan="5" class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                        <span class="text-start">${movimiento1.atributos.atributo1.Tipo_moneda}</span>
                                        <span class="text-end">${movimiento1.atributos.atributo1.Total}</span>  <!--Monto,Precio -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="py-0 px-2 text-capitalize">${movimiento1.atributos.atributo2.Nombre}</td> <!--Nombre -->
                                    <td colspan="5"class="py-0 text-capitalize">${movimiento1.atributos.atributo2.Cantidad}</td> <!--Cantidad de atributo-->
                                    <td colspan="5" class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                        <span class="text-start">${movimiento1.atributos.atributo2.Tipo_moneda}</span>
                                        <span class="text-end">${movimiento1.atributos.atributo2.Total}</span>  <!--Monto,Precio -->
                                    </td>
                                </tr>                                                   
                    </tbody>
                    <thead>
                        <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                            <th colspan="10" class="p-2">Total del movimiento</th>
                            <th colspan="10" class="p-2">${movimiento1.atributos.atributo1.Tipo_moneda + movimiento1.atributos.atributo1.Total +'+'+ movimiento1.atributos.atributo2.Tipo_moneda + movimiento1.atributos.atributo2.Total }</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--end::Body-->
        `

    html = cabecera + cuerpo;
    $('#centroscostos').empty().html(html);


    $("#contenedor-cc").on('click', '.ver-detalle', function(e) {
        console.log("wea")
        var data= [
            {
                Nombre: 'Atributo 1 Nombre',
                Cantidad: 5,
                Total: 100000
            },
            {
                Nombre: 'Atributo 2 Nombre',
                Cantidad: 50,
                Total: 900000 
            }
        ]
        
        
        miTablaDetalle.clear();
        cargarData.init(data);
        miTablaDetalle.draw();

    })
})