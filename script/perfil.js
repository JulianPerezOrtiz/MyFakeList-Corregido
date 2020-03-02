function subeText(usu, txt, ope1){

    $.ajax({

        url : './index.php',
        type: 'POST',
        data: {
            usu : usu,
            txt: txt,
            ope1: ope1,
            con: "Usuario",
            ope: "actuInfo"
        }
    })
        .done(function (data) {
            window.location = './index.php?ope=mostarPerfil&con=Usuario&id=' + data;
        })
}

$(document).ready(function () {
    $(".btn1").click(function () {
        $(".modal").modal('show');
    });

    $(".txt").focusout(function () {
        var usu = $(this).data("usu");
        var text = $(this).val();
        var ope1 = $(this).data("ope1");
        subeText(usu,text,ope1);


    });

});