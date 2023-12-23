
<!DOCTYPE html>
<html lang="es">
	<!--begin::Head-->
	<head>
		<title>Camanchaca - Plataforma de Servicios Generales</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="es_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Camanchaca - Plataforma de Servicios Generales" />
		<meta property="og:site_name" content="Camanchaca" />
		<link rel="shortcut icon" href="{{ asset('img/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle-->
		<link href="{{ asset('css/plugins.bundle.css?id=1') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css?id=1') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->        
        <!-- begin::CSS de Vista -->
        @stack('css')
		<!-- end::CSS de Vista -->
    </head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
					<!--begin::Header container-->
					@include('layout.header')
					<!--end::Header container-->
				</div>
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Sidebar-->
					<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
						<!--begin::Logo-->
						<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
							<!--begin::Logo image-->
							<a href="{{ route('Home') }}">
								<img alt="Logo" src="{{ asset('img/logos/logo-cc-web.png') }}" class="h-50px app-sidebar-logo-default" />
								<img alt="Logo" src="{{ asset('img/logos/logo-cc-web-small.png') }}" class="h-40px app-sidebar-logo-minimize" />
							</a>
							<!--end::Logo image-->
							<!--begin::Sidebar toggle-->
							
							<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
								<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Sidebar toggle-->
						</div>
						<!--end::Logo-->
						<!--begin::sidebar menu-->

							@include('layout.asidemenu')

						<!--end::sidebar menu-->
					</div>
					<!--end::Sidebar-->

					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							@yield('main-content')
						</div>
						<!--begin::Footer-->
						@include('layout.footer')
						<!--end::Footer-->
					</div>
					<!--end:::Main-->

				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->

		<script>var hostUrl = "assets/";</script>

		<!--begin::Global Javascript Bundle-->
		<script src="{{ asset('js/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('js/passive_events.js') }}"></script>
		<!--end::Global Javascript Bundle-->


		@stack('Script')
		
		
	</body>
	<!--end::Body-->
</html>