//$(obtener_registros());



function obtener_registros(texto)
{
    $.ajax({
        url : 'consulta.php',
        type : 'POST',
        dataType : 'html',
        data : { texto: texto },
    })

        .done(function(resultado){
            $("#resultadoBus").html(resultado);
        })
}

$(document).on('keyup', '#busqueda', function()
{
    var valorBusqueda=$(this).val();
        if (valorBusqueda!=""){
            obtener_registros(valorBusqueda);
        }
        else {
            $("#resultadoBus").html("");
        }


});
