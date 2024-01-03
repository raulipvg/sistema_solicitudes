var KTDraggableMultiple = {
    init: function () {
        !(function () {
            var e = document.querySelectorAll(".draggable-zone");
            if (0 === e.length) return !1;
            new Draggable.Sortable(e, { 
                draggable: ".draggable", 
                handle: ".draggable .draggable-handle", 
                mirror: { appendTo: "body", 
                constrainDimensions: !0 } });
        })();
    },
};
KTUtil.onDOMContentLoaded(function () {
    KTDraggableMultiple.init();

    $("#AddSubmitFlujo").on("click", function (e) {
        e.preventDefault();
        console.log("Nuevo FLujo oyeee")

        let lista = new Array();
        lista.Nombre = $("#NombreInput").val();
        lista.AreaId = $("#AreaIdInput").val();
        lista.GrupoId = $("#GrupoIdInput").val();
        lista.ordenFlujo= []
        
        var i=0;
        $("#nuevoFlujo .draggable").each(function (index) {    
            let info = $(this).attr("data-info");
            var ordenFlujo = {
                "Nivel": i,
                "EstadoFlujoId": $(this).attr("data-info") 
            }
            lista.ordenFlujo.push(ordenFlujo);
            i=i+1;
    
    
        });
        console.log(lista)
        return;
       
    });

});
