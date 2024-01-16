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
															<div class="separator separator-dashed my-1"></div>
															<!--end::Separator-->

															
															<!--begin::Table-->
															<table id="tabla-solicitudes-terminadas" class="table table-row-dashed align-middle fs-6 gy-4 my-0 pb-3 table-hover" data-kt-table-widget-3="all">
																	<thead class="d-none">
																		<tr>
																			<th>Col1</th>
																			<th>Platforms</th>
																			<th>Status</th>
																			<th>Team</th>
																			<th>Date</th>
																			<th>Progress</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		
																		
																	</tbody>
																	<!--end::Table-->
															</table>
															<!--end::Table-->