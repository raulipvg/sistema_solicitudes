$(document).ready(function() {


    $('#MovimientoInput').on('select2:select', function (e) {
        var data = e.params.data;
        console.log('Elemento seleccionado:', data);
        console.log(data.id)
        var opcionOcultar = $(this).find('option[value="'+data.id+'"]');
        console.log(opcionOcultar)
        
        opcionOcultar.attr('disabled','disabled');
        opcionOcultar.hide();
        $(this).trigger('change');
        //$(this).select2('destroy')
        //$(this).select2();
      });

});