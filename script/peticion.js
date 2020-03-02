
function muestraMas(){
    $.ajax({
        url : './index.php',
        type:'POST',
        data: { ope: "capitulosAleatorios",
            con: "Serie"
        },
    })
        .done(function (data) {
            $("#ser").append(data);
        })
}

$(document).ready(function () {
    muestraMas();
    muestraMas();
    muestraMas();
    $(".add").click(function () {
        muestraMas();
    });


});



