
function compruebaNick(txt){

    $.ajax({
        url : './index.php',
        method: 'POST',
        data : {
            txt : txt,
            ope : "comNick",
            con : "Usuario"
        },
    })
        .done(function (data) {
            if (data === "repetidoNick") {
                $(".rep1").removeAttr("hidden");
                $("#env").prop("disabled","e")
            } else {
                $(".rep1").prop("hidden","e");
                $("#env").removeAttr("disabled")
            }

        })
}
function compruebaMail(txt, ope){
    $.ajax({
        url : './index.php',
        method: 'POST',
        data : {
            txt : txt,
            ope : "comMail",
            con : "Usuario"
        },
    })
        .done(function (data) {
            if (data === "repetidoMail") {
                $(".rep2").removeAttr("hidden");
                $("#env").prop("disabled","e")
            } else {
                $(".rep2").prop("hidden","e");
                $("#env").removeAttr("disabled")
            }

        })
}

$(document).ready(function () {
    $(".nick").keyup(function () {
        var txt = $(this).val();
        compruebaNick(txt);

    });
    $(".mail").keyup(function () {
        var txt = $(this).val();
        var ope = "mail";
        compruebaMail(txt, ope);

    });


});