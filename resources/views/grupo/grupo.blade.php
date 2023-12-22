@extends('layout.main')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
@endpush


@section('main-content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar p-3">
	<!--begin::Toolbar-->
	<div class="toolbar py-2" id="kt_toolbar">
	    <!--begin::Container-->
	    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
	        <!--begin::Page title-->
	        <div class="flex-grow-1 flex-shrink-0 me-5">
	            <!--begin::Page title-->
	            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
	                <!--begin::Title-->
	                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Grupos
	                    <!--begin::Separator-->
	                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
	                    <!--end::Separator-->
	                    <!--begin::Description-->
	                    <small class="text-muted fs-7 fw-semibold my-1 ms-1">#XRS-45670</small>
	                    <!--end::Description-->
	                </h1>
	                <!--end::Title-->
	            </div>
	            <!--end::Page title-->
	        </div>
	        <!--end::Page title-->
	        <!--begin::Action group-->
	        <div class="d-flex align-items-center flex-wrap">
	            
	        </div>
	        <!--end::Action group-->
	    </div>
	    <!--end::Container-->
	</div>
	<!--end::Toolbar-->
</div>
<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="d-flex flex-column flex-column-fluid mx-6">
									<!--begin::Row-->
									<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
										<!--begin::Col-->
										<div class="col-md-4">
											<!--begin::Card-->
											<div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Administrador</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-5">Total de Usuarios: 5</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 1</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 2</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 3</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 4</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 5</div>
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer flex-wrap pt-0">
													<a href="apps/user-management/roles/view.html" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-md-4">
											<!--begin::Card-->
											<div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Grupo 2</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-5">Total de Usuarios: 12</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 1</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 2</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 3</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 4</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 5</div>
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer flex-wrap pt-0">
													<a href="apps/user-management/roles/view.html" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-md-4">
											<!--begin::Card-->
											<div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Grupo 3</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-5">Total de Usuarios: 12</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 1</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 2</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 3</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 4</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 5</div>
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer flex-wrap pt-0">
													<a href="apps/user-management/roles/view.html" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-md-4">
											<!--begin::Card-->
											<div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Grupo 4</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-5">Total de Usuarios: 12</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 1</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 2</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 3</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 4</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 5</div>
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer flex-wrap pt-0">
													<a href="apps/user-management/roles/view.html" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-md-4">
											<!--begin::Card-->
											<div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Grupo 5</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-5">Total de Usuarios: 12</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 1</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 2</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 3</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 4</div>
														<div class="d-flex align-items-center py-2">
														<span class="bullet bg-dark me-3"></span>Privilegio 5</div>
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer flex-wrap pt-0">
													<a href="apps/user-management/roles/view.html" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
									<!--begin::Modals-->
									<!--begin::Modal - Update role-->
									<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-dialog-centered mw-750px">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bold">Actualizar Grupo</h2>
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
												<div class="modal-body scroll-y mx-5 my-7">
													<!--begin::Form-->
													<form id="kt_modal_update_role_form" class="form" action="#">
														<!--begin::Scroll-->
														<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
															<!--begin::Input group-->
															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="fs-5 fw-bold form-label mb-2">
																	<span class="required">Nombre del Grupo</span>
																</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name" value="Administrador" />
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
																				<td class="text-gray-800">Acceso Administrador 
																				<span class="ms-1" data-bs-toggle="tooltip" title="Permite Acceso Completo al Sistema">
																					<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																						<span class="path1"></span>
																						<span class="path2"></span>
																						<span class="path3"></span>
																					</i>
																				</span></td>
																				<td>
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
																				<td class="text-gray-800">Privilegio 1</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 2</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="content_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="content_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="content_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 3</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="financial_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="financial_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="financial_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 4</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 5</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 6</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 7</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 7</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
																				<td class="text-gray-800">Privilegio 8</td>
																				<!--end::Label-->
																				<!--begin::Input group-->
																				<td>
																					<!--begin::Wrapper-->
																					<div class="d-flex">
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_read" />
																							<span class="form-check-label">Leer</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_write" />
																							<span class="form-check-label">Escribir</span>
																						</label>
																						<!--end::Checkbox-->
																						<!--begin::Checkbox-->
																						<label class="form-check form-check-custom form-check-solid">
																							<input class="form-check-input" type="checkbox" value="" name="user_management_create" />
																							<span class="form-check-label">Guardar</span>
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
									<!--end::Modal - Update role-->
									<!--end::Modals-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}'
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <script src="{{ asset('js/eventos/grupo/update-grupo.js?id=3') }}"></script>
@endpush