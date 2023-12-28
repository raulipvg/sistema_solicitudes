<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
						<!--begin::Sidebar mobile toggle-->
						<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
							<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
								<i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
						</div>
						<!--end::Sidebar mobile toggle-->
						<!--begin::Mobile logo-->
						<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
							<a href="{{ route('Home') }}" class="d-lg-none">
								<img alt="Logo" src="{{ asset('img/logos/logo-cc-web-small-dark.png') }}" class="h-35px" />
							</a>
						</div>
						<!--end::Mobile logo-->
						<!--begin::Header wrapper-->
						<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
							<h1 class="page-heading d-flex text-gray-600 fw-bold fs-3 flex-column justify-content-center my-0">Plataforma de Servicios Generales</h1>
							
							<!--begin::Navbar-->
							<div class="app-navbar flex-shrink-0">
								
								<!--begin::User menu-->
								<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
									<!--begin::Menu wrapper-->
									<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<img src="{{ asset('img/avatars/blank.png') }}" class="rounded-3" alt="user" />
									</div>
									<!--begin::User account menu-->
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-0 fs-6 w-275px" data-kt-menu="true">
										<!--begin::Menu item-->
										<div class="menu-item px-2">
											<div class="menu-content d-flex align-items-center px-1">
												<!--begin::Avatar-->
												<div class="symbol symbol-50px me-5">
													<img alt="Logo" src="{{ asset('img/avatars/blank.png') }}" />
												</div>
												<!--end::Avatar-->
												<!--begin::Username-->
												<div class="d-flex flex-column">
													<div class="fw-bold d-flex align-items-center fs-5">@if( auth()->check() ) {{ auth()->user()->persona->Nombre }} {{auth()->user()->persona->Apellido}}@else Inicia sesión @endif
													<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2 text-uppercase ">@if( auth()->check() ) {{auth()->user()->grupos[0]->Nombre}} @else Grupo @endif</span></div>
													<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">@if( auth()->check() ) {{ auth()->user()->Email }} @else correo@correo.com @endif</a>
												</div>
												<!--end::Username-->
											</div>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu separator-->
										<div class="separator"></div>
										<!--end::Menu separator-->
										<!--begin::Menu item-->
										<div class="menu-item px-2">
											<a href="#" class="menu-link px-5">Mi Perfil</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu separator-->
										<div class="separator"></div>
										<!--end::Menu separator-->
										<!--begin::Menu item-->
										<div class="menu-item px-2">
											<a href="{{route('CerrarSesion')}}" class="menu-link px-5">Cerrar Sesión</a>
										</div>
										<!--end::Menu item-->
									</div>
									<!--end::User account menu-->
									<!--end::Menu wrapper-->
								</div>
								<!--end::User menu-->
								
								<!--begin::Aside toggle-->
								<!--end::Header menu toggle-->
							</div>
							<!--end::Navbar-->
						</div>
						<!--end::Header wrapper-->
					</div>