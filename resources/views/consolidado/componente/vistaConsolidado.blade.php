<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    <div class="container-fluid">
        <div class="row flex-md-row">

            <div id="contenedor-1" class="col-md-8 col-12  mb-3">
                <div id="botones-ctrl" class="card">                   
                    <div class="card-body p-2">
                        <div id="div-adm" class="d-flex flex-row justify-content-between align-items-center">
                            <div class="sa">
                                <div class="row align-items-center">
                                    <div class="w-md-150px w-150px my-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                                        <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">

                                                <option value=""selected></option>

                                        </select>
                                    </div>
                                    <div class="col-auto ms-md-2 ms-0 my-1 ps-3 ps-md-1">
                                        

                                            <button id="AbrirNuevoMes" type="button" class="btn btn-sm btn-success h-40px abrir-mes" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Abrir Nuevo Mes">
                                                ABRIR MES
                                            </button>
                                                <button id="AccionMesInput" type="button" class="btn btn-sm btn-warning h-40px cerrar-mes my-2 my-md-0" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Cerrar y Publicar Gasto Mensual">
                                                    CERRAR MES
                                                </button>
                                                <button id="AccionMesInput" type="button" class="btn btn-sm btn-dark h-40px disabled my-2 my-md-0">
                                                    MES CERRADO
                                                </button>
                                        <button id="AbrirNuevoMes" type="button" class="btn btn-sm btn-success h-40px abrir-mes" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Abrir Nuevo Mes">
                                            ABRIR MES
                                        </button>
                                        <!--
                                        <button id="AccionMesInput" type="button" class="btn btn-sm btn-success h-40px abrir-mes">
                                            ABRIR MES
                                        </button>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>

            <div id="consolidado" class="">
                <div class="card mb-2">
                    <div class="card-body p-2">

                        <div id="centroscostos" class="accordion accordion-icon-toggle">
                            <!--begin::Item-->
                            <div class="accordion-item rounded-top-1">
                                <!--begin::Header-->
                                <div class="accordion-header py-2 d-flex bg-dark-2 rounded-top-1" data-bs-toggle="collapse" data-bs-target="#accordion-gastos-adm" aria-expanded="false">
                                    <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                    <div class="col-12 pe-5">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="fs-3 fw-bold mb-0 text-white text-uppercase">Gastos de Administración</h3>
                                            <div class="fs-3 fw-bold mb-0 pe-7 text-white text-uppercase">

                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div id="accordion-gastos-adm" class="fs-6 px-5 collapse show" data-bs-parent="#accordion-gastos" >
                                    <div class="table-responsive">
                                        <table class="table table-hover table-row-bordered gy-5">
                                            <thead>
                                                <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="5" class="p-2">Remuneraciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">

                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"> </td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>                                                    

                                                <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="4" class="py-0 px-2">TOTAL REMUNERACIONES</th>
                                                    <th class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                        <span class="text-start">$</span>
                                                        <span class="text-end"> </span>        
                                                    </th>
                                                </tr>
                                            </tbody>

                                            <thead>
                                                <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="5" class="p-2">Caja Chica</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">
                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"> </td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>
                                                <tr class="text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="4" class="py-0 px-2">TOTAL CAJA CHICA</th>
                                                    <th class="py-0 pe-2 text-gray-800 fw-bolder d-flex justify-content-between">
                                                        <span class="text-start">$</span></th>
                                                </tr>  


                                            </tbody>
                                            <thead>
                                                <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="5" class="p-2">Otros Gastos</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">
                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"> </td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>

                                                <tr class="text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                                    <th colspan="4" class="py-0 px-2">TOTAL OTROS GASTOS</th>
                                                    <th class="py-0 pe-2 text-gray-800 fw-bolder d-flex justify-content-between">
                                                        <span class="text-start">$</span></th>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                                    <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE ADMINISTRACIÓN</th>
                                                    <th class="py-0 pe-2">
                                                        <div class="d-flex justify-content-between fw-bolder text-white">
                                                            <span class="text-start">$</span>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="accordion-item">
                                <!--begin::Header-->
                                <div class="accordion-header py-2 d-flex bg-dark-2 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-uso" aria-expanded="false">
                                    <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                    <div class="col-12 pe-5">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="fs-3 fw-bold mb-0 text-white text-uppercase">Gastos de Uso o Consumo</h3>
                                            <div class="fs-3 fw-bold mb-0 pe-7 text-white text-uppercase"></div>
                                        </div>
                                    </div>   
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div id="accordion-gasto-uso" class="fs-6 px-5 collapse" data-bs-parent="#accordion-gastos">
                                <div class="table-responsive">
                                        <table class="table table-hover table-row-bordered gy-5">
                                            <thead>
                                                <tr>

                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">
                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"> </td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>

                                                <thead>
                                                    <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                                        <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE USO O CONSUMO</th>
                                                        <th class="py-0 pe-2">
                                                            <div class="d-flex justify-content-between fw-bolder text-white">
                                                                <span class="text-start">$</span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </tbody>                            
                                        </table>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="accordion-item">
                                <!--begin::Header-->
                                <div class="accordion-header py-2 d-flex bg-dark-2 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-mantencion" aria-expanded="false">
                                    <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                    <div class="col-12 pe-5">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="fs-3 fw-bold mb-0 text-white text-uppercase">Gastos de Mantención</h3>
                                            <div class="fs-3 fw-bold mb-0 pe-7 text-white text-uppercase"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div id="accordion-gasto-mantencion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-row-bordered gy-5">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">
                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"></td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>
                                                <thead>
                                                    <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                                        <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE MANTENCION</th>
                                                        <th class="py-0 pe-2">
                                                            <div class="d-flex justify-content-between fw-bolder text-white">
                                                                <span class="text-start">$</span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </tbody>                            
                                        </table>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="accordion-item">
                                <!--begin::Header-->
                                <div class="accordion-header py-2 d-flex bg-dark-2 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-reparacion" aria-expanded="false">
                                    <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                    <div class="col-12 pe-5">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="fs-3 fw-bold mb-0 text-white text-uppercase">Gastos de Reparación</h3>
                                            <div class="fs-3 fw-bold mb-0 pe-7 text-white text-uppercase"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div id="accordion-gasto-reparacion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-row-bordered gy-5">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600 fs-6">
                                                        <tr>
                                                            <td class="py-0 px-2 text-capitalize"></td> <!--Nombre -->
                                                            <td class="py-0 text-capitalize"></td> <!--Responsable-->
                                                            <td class="py-0 text-gray-400"></td> <!-- Detalle, Descripcion -->
                                                            <td class="py-0 text-gray-400"> </td> <!-- Tipo + Nro Documento -->
                                                            <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                                <span class="text-start">$</span>
                                                                <span class="text-end"></span>  <!--Monto,Precio -->
                                                            </td>
                                                        </tr>

                                                <thead>
                                                    <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                                        <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE REPARACIÓN</th>
                                                        <th class="py-0 pe-2">
                                                            <div class="d-flex justify-content-between fw-bolder text-white">
                                                            <span class="text-start"></span>
                                                            </div>

                                                        </th>
                                                    </tr>
                                                </thead>
                                            </tbody>                            
                                        </table>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <div class="d-flex align-items-end flex-column">
                            <div class="d-flex flex-stack bg-dark-2 p-3 rounded-bottom-1">
                                <!--begin::Content-->
                                <div class="fs-3 fw-bold text-white">
                                    <span class="d-block fs-2qx lh-1">TOTAL</span>
                                </div>
                                <!--end::Content-->
                                <!--begin::Content-->
                                <div class="fs-3 fw-bold text-white text-end pe-4">
                                    <span class="d-block fs-2qx lh-1"></span>
                                </div>
                                <!--end::Content-->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
       
        </div>
    </div>
</div>

<!--end::Content-->