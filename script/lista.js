function subeCa(usu, se, capTo) {

    $.ajax({
        url: './index.php',
        type: `POST`,
        data: { usu : usu,
                se : se,
                capmax : capTo,
                ope : "up",
                con : "Serie"
        },

    })
        .done(function (data) {
            $("#cap"+se).html(data);
        })
}
function subDes(usu, se, text) {

    $.ajax({
        url: './index.php',
        type: 'POST',
        data: {
            usu : usu,
            se : se,
            text : text,
            ope : "comentario",
            con : "Serie"
        }
    })


}
function subeSc(usu, se, sc){
    $.ajax({
        url: './index.php',
        type: 'POST',
        data: {
            usu : usu,
            se : se,
            sc : sc,
            ope : "score",
            con : "Serie"
        }

    })

}
$(document).ready(function () {

    // para subir un capitulo visto
    $( ".fa-plus-circle" ).click(function() {
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        var capTo = $(this).data("capmax");
        subeCa(usu, se, capTo);
    });
    // intento de modal que no se usa
    $(".edit").click(function () {
        var ti = $(this).data("ti");
        var idse = $(this).data("se");
        var idusu = $(this).data("usu");
        var capA = $("#cap"+idse).text();
        var des = $(this).data("rew");

        $('.modal-title').text(ti);
        $('#mdes').text(des);
        $('.modal').modal('show')
    });

    // para la puntuacion
    $(".sco1").click(function () {
        var id = $(this).data("idsc");
        $("#sco1"+id).hide();
        $("#sco"+id).removeAttr("hidden");

    });
    // para la puntuacion
    $(".score").focusout(function () {
        var score = $(this).val();
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        var id = $(this).data("idscore");
        if (score !== "-") {

            subeSc(usu,se,score);

        }
        $("#sco1"+id).text(score);
        $("#sco"+id).prop("hidden","e");
        $("#sco1"+id).show();

    }); // para los comentarios de la serie
    $(".spanre").click(function () {
        var text1 = $(this).text();
        var id = $(this).data("ids");
        $("#s"+id).hide();

        $("#txt"+id).val(text1);
        $("#txt"+id).removeAttr("hidden");

    });
    $(".tex1").focusout( function () {
        var id = $(this).data("idt");
        var text =$(this).val();
        $("#s"+id).text(text);
        $("#txt"+id).prop("hidden","e");
        $("#s"+id).show();

        var usu = $(this).data("usu");
        var se = $(this).data("se");
        if (text !== "--- ") {

            subDes(usu, se, text);
        }

    });


});
