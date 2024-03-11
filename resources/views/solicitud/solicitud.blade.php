@extends('layout.main')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<link href="{{ asset('css/progressbar/estilo.css') }}" rel='stylesheet' type="text/css"/>
<style>
.flujo{
	cursor: pointer;
}
.btn-group button{
	min-width: 43.55px; 
	min-height: 39px;
}
.input-size{
	min-height: 57.55px!important;
}
</style>

@endpush


@section('main-content')
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content_container" class="container-fluid mt-2">
			<!--begin::Table Widget 3-->
			<div class="card card-flush h-xl-100 mx-2 my-4">
				<!--begin::Card header-->
				<div class="card-header bg-dark py-1">
					<!--begin::Tabs-->
					<div class="card-title m-0 gap-4 gap-lg-10 gap-xl-15 nav nav-tabs border-bottom-0" data-kt-table-widget-3="tabs_nav">
						<ul class="nav">
							<li class="nav-item">
								<a id="activas" class="nav-link btn btn-sm btn-color-white btn-active btn-active-white fw-bold px-4 me-1 active" data-bs-toggle="tab" href="#tabulador1">ACTIVAS</a>
							</li>
							<li class="nav-item">
								<a id="terminadas" class="nav-link btn btn-sm btn-color-white btn-active btn-active-white fw-bold px-4 me-1" data-bs-toggle="tab" href="#tabulador2">TERMINADAS</a>
							</li>
						</ul>
					</div>
					<!--end::Tabs-->
					@if ($credenciales['realizar'])
						<div class="card-toolbar my-0">
							<a id="NuevaSolicitud" href="#" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearSolicitud">Realizar Solicitud</a>
						</div>
					@endif
				</div>
				<!--end::Card header-->
				<!--begin::Card body-->
				<div class="card-body pt-1">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="tabulador1">
							@include('solicitud.componente.tablaSolicitudesActivas')
						</div>
						<div class="tab-pane fade" id="tabulador2">
							@include('solicitud.componente.tablaSolicitudesTerminadas')
						</div>
					</div>
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Table Widget 3-->
		</div>
		

	</div>

	<!--begin::modal - Historial Solicitud-->
	@include('solicitud.componente.modalHistorialSolicitud')
	<!--end::modal - Historial Solicitud-->

	@if ($credenciales['realizar'])
		<!--begin::modal - Realizar Solicitud-->
		@include('solicitud.componente.modalCrearSolicitud')
		<!--end::modal - Realizar Solicitud-->
	@endif
	

@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}';
		const DataTestSolicitud = '{{ route("DataTestSolicitud")}}';
		const getHistorial = '{{ route("getHistorial")}}';
		const VerMovimientoAtributo = '{{ route("VerMovimientoAtributo")}}';
		const RealizarSolicitud = '{{ route("RealizarSolicitud") }}';
		const AprobarSolicitud = '{{ route("AprobarSolicitud")}}';
		const RechazarSolicitud = '{{ route("RechazarSolicitud") }}';
		const VerTerminadas = '{{ route("VerTerminadas") }}';
		const VerActivas = '{{ route("VerActivas") }}';

		const solicitudeActivas = JSON.parse('{!! $solicitudes !!}');

		const credenciales= {!! json_encode($credenciales) !!};
		//console.log(msg.length)

		//console.log( solicitudeActivas)
		

    </script>    
     <!--begin::Datatables y Configuracion de la Tabla-->
	<script src="{{ asset('js/datatables/datatables.bundle.js?id=7') }}"></script>
    <script src="{{ asset('js/datatables/language/language_es.js?id=7') }}"></script>
	<script src="{{ asset('js/datatables/contenido/solicitud_activa.js?id=7') }}"></script>
	<script src="{{ asset('js/datatables/contenido/solicitud_terminada.js?id=7') }}"></script>
   
    <!--end::Datatables y Configuracion de la Tabla-->

	<!--begin::Eventos de la pagina-->
    <script src="{{ asset('js/global/main.js?id=7') }}"></script>
	@if($credenciales['aprobador'])
	<script src="{{ asset('js/eventos/solicitud/generales.js?id=7') }}"></script>
	@endif
	@if ($credenciales['realizar'])
	<script src="{{ asset('js/flatpickr/es.js?id=7') }}"></script>
	<script src="{{ asset('js/eventos/solicitud/crearsolicitud.js?id=7') }}"></script>
	@endif
	<script src="{{ asset('js/eventos/solicitud/historialsolicitud.js?id=7')}}"></script>
    <script src="{{ asset('js/eventos/solicitud/verflujo.js?id=7')}}"></script>

    <!--end::Eventos de la pagina-->
	
	


@endpush