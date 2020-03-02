function setEst(usu, se) {

    $.ajax({

        url: './index.php',
        type: 'POST',
        data: {
            usu : usu,
            se : se,
            ope : "addSer",
            con : "Serie"

        },
    })
        .done(function (data) {

            location.reload();
        })

}
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
        },

    })

}
function borraSeUsu(usu, se){

    $.ajax({
        url : './index.php',
        type : 'POST',
        data : {
            usu : usu,
            se : se,
            ope : "delSer",
            con : "Serie"
        },
    })
        .done(function (data) {
            location.reload();
        })
}
function modEst(usu, se, est){
    $.ajax({
        url : './index.php',
        type : 'POST',
        data : {
            usu : usu,
            se : se,
            est : est,
            ope : "modStatus",
            con : "Serie"
        }
    })
        .done(function () {
            location.reload();
        })
}
function modFav(usu, se, opeS){
    $.ajax({
        url : './index.php',
        type: 'POST',
        data : {
            usu : usu,
            se : se,
            opeS : opeS,
            ope : "favorito",
            con : "Serie"
        }
    })
        .done(function () {
            location.reload();
        })
}
$(document).ready(function () {
    $(".selEst").focusout(function () {
        var sts = $(this).val();
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        if (sts === "Para Ver") {
            sts = "Para_ver";
        }
        modEst(usu, se,sts);



    });
    // añade la serie a la lista de seguimiento del usuario
    $("#add").click(function () {
        var usu = $(this).data("usu");
        var se = $(this).data("se");

        setEst(usu,se);

    });

    //sube un capitulo visto
    $( ".fa-plus-circle" ).click(function() { // repetida de lista;
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        var capTo = $(this).data("capmax");
        subeCa(usu, se, capTo);
    });
    // sube la puntuacion
    $(".score").focusout(function () { // repetida de lista pero con cosas borradas
        var score = $(this).val();
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        if (!isNaN(score)) {
            subeSc(usu,se,score);
        }



    });
    $("#btnd").click(function () {

        var usu = $(this).data("usu");
        var se = $(this).data("se");
        var ti = $(this).data("til");
        $("#staticBackdrop").modal();
        $("#md").text(ti);
        $("#del").click(function () {
            borraSeUsu(usu, se);
        })

    });
    $("#fav").click(function () {
        var fav = $(this).data("ope");
        var usu = $(this).data("usu");
        var se = $(this).data("se");
        modFav(usu,se, fav);
    });
});
