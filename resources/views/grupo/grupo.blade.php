@extends('layout.main')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
@endpush


@section('main-content')
<!--begin::Toolbar-->
@include('layout.toolbar', ['titulo' => $titulo])
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
				@include('grupo.componente.tarjetagrupo', ['datosgrupo'=> $dato])
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

<!--begin::Modal - Update role-->
@include('grupo.componente.modalEditarGrupo')
<!--end::Modal - Update role-->

@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}'
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <script src="{{ asset('js/eventos/grupo/update-grupo.js?id=3') }}"></script>
@endpush