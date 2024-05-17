@component('mail::message')
# Solicitud N° {{$solicitud->Id}}

Tiene una solicitud a gestionar.
@component('mail::panel')
    @component('mail::table')
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Solicitud para:</td>
            <td class="p-1 upper-case">{{$solicitud->NombreCompleto}} - {{$solicitud->RUT}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Centro de costo:</td>
            <td class="p-1 upper-case">{{$solicitud->CentroCosto}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Movimiento:</td>
            <td class="p-1 upper-case">{{$solicitud->Movimiento}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Atributos:</td>
            <td class="p-1 upper-case"> 
                @foreach ( $solicitud->Atributos as $atributo )
                    {{$atributo->Nombre}}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Solicitado por:</td>
            <td class="p-1 upper-case">{{$solicitud->NombreSolicitante}}</td>
        </tr>        
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Fecha:</td>
            <td class="p-1">{{\Carbon\Carbon::parse($solicitud->FechaUpdated)->format('d-m-Y H:i')}}</td>
        </tr>
        <tr>
            <td class="p-1 text-gray-500 fw-bold w-30">Estado Actual:</td>
            <td class="p-1 upper-case">{{$solicitud->EstadoFlujo}}</td>
        </tr>      
    @endcomponent
    
@endcomponent


@component('mail::button', ['url' => $url])
PLATAFORMA
@endcomponent
   
@endcomponent