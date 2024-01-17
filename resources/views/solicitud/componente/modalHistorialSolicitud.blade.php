<div class="modal modal-lg fade" tabindex="-1" id="historialSolicitud" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
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
			
				<div class="d-flex flex-row ">
					<div class="">
						<div>
							<!--begin::Subtitle-->
							<h3 class="fw-bold text-gray-800 mb-3">Detalles de Solicitud</h3>
							<!--end::Subtitle-->
							<!--begin::Items-->
							<div class="d-flex d-grid gap-5">
								<!--begin::Item-->
								<div class="d-flex flex-column flex-shrink-0 me-4">
									<!--begin::Section-->
									<span id="Solicitante" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Solicitante: </span>
									<!--end::Section-->
									<!--begin::Section-->
									<span id="ValorEstimado" class="d-flex align-items-center text-gray-500 fw-bold fs-7 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Valor referencia: </span>
									<!--end::Section-->
								</div>
								<!--end::Item-->
								<!--begin::Item-->
								<div class="d-flex flex-column flex-shrink-0">
									<!--begin::Section-->
									<span id="Receptor" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Receptor: </span>
									<!--end::Section-->
									<!--begin::Section-->
									<span id="ValorReal" class="d-flex align-items-center text-gray-500 fw-bold fs-7 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Valor real:</span>
									<!--end::Section-->
								</div>
								<!--end::Item-->
							</div>
							<!--begin::Section-->
									<span id="RangoFecha" class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-1">
									<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Fecha inicio: </span>
									<!--end::Section-->
							<!--end::Items-->

						</div>
						<div class="table-responsive">
								<!--begin::Table-->
								<table id="tabla-atributos-solicitud" class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
									<!--begin::Thead-->
									<thead class="border-gray-200 fs-6 fw-semibold bg-lighten">
										<tr>
											<th class="min-w-100px p-1">Atributo</th>
											<th class="min-w-100px p-1">Valor Referencia</th>
											<th class="min-w-150px p-1">Valor Real</th>
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
				
					<div class="">
						<div>
							<h3 class="text-gray-800 text-capitalize mb-3" id="titulo-flujo"> Flujo:</h3>
							<div id="lineaTiempo" class="m-0">
										
							</div>
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