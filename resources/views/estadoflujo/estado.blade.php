@if ($credenciales['EstadoFlujo']['puedeVer'])
    <!--begin::Content-->
    @if ($credenciales['EstadoFlujo']['puedeRegistrar'])
        <button id="AddBtnEstado" type="button" class="btn btn-sm btn-success float-end mx-2" data-bs-toggle="modal" data-bs-target="#registrarEstado" style="z-index: 10; position: relative;">
            Registrar
        </button>
    @endif

    @include('estadoflujo.componente.tablaEstadoFlujo')
    <!--end::Content-->

    @if ($credenciales['EstadoFlujo']['puedeRegistrar'] || $credenciales['EstadoFlujo']['puedeEditar'] || $credenciales['EstadoFlujo']['puedeVer'])
        <!--begin::modal-->
        @include('estadoflujo.componente.modalRegistrarEstadoFlujo')
        <!--end::modal-->
    @endif

@endif