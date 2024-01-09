@extends('layout.main')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
@endpush


@section('main-content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="container-fluid mt-2">
        <!--begin::Table Widget 3-->
        <div class="card card-flush h-xl-100">
												<!--begin::Card header-->
												<div class="card-header py-7">
													<!--begin::Tabs-->
													<div class="card-title pt-3 mb-0 gap-4 gap-lg-10 gap-xl-15 nav nav-tabs border-bottom-0" data-kt-table-widget-3="tabs_nav">
														<ul class="nav">
															<li class="nav-item">
																<a class="nav-link btn btn-sm btn-color-dark btn-active btn-active-dark fw-bold px-4 me-1 active" data-bs-toggle="tab" href="#tabulador1">ACTIVAS (47)</a>
															</li>
															<li class="nav-item">
																<a class="nav-link btn btn-sm btn-color-dark btn-active btn-active-dark fw-bold px-4 me-1" data-bs-toggle="tab" href="#tabulador2">TERMINADAS (58)</a>
															</li>
														</ul>
													</div>
													<!--end::Tabs-->
													<!--begin::Create campaign button-->
													<div class="card-toolbar">
														<a href="#" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Crear Solicitud</a>
													</div>
													<!--end::Create campaign button-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<div class="tab-content">
														
														<div class="tab-pane fade show active" id="tabulador1">
															<!--begin::Sort & Filter-->
															<div class="d-flex flex-stack flex-wrap gap-4">
																<!--begin::Sort-->
																<div class="d-flex align-items-center flex-wrap gap-3 gap-xl-9">
																	<!--begin::Type-->
																	<div class="d-flex align-items-center fw-bold">
																		<!--begin::Label-->
																		<div class="text-muted fs-7">Filtro1</div>
																		<!--end::Label-->
																		<!--begin::Select-->
																		<select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-control="select2" data-dropdown-css-class="w-150px" data-placeholder="Select an option">
																			<option></option>
																			<option value="Show All" selected="selected">Todo</option>
																			<option value="Newest">Newest</option>
																			<option value="oldest">Oldest</option>
																		</select>
																		<!--end::Select-->
																	</div>
																	<!--end::Type-->
																	<!--begin::Status-->
																	<div class="d-flex align-items-center fw-bold">
																		<!--begin::Label-->
																		<div class="text-muted fs-7 me-2">Filtro2</div>
																		<!--end::Label-->
																		<!--begin::Select-->
																		<select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-control="select2" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-3="filter_status">
																			<option></option>
																			<option value="Show All" selected="selected">Todo</option>
																			<option value="Live Now">Live Now</option>
																			<option value="Reviewing">Reviewing</option>
																			<option value="Paused">Paused</option>
																		</select>
																		<!--end::Select-->
																	</div>
																	<!--begin::Status-->
																	<!--begin::Budget-->
																	<div class="d-flex align-items-center fw-bold">
																		<!--begin::Label-->
																		<div class="text-muted me-2">Filtro3</div>
																		<!--end::Label-->
																		<!--begin::Select-->
																		<select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-dropdown-css-class="w-150px" data-control="select2" data-placeholder="Select an option" data-kt-table-widget-3="filter_status">
																			<option></option>
																			<option value="Show All" selected="selected">Todo</option>
																			<option value="&lt;5000">Less than $5,000</option>
																			<option value="5000-10000">$5,001 - $10,000</option>
																			<option value="&gt;10000">More than $10,001</option>
																		</select>
																		<!--end::Select-->
																	</div>
																	<!--begin::Budget-->
																</div>
																<!--end::Sort-->
																<!--begin::Filter-->
																<div class="d-flex align-items-center gap-4">
																	<!--begin::Filter button-->
																	<a href="#" class="text-hover-primary ps-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																		<i class="ki-duotone ki-filter fs-2 text-gray-500">
																			<span class="path1"></span>
																			<span class="path2"></span>
																		</i>
																	</a>
																	<!--begin::Menu 1-->
																	<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_654c70184f80d">
																		<!--begin::Header-->
																		<div class="px-7 py-5">
																			<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
																		</div>
																		<!--end::Header-->
																		<!--begin::Menu separator-->
																		<div class="separator border-gray-200"></div>
																		<!--end::Menu separator-->
																		<!--begin::Form-->
																		<div class="px-7 py-5">
																			<!--begin::Input group-->
																			<div class="mb-10">
																				<!--begin::Label-->
																				<label class="form-label fw-semibold">Status:</label>
																				<!--end::Label-->
																				<!--begin::Input-->
																				<div>
																					<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_654c70184f80d" data-allow-clear="true">
																						<option></option>
																						<option value="1">Approved</option>
																						<option value="2">Pending</option>
																						<option value="2">In Process</option>
																						<option value="2">Rejected</option>
																					</select>
																				</div>
																				<!--end::Input-->
																			</div>
																			<!--end::Input group-->
																			<!--begin::Input group-->
																			<div class="mb-10">
																				<!--begin::Label-->
																				<label class="form-label fw-semibold">Member Type:</label>
																				<!--end::Label-->
																				<!--begin::Options-->
																				<div class="d-flex">
																					<!--begin::Options-->
																					<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
																						<input class="form-check-input" type="checkbox" value="1" />
																						<span class="form-check-label">Author</span>
																					</label>
																					<!--end::Options-->
																					<!--begin::Options-->
																					<label class="form-check form-check-sm form-check-custom form-check-solid">
																						<input class="form-check-input" type="checkbox" value="2" checked="checked" />
																						<span class="form-check-label">Customer</span>
																					</label>
																					<!--end::Options-->
																				</div>
																				<!--end::Options-->
																			</div>
																			<!--end::Input group-->
																			<!--begin::Input group-->
																			<div class="mb-10">
																				<!--begin::Label-->
																				<label class="form-label fw-semibold">Notifications:</label>
																				<!--end::Label-->
																				<!--begin::Switch-->
																				<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
																					<input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
																					<label class="form-check-label">Enabled</label>
																				</div>
																				<!--end::Switch-->
																			</div>
																			<!--end::Input group-->
																			<!--begin::Actions-->
																			<div class="d-flex justify-content-end">
																				<button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
																				<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
																			</div>
																			<!--end::Actions-->
																		</div>
																		<!--end::Form-->
																	</div>
																	<!--end::Menu 1-->
																	<!--end::Filter button-->
																</div>
																<!--end::Filter-->
															</div>
															<!--end::Sort & Filter-->

															<!--begin::Separator-->
															<div class="separator separator-dashed my-5"></div>
															<!--end::Separator-->

															<!--begin::Table-->
															<table id="kt_widget_table_3" class="table table-row-dashed align-middle fs-6 gy-4 my-0 pb-3 table-hover" data-kt-table-widget-3="all">
																	<thead class="d-none">
																		<tr>
																			<th>Campaign</th>
																			<th>Platforms</th>
																			<th>Status</th>
																			<th>Team</th>
																			<th>Date</th>
																			<th>Progress</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td class="min-w-175px p-2">
																				<div class="position-relative ps-6 pe-3 py-2">
																					<div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>
																					<a href="#" class="mb-1 text-gray-900 text-hover-primary fw-bold">#2131 Nombre Apellido</a>
																					<div class="fs-7 text-muted fw-bold">Creada 01.01.24</div>
																				</div>
																			</td>
																			<td class="p-2">
																				<!--begin::Icons-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 text-hover-primary fw-bold">Nombre Movimiento</a>
																				</div>
																				<!--end::Icons-->
																				<div class="fs-7 text-muted fw-bold">Atributo 1, Atributo 2, Atributo 3</div>
																			</td>
																			<td class="p-2">
																				<div class="d-flex gap-2">
																					<span class="badge badge-light-success">Estado Flujo 1</span>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Flujo 1</div>
																				
																			</td>
																			<td class="min-w-150px p-2">
																				<div class="mb-2 fw-bold">24 Ene 24 - 26 Ene 24</div>
																				<div class="fs-7 fw-bold text-muted">Rango de Fecha</div>
																			</td>
																			<td class="min-w-125px p-2">
																				<!--begin::Team members-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 fw-bold">Nombre CC</a>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Centro de Costo asociado</div>
																			</td>

																			<td class="min-w-125px p-2">
																				<!--begin::Team members-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 fw-bold">Usuario 1</a>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Solicitado por</div>
																			</td>
																			<td class="text-end p-2">
																				<div class="btn-group btn-group-sm" role="group">
																					<a class="ver btn btn-success p-1" data-bs-toggle="modal" data-bs-target="#registrar" info="1">
																						<i class="ki-duotone ki-check-circle fs-2hx"> 
																							<span class="path1"></span>
																							<span class="path2"></span>
																						</i>
																					</a>
																					<a class="editar btn btn-danger p-1" data-bs-toggle="modal" data-bs-target="#registrar" info="1">
																						<i class="ki-duotone ki-cross-circle fs-2hx"> 
																							<span class="path1"></span>
																							<span class="path2"></span>
																						</i>
																					</a>
																				</div>
																				<button type="button" class="btn btn-icon btn-sm btn-light btn-active-dark w-25px h-25px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Historial">
																					<i class="ki-duotone ki-black-right fs-2 text-muted"></i>
																				</button>
																			</td>
																		</tr>
																		<tr>
																			<td class="min-w-175px p-2">
																				<div class="position-relative ps-6 pe-3 py-2">
																					<div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-warning"></div>
																					<a href="#" class="mb-1 text-gray-900 text-hover-primary fw-bold">#3213 Jose Carrera</a>
																					<div class="fs-7 text-muted fw-bold">Creada 24.01.24</div>
																				</div>
																			</td>
																			<td class="p-2">
																				<!--begin::Icons-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 text-hover-primary fw-bold">Nombre Movimiento</a>
																				</div>
																				<!--end::Icons-->
																				<div class="fs-7 text-muted fw-bold">Atributo 1, Atributo 2, Atributo 3</div>
																			</td>
																			<td class="p-2">
																				<div class="d-flex gap-2">
																					<span class="badge badge-light-success">Estado Flujo 2</span>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Flujo 2</div>
																				
																			</td>
																			<td class="min-w-150px p-2">
																				<div class="mb-2 fw-bold">20 Ene 24 - 26 Ene 24</div>
																				<div class="fs-7 fw-bold text-muted">Rango de Fecha</div>
																			</td>
																			<td class="min-w-125px p-2">
																				<!--begin::Team members-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 fw-bold">Nombre CC</a>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Centro de Costo asociado</div>
																			</td>

																			<td class="min-w-125px p-2">
																				<!--begin::Team members-->
																				<div class="d-flex gap-2">
																					<a href="#" class="mb-1 text-gray-900 fw-bold">Usuario 2</a>
																				</div>
																				<!--end::Team members-->
																				<div class="fs-7 fw-bold text-muted">Solicitado por</div>
																			</td>
																			<td class="text-end p-2">
																				<div class="btn-group btn-group-sm" role="group">
																					<a class="ver btn btn-success p-1" data-bs-toggle="modal" data-bs-target="#registrar" info="1">
																						<i class="ki-duotone ki-check-circle fs-2hx"> 
																							<span class="path1"></span>
																							<span class="path2"></span>
																						</i>
																					</a>
																					<a class="editar btn btn-danger p-1" data-bs-toggle="modal" data-bs-target="#registrar" info="1">
																						<i class="ki-duotone ki-cross-circle fs-2hx"> 
																							<span class="path1"></span>
																							<span class="path2"></span>
																						</i>
																					</a>
																				</div>
																				<button type="button" class="btn btn-icon btn-sm btn-light btn-active-dark w-25px h-25px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Historial">
																					<i class="ki-duotone ki-black-right fs-2 text-muted"></i>
																				</button>
																			</td>
																		</tr>
																		
																	</tbody>
																	<!--end::Table-->
															</table>
															<!--end::Table-->
														</div>

														<div class="tab-pane fade" id="tabulador2">
															TERMINADAS
														</div>

														
													</div>

													
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Table Widget 3-->
    </div>
    
</div>
@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}'
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

@endpush