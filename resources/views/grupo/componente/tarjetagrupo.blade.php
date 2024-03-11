                                            <div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header bg-dark">
													<!--begin::Card title-->
													<div class="card-title">
														<h2 class="text-white text-uppercase">{{ $grupo->Nombre }} </h2>
													</div>
													<!--end::Card title-->
													<div class="card-toolbar">
													@php
														$className = ($credenciales['Grupo']['puedeEliminar'])? 'estado-grupo': 'disabled';
													@endphp

													@if($grupo->Enabled ==1 )
														<button class="btn btn-sm btn-success {{ $className }} fs-7 text-uppercase justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Grupo" data-info="{{ $grupo->Id }}">
															<span class="indicator-label">ACTIVO</span>
															<span class="indicator-progress">
																<span class="spinner-border spinner-border-sm align-middle"></span>
															</span>
														</button>
													@else
														<button class="btn btn-warning fs-7 {{ $className }} text-uppercase  justify-content-center p-1 w-70px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Grupo" data-info="{{ $grupo->Id }}">
															<span class="indicator-label">INACTIVO</span>
															<span class="indicator-progress">
																<span class="spinner-border spinner-border-sm align-middle"></span>
															</span>
													</button>
													@endif
													
													</div>
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-1">Total de Usuarios: {{ $grupo->usuarios_count }}</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
														@php	
															if (!function_exists('DivHtml')) {
																function DivHtml($texto){ return '<div class="bullet-dot bg-success mx-1"></div><span class="me-2">'.$texto.'</span>'; }
															}
														@endphp
                                                        @foreach ($grupo->Privilegios as $privilegio )
															@php 
																$aux= $privilegio->pivot->Ver+$privilegio->pivot->Registrar+$privilegio->pivot->Editar+$privilegio->pivot->Eliminar;															
															@endphp

															@if( $aux >0 )																
																<div class="d-flex align-items-center mb-1">
																	<div class="bullet bg-dark me-3"></div>
																	<div class="text-gray-800 fw-bold  me-4">{{ $privilegio->Nombre}}:</div>
																	 	@if($privilegio->Id < 12)  
																				{!! ($privilegio->pivot->Ver === 1 )? DivHtml('Ver'): null !!}
																				{!! ($privilegio->pivot->Registrar === 1)?  DivHtml('Registrar'):null !!}
																				{!! ($privilegio->pivot->Editar === 1)? DivHtml('Editar'):null !!}
																				{!! ($privilegio->pivot->Eliminar === 1)? DivHtml('Eliminar'):null !!}
																		@elseif ($privilegio->Id === 12 )
																				{!! ($privilegio->pivot->Ver === 1 )? DivHtml('Ver Grupos'): null !!}
																				{!! ($privilegio->pivot->Registrar === 1)?  DivHtml('Ver Todas'):null !!}
																				{!! ($privilegio->pivot->Editar === 1)? DivHtml('Realizar Solicitud'):null !!}
																				{!! ($privilegio->pivot->Eliminar === 1)? DivHtml('Aprobador'):null !!}
																		@elseif ($privilegio->Id === 13 )
																				{!! ($privilegio->pivot->Ver === 1 )? DivHtml('Ver Consolidado'): null !!}
																				{!! ($privilegio->pivot->Registrar === 1)?  DivHtml('Ver por Centro de Costo'):null !!}
																				{!! ($privilegio->pivot->Editar === 1)? DivHtml('Ver por Movimiento'):null !!}
																				{!! ($privilegio->pivot->Eliminar === 1)? DivHtml('Cerrar Mes'):null !!}
																		@endif
																</div>
															@endif															
                                                        @endforeach
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="d-flex justify-content-center card-footer flex-wrap pt-0">
                                                    @if ($flag == 1 && $credenciales['Grupo']['puedeEditar'])
                                                    <button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" data-info="{{ $grupo->Id }}">Editar Grupo</button>
                                                    @elseif ($flag == 2 && $credenciales['Grupo']['puedeEditar'])
                                                    <a href="{{route('VerGrupo', ['id' => $grupo->Id]) }}" class="btn btn-light btn-active-dark my-1 me-2" data-info="{{ $grupo->Id }}">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" data-info="{{ $grupo->Id }}">Editar Grupo</button>
                                                    @endif
													
												</div>
												<!--end::Card footer-->
											</div>
