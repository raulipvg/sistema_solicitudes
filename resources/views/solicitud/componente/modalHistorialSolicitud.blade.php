<div class="modal modal-xl fade" tabindex="-1" id="historialSolicitud" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-historialSolicitud" class="modal-title text-uppercase">Historial Solicitud</h2>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-3x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="1" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body py-1">
			
				<div class="d-flex flex-md-row flex-column">
					<div class="col">
						<div>
							<h3 class="fw-bold text-gray-800 mb-3">Detalles de Solicitud</h3>

									<span id="Receptor" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Solicitud para: </span>

									<span class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1 text-capitalize">
										<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>Movimiento:<span id="Movimiento" class="ps-1"> </span> 
									</span>

									<span id="ValorReal" class="d-flex align-items-center text-gray-500 fw-bold fs-7">
										<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>Costo:
									</span>

									<span id="RangoFecha" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Actualizacion: </span>

									<span id="Solicitante" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Solicitado por: </span>
									<div id="RespaldoPadre">
										<span class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
											<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
												<span class="path1"></span>
												<span class="path2"></span>
											</i> 
											<a href="#" class="p-1 ps-0 fs-7 fw-bold text-gray-500 text-hover-dark" data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="top-end">
												Respaldo
												<span class="svg-icon fs-5 m-0">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<polygon points="0 0 24 0 24 24 0 24"></polygon>
															<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
														</g>
													</svg>
												</span>
											</a>
											<div id="Respaldo" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-auto py-2" data-kt-menu="true" style="">
												<div class="menu-item px-3">
													<a href="#" target="_blank" class="menu-link px-3">Edit</a>
												</div>
												<div class="menu-item px-3">
													<a href="#" target="_blank"class="menu-link px-3">Delete</a>
												</div>
											</div>
										</span>
									</div>
							

						</div>
						<div class="table-responsive px-5 py-2">
								<!--begin::Table-->
								<table id="tabla-atributos-solicitud" class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
									<!--begin::Thead-->
									<thead class="border-gray-200 fs-6 fw-semibold bg-lighten">
										<tr>
											<th class="p-1">Atributo</th>
											<th class="p-1">Cant.</th>											
											<th class="p-1">Costo</th>
											<th class="p-1">Detalle</th>											
											<th class="text-end p-1">Fecha</th>
										</tr>
									</thead>
									<!--end::Thead-->
									<!--begin::Tbody-->
									<tbody class="fw-7 fw-semibold text-gray-600">

									</tbody>
									<!--end::Tbody-->
								</table>
								<!--end::Table-->
						</div>
					</div>
				
					<div class="col">
						<h3 class="text-gray-800 text-capitalize mb-1" id="titulo-flujo"> Flujo:</h3>
						<div id="lineaTiempo">
										
						</div>				
					</div>
				</div>
				
			</div>
			<div class="modal-footer bg-light p-2">
                <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>                    
            </div>
        </div>
    </div>
</div>