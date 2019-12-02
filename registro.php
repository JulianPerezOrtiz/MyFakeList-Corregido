<?php
require_once("./Database.php");
require_once("./controlSesion.php");
$controlSes = controlSesion::getInstancia();
$db = Database::getInstancia("root","","myanimelistV2");
if (($controlSes->loged())){
    $controlSes->rediret("inicio.php");
}
if (!empty($_POST)){
  $correo = addslashes( $_POST["correo"]);
  $contrasenia = hash('sha256',$_POST["contrasenia"]);
  $confcontrasenia = hash('sha256', $_POST["confircontrasenia"]);
  $nick = addslashes($_POST["nick"]);



if ($contrasenia == $confcontrasenia) {
    $hoy = getdate();
    if (strlen($hoy["mday"]) == 1){
        $dia = "0".$hoy["mday"];
    }
    $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;
   $sql = "INSERT INTO `usuario` (`id_usu`, `alias`, `correo`, `contrasenia`, `avatar`, `about`, `location`, `tipoUsu`, `fec_reg`) 
            VALUES (NULL, '$nick', '$correo', '$contrasenia', 'default.jpg', NULL, NULL, NULL, '$ac')";

   if ( !($db->query($sql))){
        $error = "Error al insertar los datos, intentalo de nuevo mas tarde o te jodes.";
   } else {
       $correcto = "Registrado correctamente.";
   }


} else {
    $error = "Las contraseñas no coinciden";
}


}

?>
<html lang="en">
<head>
    <title>Registro</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>

        function compruebaNick(txt, ope){
            $.ajax({
              url : 'opeReg.php',
              method: 'POST',
              data : {
                  txt : txt,
                  ope : ope
              }
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
              url : 'opeReg.php',
              method: 'POST',
              data : {
                  txt : txt,
                  ope : ope
              }
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
              var ope = "nick";
              compruebaNick(txt, ope);

           });
            $(".mail").keyup(function () {
                var txt = $(this).val();
                var ope = "mail";
                compruebaMail(txt, ope);

            });


        });
    </script>
</head>
<body>

<div class="container center w-50">

    <?php
    require_once("./css/navbarVisitante.php");
    if ( (isset($error)) && $error != "" ){
        ?>
        <button type="button" class="btn btn-danger"><?= $error ?></button>
    <?php
        $error = "";
    }
    if ( isset($correcto)) {
        ?>
         <button type="button" class="btn btn-success"><?= $correcto ?> <a href="login.php">Pueden iniciar sesion desde aqui.</a> </button>
    <?php
    }
    ?>

<p>Completa los datos para darte de alta en MyFakeList</p>


<form method="post">
  <div class="form-group">
    <label for="correo">Correo*</label>
    <input type="email" class="form-control mail" name="correo" aria-describedby="emailHelp" placeholder="Introduce un Correo ">
      <button type="button" class="btn btn-danger rep2" hidden>Este Correo esta en uso. <a href="login.php">¿Iniciar Sesion?</a> </button>
  </div>
  <div class="form-group">
    <label for="contrasenia">Contraseña* (Contraseña transmitida y almacenada de forma segura con sh256</label>
    <input type="password" class="form-control" name="contrasenia" placeholder="Contraseña">
  </div>
  <div class="form-group">
    <label for="confircontrasenia">Contraseña*</label>
    <input type="password" class="form-control" name="confircontrasenia" placeholder="Vuelve a Repetirla ">
  </div>
  <div class="form-group " >
    <label for="nick">Nick usuario*</label>
    <input type="text" class="form-control nick"  name="nick" placeholder="Nickname">
      <button type="button" class="btn btn-danger rep1" hidden>Este nombre de usuario no esta disponible. Elige otro!</button>
      <div id="rep"></div>
  </div>

  <button type="submit" class="btn btn-primary" id="env" >Send</button>
</form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>