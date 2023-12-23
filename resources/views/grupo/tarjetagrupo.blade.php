                                            <div class="card card-flush h-md-100">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>{{ $datosgrupo->Nombre }}</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-1">
													<!--begin::Users-->
													<div class="fw-bold text-gray-600 mb-1">Total de Usuarios: 5</div>
													<!--end::Users-->
													<!--begin::Permissions-->
													<div class="d-flex flex-column text-gray-600">
                                                        @foreach ($datosgrupo->Privilegios as $privilegio )
                                                            <div class="d-flex align-items-center py-2">
                                                                <span class="bullet bg-dark me-3"></span>{{ $privilegio->Nombre}}
                                                            </div>
                                                        @endforeach
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="d-flex justify-content-center card-footer flex-wrap pt-0">
                                                    @if ($datosgrupo->flag == 1)
                                                    <button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
                                                    @elseif ($datosgrupo->flag == 2 )
                                                    <a href="{{route('VerGrupo') }}" class="btn btn-light btn-active-dark my-1 me-2">Ver Grupo</a>
													<button type="button" class="btn btn-light btn-active-light-warning my-1 editar-grupo" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Editar Grupo</button>
                                                    @endif
													
												</div>
												<!--end::Card footer-->
											</div>