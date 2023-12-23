<div class="modal fade" id="kt_modal_update_role" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-dialog-centered mw-750px">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bold">Editar Privilegios del Grupo</h2>
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
												<div class="modal-body scroll-y py-3">
													<!--begin::Form-->
													<form id="kt_modal_update_role_form" class="form" action="#">
														<!--begin::Scroll-->
														<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
															<!--begin::Input group-->
															<div class="fv-row mb-2">
																<!--begin::Label-->
																<label class="fs-5 fw-bold form-label mb-2">
																	<span class="required">Nombre del Grupo</span>
																</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid" placeholder="Ingrese nombre del Grupo" name="role_name" value="Grupo 1" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Permissions-->
															<div class="fv-row">
																<!--begin::Label-->
																<label class="fs-5 fw-bold form-label mb-2">Privilegios del Grupo</label>
																<!--end::Label-->
																<!--begin::Table wrapper-->
																<div class="table-responsive">
																	<!--begin::Table-->
																	<table class="table align-middle table-row-dashed fs-6 gy-5">
																		<!--begin::Table body-->
																		<tbody class="text-gray-600 fw-semibold">
																			<!--begin::Table row-->
																			<tr>
																				<td class="text-gray-800 p-2">Acceso Administrador 
																					<span class="ms-1" data-bs-toggle="tooltip" title="Permite Acceso Completo al Sistema">
																						<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																							<span class="path1"></span>
																							<span class="path2"></span>
																							<span class="path3"></span>
																						</i>
																					</span>
																				</td>
																				<td class="p-2">
																					<!--begin::Checkbox-->
																					<label class="form-check form-check-sm form-check-custom form-check-solid me-9">
																						<input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
																						<span class="form-check-label" for="kt_roles_select_all">Seleccionar Todo</span>
																					</label>
																					<!--end::Checkbox-->
																				</td>
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="text-gray-800 p-2">Privilegio 1</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="text-gray-800 p-2">Privilegio 2</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="text-gray-800 p-2">Privilegio 3</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="text-gray-800 p-2">Privilegio 4</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="p-2 text-gray-800">Privilegio 5</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="p-2 text-gray-800">Privilegio 6</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="p-2 text-gray-800">Privilegio 7</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="p-2 text-gray-800">Privilegio 8</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																			<!--begin::Table row-->
																			<tr>
																				<!--begin::Label-->
																				<td class="p-2 text-gray-800">Privilegio 9</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td class="p-2">
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Registrar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Editar</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Eliminar</span>
																						</label>
																						<!--end::Checkbox-->
																					</div>
																					<!--end::Wrapper-->
																				</td>
																				<!--end::Input group-->
																			</tr>
																			<!--end::Table row-->
																		</tbody>
																		<!--end::Table body-->
																	</table>
																	<!--end::Table-->
																</div>
																<!--end::Table wrapper-->
															</div>
															<!--end::Permissions-->
														</div>
														<!--end::Scroll-->
														<!--begin::Actions-->
														<div class="text-center pt-15">
															<button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Cancelar</button>
															<button type="submit" class="btn btn-dark" data-kt-roles-modal-action="submit">
																<span class="indicator-label">Actualizar</span>
																<span class="indicator-progress">Espere... 
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
															</button>
														</div>
														<!--end::Actions-->
													</form>
													<!--end::Form-->
												</div>
												<!--end::Modal body-->
											</div>
											<!--end::Modal content-->
										</div>
										<!--end::Modal dialog-->
									</div>