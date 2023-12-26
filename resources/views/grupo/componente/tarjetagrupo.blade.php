                                            <div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2 class="text-capitalize">{{ $grupo->Nombre }} </h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-1">Total de Usuarios: {{ $grupo->usuarios_count }}</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
                                                        @foreach ($grupo->Privilegios as $privilegio )
															@php
																$aux= $privilegio->pivot->Ver+$privilegio->pivot->Registrar+$privilegio->pivot->Editar+$privilegio->pivot->Eliminar;
																$text='';
																if($privilegio->pivot->Ver == 1){
																	$text='Ver ';
																}
																if($privilegio->pivot->Registrar == 1){
																	$text= $text.' Registrar';
																}
																if($privilegio->pivot->Editar == 1){
																	$text= $text.' Editar';
																}
																if($privilegio->pivot->Eliminar == 1){
																	$text= $text.' Eliminar';
																}																
															@endphp
															@if( $aux >0 )
																<div class="d-flex align-items-center py-2">
																	<span class="bullet bg-dark me-3"></span>{{ $privilegio->Nombre}} : {{$text}}
																</div>
															@endif
                                                        @endforeach
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="d-flex justify-content-center card-footer flex-wrap pt-0">
                                                    @if ($flag == 1)
                                                    <button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" data-info="{{ $grupo->Id }}">Editar Grupo</button>
                                                    @elseif ($flag == 2 )
                                                    <a href="{{route('VerGrupo', ['id' => $grupo->Id]) }}" class="btn btn-light btn-active-dark my-1 me-2" data-info="{{ $grupo->Id }}">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" data-info="{{ $grupo->Id }}">Editar Grupo</button>
                                                    @endif
													
												</div>
												<!--end::Card footer-->
											</div>
