@if ($credenciales['Area']['puedeVer'])
    <!--begin::Content-->
    @if ($credenciales['Area']['puedeRegistrar']) 
        <button id="AddBtn" type="button" class="btn btn-sm btn-success float-end mx-2" data-bs-toggle="modal" data-bs-target="#registrar" style="z-index: 10; position: relative;">
            Registrar
        </button>
    @endif
    <!--begin::Tabla Area-->
    @include('area.componente.tablaArea')
    <!--end::Tabla Area-->

    <!--end::Content-->

    @if ($credenciales['Area']['puedeRegistrar'] || $credenciales['Area']['puedeEditar'] || $credenciales['Area']['puedeVer'])
        <!--begin::modal - Registrar Area-->
        @include('area.componente.modalRegistarArea')
        <!--end::modal-->
    @endif

@endif