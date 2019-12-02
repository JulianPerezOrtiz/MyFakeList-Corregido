<?php
require_once("./controlSesion.php");
require_once("infoSeries.php");

$sesion = controlSesion::getInstancia();
    if (!($sesion->loged())){
        $visitante = true;
    } else {
        $visitante = false;
$user = $sesion->getUsu();
    }
?>
<html lang="en">
<head>
    <title>Menu</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="peticion.js"></script>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script>
        function muestraMas(){
            $.ajax({
                url : 'muestraCaps.php',
                type:'POST'
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

            
            
    </script>
</head>
<body>
<div class="container">
    <?php
    if ($visitante == false){
        require_once("./css/nav.php");

    } else {
        require_once("./css/navbarVisitante.php");
    }
    ?>



        <div id="resultadoBus">

        </div>

        <div id="ser">


        </div>
    <button type="button" class="btn btn-primary  btn-lg btn-block add">Haz click para mostrar mas series!</button>
    <br>




</div>






<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>