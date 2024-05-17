@component('mail::message')
# Estimados Señores Empresa Portuaria Iquique.

Se solicita autorización de ingreso.
@component('mail::panel')
    @component('mail::table')
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Nombre:</td>
            <td class="p-1 upper-case">{{$solicitud->NombreCompleto}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">RUT:</td>
            <td class="p-1 upper-case">{{$solicitud->RUT}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Autoriza:</td>
            <td class="p-1 upper-case">{{$solicitud->NombreAprobador}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Tipo de Ingreso:</td>
            <td class="p-1 upper-case">
                @foreach ( $solicitud->Atributos as $atributo )
                    {{$atributo->Nombre.', '.$atributo->FechaImprimir}}<br>
                @endforeach
            </td>
        </tr>        
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Cargo de Ingreso:</td>
            <td class="p-1 upper-case">Camanchaca o Externo</td>
        </tr>
    @endcomponent
    
@endcomponent

Atte,<br>
Camanchaca
    
@endcomponent