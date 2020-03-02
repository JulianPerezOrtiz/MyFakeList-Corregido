
function obtener_registros(texto)
{
    $.ajax({
        url : './index.php',
        type : 'GET',
        dataType : 'html',
        data : { texto: texto,
            ope: "busqueda",
            con: "Serie"
        },
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