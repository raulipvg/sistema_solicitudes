                                                	<!--begin::Form-->
                                                    <form id="kt_modal_update_role_form" class="form" action="#">
														<div class="modal-body">
															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
																<div class="fv-row px-1">
		                                                            <div id="AlertaErrorGrupo" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true"></div>
		                                                        </div>	
	                                                        	<!--begin::Input group-->
																<div class="fv-row mb-2 px-1">
																	<!--begin::Label-->
																	<label class="fs-5 fw-bold form-label mb-2" for="NombreGrupoInput">
																		<span class="required">Nombre del Grupo</span>
																	</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input id="NombreGrupoInput" class="form-control form-control-solid text-capitalize" placeholder="Ingrese nombre del Grupo" name="NombreGrupo"/>
																	<!--end::Input-->
																</div>
																<input hidden type="number" id="IdGrupoInput" name="IdGrupo" />
																<!--end::Input group-->
																<!--begin::Permissions-->
																<div class="fv-row">
																	<!--begin::Label-->
																	<span class="fs-5 fw-bold form-label mb-2">Privilegios del Grupo</label>
																	<!--end::Label-->
																	<!--begin::Table wrapper-->
																	<div class="">
																		<!--begin::Table-->
																		<table id="tabla-privilegios" class="table align-middle table-row-dashed fs-6 gy-5">
																			<!--begin::Table body-->
																			<tbody id="tabla-privilegios-body" class="text-gray-600 fw-semibold">
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
																						<label for="kt_roles_select_all" class="form-check form-check-sm form-check-custom form-check-solid me-9">
																							<input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
																							<span class="form-check-label" for="kt_roles_select_all">Seleccionar Todo</span>
																						</label>
																						<!--end::Checkbox-->
																					</td>
																				</tr>
																				<!--end::Table row-->
																				
	                                                                            @foreach ($privilegios as $privilegio)
																					@php
																						if($privilegio->Id == 12){
																							$a1= "Ver Grupos";
																							$a2= "Ver Todas";
																							$a3= "Realizar Solicitud";
																							$a4= "Aprobador";
																						}else if( $privilegio->Id == 13){
																							$a1= "Ver";
																							$a2= "Ver por Centro de Costo";
																							$a3= "Ver por Movimiento";
																							$a4= "Cerrar Mes";
																						}
																					@endphp
	                                                                                <!--begin::Table row-->
	                                                                                <tr>
	                                                                                    <!--begin::Label-->
	                                                                                    <td class="text-gray-800 p-2">{{ $privilegio->Nombre}}
	                                                                                    <input hidden type="number" id="IdPrivilegio{{$privilegio->Id}}" name="GrupoPrivilegio[{{$privilegio->Id}}][Id]" value="" />
	                                                                                    </td>   
	                                                                                    <!--end::Label-->                                                                                  
	    
	                                                                                    <!--begin::Input group-->
	                                                                                    <td class="p-2">
	                                                                                        <!--begin::Wrapper-->
	                                                                                        <div class="row">
	                                                                                            
	                                                                                            <!--begin::Checkbox-->
	                                                                                            <label class="col-3 form-check form-check-sm form-check-custom form-check-solid">
	                                                                                                <input class="form-check-input" type="checkbox" value="1" name="GrupoPrivilegio[{{$privilegio->Id}}][Ver]"/>
	                                                                                                <span class="form-check-label">@if( $privilegio->Id >= 12 ) {{ $a1 }} @else Ver @endif</span>
	                                                                                            </label>
	                                                                                            <!--end::Checkbox-->
	                                                                                            <!--begin::Checkbox-->
	                                                                                            <label class="col-3 form-check form-check-sm form-check-custom form-check-solid ">
	                                                                                                <input class="form-check-input" type="checkbox" value="1" name="GrupoPrivilegio[{{$privilegio->Id}}][Registrar]"/>
	                                                                                                <span class="form-check-label">@if( $privilegio->Id >= 12 ) {{ $a2 }} @else Registrar @endif</span>
	                                                                                            </label>
	                                                                                            <!--end::Checkbox-->
	                                                                                            <!--begin::Checkbox-->
	                                                                                            <label class="col-3 form-check form-check-custom form-check-solid ">
	                                                                                                <input class="form-check-input" type="checkbox" value="1" name="GrupoPrivilegio[{{$privilegio->Id}}][Editar]"/>
	                                                                                                <span class="form-check-label">@if( $privilegio->Id >= 12  ){{ $a3 }}  @else Editar @endif</span>
	                                                                                            </label>
	                                                                                            <!--end::Checkbox-->
	                                                                                            <!--begin::Checkbox-->
	                                                                                            <label class="col-3 form-check form-check-custom form-check-solid">
	                                                                                                <input class="form-check-input" type="checkbox" value="1" name="GrupoPrivilegio[{{$privilegio->Id}}][Eliminar]"/>
	                                                                                                <span class="form-check-label">@if( $privilegio->Id >= 12 ){{ $a4 }}  @else Eliminar @endif</span>
	                                                                                            </label>
	                                                                                            <!--end::Checkbox-->
	                                                                                        </div>
	                                                                                        <!--end::Wrapper-->
	                                                                                    </td>
	                                                                                    
	                                                                                    <!--end::Input group-->
	                                                                                   
	                                                                                </tr>
	                                                                                <!--end::Table row-->
	                                                                            @endforeach																		
																	
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
														</div>

														<div class="modal-footer bg-light p-2">
															<!--begin::Actions-->
															<div class="text-center">
																<button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Cancelar</button>
																<button type="submit" class="btn btn-dark" data-kt-roles-modal-action="submit">
																	<span class="indicator-label">Actualizar</span>
																	<span class="indicator-progress">Espere... 
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																</button>
															</div>
															<!--end::Actions-->
														</div>

													</form>
													<!--end::Form-->
                                                    