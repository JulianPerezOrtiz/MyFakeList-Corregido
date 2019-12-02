<?php
require_once("./controlSesion.php");
$controlSes = controlSesion::getInstancia();

if (($controlSes->loged())){
        $controlSes->rediret("inicio.php");
}
$error = false;
if (!empty($_POST)){
    $correo = $_POST["correo"];
    $pass = hash('sha256', $_POST["contrasenia"]);


   // echo "Usuario ".$correo." y ".$pass;

  $ok =  $controlSes->entrar($correo,$pass);
  echo "<br>";
  if ($ok) {
   $usu = $controlSes->getUsu(); // guardo los datos de usuario en una variable y a partir de esta ya puedo llamar a las funciones de la clase usuario;
 //   $usu2 = $usu->getIdUsu();
  //  echo $usu2;
      //echo "Sesion iniciada correctamente ".$usu;
   //   echo "<pre>" . print_r($usu, true) . "</pre>" ;
      $error = false;
      $controlSes->rediret("inicio.php");

  } else {
      $error = true;
  }

   // $res =  $controlSes->entrar($correo, $pass);
  //  if ($res) echo "Sesion iniciada correctamente"; echo "error al iniciar sesion";
}
?>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
    if ($error == true){
        ?>
        <button type="button" class="btn btn-danger">Contraseña o usuario incorrectos</button>
        <?php
    }
    ?>
    <form method="post">
        <div class="form-group">
            <label for="correo">Correo*</label>
            <input type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="contrasenia">Contraseña*</label>
            <input type="password" class="form-control" name="contrasenia" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>