@if ($credenciales['Grupo']['puedeVer'])
	@extends('layout.main')

	@push('css')
	<link href='' rel='stylesheet' type="text/css"/>
	@endpush


	@section('main-content')
	<!--begin::Toolbar-->
	@include('layout.toolbar', ['titulo' => $titulo,
								'vista' => 1 ])
	<!--end::Toolbar-->
	<!--begin::Content-->
	<div class="flex-column-fluid">
		<!--begin::Content container-->
		<div id="contenedor" class="d-flex flex-column flex-column-fluid mx-6">
			<!--begin::Row-->
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
				@foreach ($datosgrupo as $dato )
				<!--begin::Col-->
				<div class="col-md-4">
					<!--begin::Card-->
					@include('grupo.componente.tarjetagrupo', ['grupo'=> $dato])
					<!--end::Card-->
				</div>
				<!--end::Col-->
				@endforeach
			</div>
			<!--end::Row-->
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->

	@if ($credenciales['Grupo']['puedeRegistrar'])
		<!--begin::Modal - Registrar Grupo-->
		@include('grupo.componente.modalRegistrarGrupo')
		<!--end::Modal - Registrar Grupo-->
	@endif

	@if($credenciales['Grupo']['puedeEditar'])
		<!--begin::Modal - Update role-->
		@include('grupo.componente.modalEditarGrupo')
		<!--end::Modal - Update role-->
	@endif

	@endsection

	@push('Script')
		<script>
			const GuardarGrupo = '{{ route("GuardarGrupo") }}';
			const VerGrupoEdit = '{{ route("VerGrupoEdit") }}';
			const EditarGrupoPrivilegio = '{{route("EditarGrupoPrivilegio")}}';
			const CambiarEstadoGrupo = '{{route("CambiarEstadoGrupo")}}';
			
			const credenciales= {!! json_encode($credenciales) !!};
		</script>

		<!--begin::Eventos de la pagina-->
		<script src="{{ asset('js/global/main.js?id=4') }}"></script>
		<script src="{{ asset('js/eventos/grupo/grupo.js?id=4') }}"></script>
		<script src="{{ asset('js/eventos/grupo/tarjeta_grupo.js?id=4') }}"></script>
		<script src="{{ asset('js/eventos/grupo/update-grupo.js?id=9') }}"></script>
		<!--end::Eventos de la pagina-->
		
	@endpush

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif