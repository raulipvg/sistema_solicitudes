									<div class="modal fade" id="kt_modal_update_role" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-xl  modal-dialog-centered">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header bg-light p-2 ps-5">
													<!--begin::Modal title-->
													<h2 class="fw-bold text-uppercase">Editar Privilegios del Grupo</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
														<i class="ki-duotone ki-cross fs-1">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div id="modal-update">
													@include('grupo.componente._formEditarGrupo', ['privilegios'=> $privilegios])
												</div>
												<!--end::Modal body-->
											</div>
											<!--end::Modal content-->
										</div>
										<!--end::Modal dialog-->
									</div>