@if ($credenciales['Flujo']['puedeVer'])
    <!--begin::Content-->
    @if ($credenciales['Flujo']['puedeRegistrar'])
        <a id="addBtnMovimiento" type="button" class="btn btn-sm btn-success float-end mx-2" href="{{ route('RegistrarFlujo') }}" style="z-index: 10; position: relative;">
            Registrar
        </a>  
    @endif

    <!--begin::Tabla Flujo-->
    @include('flujo.componente.tablaFlujo')
    <!--end::Tabla Flujo-->

    <!--end::Content-->


    @if ($credenciales['Flujo']['puedeEditar'] || $credenciales['Flujo']['puedeVer'])
        <!--begin::modal - Registrar Area-->
        @include('flujo.componente.modalEditarFlujo')
        <!--end::modal-->
    @endif

@else
    <script>
        window.location = '{{ route('Error404') }}';
    </script>
@endif