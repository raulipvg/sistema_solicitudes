						<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
							<!--begin::Menu wrapper-->
							<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
								<!--begin::Scroll wrapper-->
								<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
									<!--begin::Menu-->
									<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
										<!--begin:Menu link-->
										<div class="menu-item">
											<a class="menu-link  {{ request()->routeIs('Home','Solicitud') ? 'active' : '' }}" href="{{route('Solicitud')}}">
												<span class="menu-icon">
													<i class="ki-duotone ki-home fs-2">
													</i>
												</span>
												<span class="menu-title">Home</span>
											</a>
										<!--end:Menu link-->
										</div>
										<!--begin:Menu link-->
										<div class="menu-item">
											<a class="menu-link  {{ request()->routeIs('Consolidado')? 'active' : '' }}" href="{{route('Consolidado')}}">
												<span class="menu-icon">
													<i class="ki-duotone ki-sort fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>
												</span>
												<span class="menu-title">Consolidado</span>
											</a>
										<!--end:Menu link-->
										</div>
										@if( collect($accesoLayout)->where('PrivilegioId', 10)->pluck('Ver')->first() == 1 || collect($accesoLayout)->where('PrivilegioId', 7)->pluck('Ver')->first())
										<!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion pt-2 {{ request()->routeIs('Flujo', 'RegistrarFlujo','InicioMovimientoAtributo') ? 'here show' : '' }}">
											
																													<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-icon">
													<i class="ki-duotone ki-element-11 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>
												</span>
												<span class="menu-title">General</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											@if( collect($accesoLayout)->where('PrivilegioId', 7)->pluck('Ver')->first() == 1 )

											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
											
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('Flujo','RegistrarFlujo') ? 'active' : '' }}" href="{{route('Flujo')}}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Flujos</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->												
											</div>
											<!--end:Menu sub-->
											@endif
											@if( collect($accesoLayout)->where('PrivilegioId', 10)->pluck('Ver')->first() == 1 )

											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('InicioMovimientoAtributo') ? 'active' : '' }}" href="{{route('InicioMovimientoAtributo')}}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Movimientos</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->												
											</div>
											<!--end:Menu sub-->
											@endif
										</div>
										<!--end:Menu item-->
										@endif
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu content-->
											<div class="menu-content">
												<span class="menu-heading fw-bold text-uppercase fs-7">Administración</span>
											</div>
											<!--end:Menu content-->
										</div>
										<!--end:Menu item-->
										@if( collect($accesoLayout)->where('PrivilegioId', 1)->pluck('Ver')->first() == 1 || collect($accesoLayout)->where('PrivilegioId', 2)->pluck('Ver')->first())
										<!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('Usuario','Grupo') ? 'here show' : '' }}">
											<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-icon">
													<i class="ki-duotone ki-address-book fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
												<span class="menu-title">Acceso</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												@if( collect($accesoLayout)->where('PrivilegioId', 1)->pluck('Ver')->first() == 1 )
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('Usuario') ? 'active' : '' }}" href="{{route('Usuario') }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Usuarios</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
												@endif
												@if( collect($accesoLayout)->where('PrivilegioId', 2)->pluck('Ver')->first() == 1 )
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('Grupo') ? 'active' : '' }}" href="{{route('Grupo') }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Grupos</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
												@endif											
											</div>
											<!--end:Menu sub-->
										</div>
										<!--end:Menu item-->
										@endif
										@if( collect($accesoLayout)->where('PrivilegioId', 3)->pluck('Ver')->first() == 1 ||
										collect($accesoLayout)->where('PrivilegioId', 5)->pluck('Ver')->first() == 1 ||
										collect($accesoLayout)->where('PrivilegioId', 6)->pluck('Ver')->first() == 1 ||
										collect($accesoLayout)->where('PrivilegioId', 8)->pluck('Ver')->first() == 1)
										<!--begin:Menu item-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('Empresa','Persona')? 'here show' : '' }}">
											<!--begin:Menu link-->
											<span class="menu-link">
												<span class="menu-icon">
													<i class="ki-duotone ki-address-book fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
												<span class="menu-title">General</span>
												<span class="menu-arrow"></span>
											</span>
											<!--end:Menu link-->
											<!--begin:Menu sub-->
											<div class="menu-sub menu-sub-accordion">
												@if( collect($accesoLayout)->where('PrivilegioId', 3)->pluck('Ver')->first() == 1 )
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('Empresa') ? 'active' : '' }}" href="{{route('Empresa') }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Empresa</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
												@endif
												@if( collect($accesoLayout)->where('PrivilegioId', 5)->pluck('Ver')->first() == 1 )
												<!--begin:Menu item-->
												<div class="menu-item">
													<!--begin:Menu link-->
													<a class="menu-link {{ request()->routeIs('Persona') ? 'active' : '' }}" href="{{route('Persona') }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Persona</span>
													</a>
													<!--end:Menu link-->
												</div>
												<!--end:Menu item-->
												@endif
											</div>
											<!--end:Menu sub-->
										</div>
										<!--end:Menu item-->
										@endif
									</div>
									<!--end::Menu-->
								</div>
								<!--end::Scroll wrapper-->
							</div>
							<!--end::Menu wrapper-->
						</div>