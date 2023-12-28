<!DOCTYPE html>
<html lang="es">
	<!--begin::Head-->
	<head>
<base href="../../" />
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
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('css/plugins.bundle.css?id=1') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css?id=1') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>
                body { 
                    background-image: url("{{ asset('img/error/bg4-dark.jpg') }}") 
                }
            </style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Signup Welcome Message -->
			<div class="d-flex flex-column flex-center flex-column-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-center text-center p-10">
					<!--begin::Wrapper-->
					<div class="card card-flush w-lg-650px py-5">
						<div class="card-body py-15 py-lg-20">
							<!--begin::Title-->
							<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Error de Sistema</h1>
							<!--end::Title-->
							<!--begin::Text-->
							<div class="fw-semibold fs-6 text-gray-500 mb-7">¡Algo salió mal! Por favor!, inténtalo de nuevo más tarde.</div>
							<!--end::Text-->
							<!--begin::Illustration-->
							<div class="mb-3">
								<img src="{{ asset('img/error/500-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="" />
							</div>
							<!--end::Illustration-->
							<!--begin::Link-->
							<div class="mb-0">
								<a href="{{ route('Home')}}" class="btn btn-sm btn-dark">Volver al Inicio</a>
							</div>
							<!--end::Link-->
						</div>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Authentication - Signup Welcome Message-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="{{ asset('js/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>