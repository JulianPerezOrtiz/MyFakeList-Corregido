<?php
require_once("./Database.php");
require_once("./controlSesion.php");
require_once("./usuario.php");
    $sesion = controlSesion::getInstancia();
    $idUsu = addslashes($_GET["idUsu"] ?? null) ;
    $db = Database::getInstancia("root","","myanimelistV2");
    if (!($sesion->loged())){
        $visitante = true;

            if ($idUsu == null){
        $sesion->rediret("login.php");
            }


            $sql = "SELECT * FROM usuario WHERE id_usu = $idUsu";
        $db->query($sql);
        $user = $db->getObject("usuario");
    } else {


        if ($idUsu != null){
            $visitante = true;

            $db = Database::getInstancia("root","","myanimelistV2");
            $sql = "SELECT * FROM usuario WHERE id_usu = $idUsu";
            $db->query($sql);
            $user = $db->getObject("usuario");
            $userOri = $sesion->getUsu();
            $idUsuOri = $userOri->getAlias();
        } else {
            $visitante = "local";
            $user = $sesion->getUsu();
            $idUsu = $user->getIdUsu();
            $sql = "SELECT * FROM usuario WHERE id_usu = $idUsu";
            $db->query($sql);
            $user = $db->getObject("usuario");

            /*   $upuser = "SELECT * FROM usuario WHERE id_usu = $idUsu";
               $us = $db->query($upuser); */
       //     echo "<pre>" . print_r($user, true) . "</pre>" ;
        }

    }
if (!empty($_FILES)){
  //  echo "<pre>".print_r($_FILES["img"], true)."</pre>" ;

    $ori = $_FILES["img"]["tmp_name"];
    $fin = "C:\Users\julia\PhpstormProjects\untitled\myanimelist\avatares\\".$user->getIdUsu().".jpg";
    //   echo $fin;

    if (!move_uploaded_file($ori,$fin)){
        echo "Error al subir la foto.";
    } else {
        $photo = $idUsu.".jpg";
        // le paso la ruta del la image
        //   $img = imagecreatefromjpeg($fin);
        //  imagescale($img, 10,10);
        $upl = "UPDATE usuario SET avatar ='$photo' WHERE id_usu =  '$idUsu' ";
        $db = Database::getInstancia("root","","myanimelistV2");
        $db->query($upl);
    }
}

?>
<html lang="en">
<head>
    <title>Perfil de usuario <?= $user->getAlias() ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="./css/estilos.css">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="peticion.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script>
        function subeText(usu, txt, ope){
            $.ajax({
                url : 'OpeUsu.php',
                type: 'POST',
                data: {
                    usu : usu,
                    txt: txt,
                    ope: ope
                }
            })
                .done(function () {
                    location.reload();
                })
        }

        $(document).ready(function () {
            $(".btn1").click(function () {
               $(".modal").modal('show');
            });

            $(".txt").focusout(function () {
                var usu = $(this).data("usu");
                var text = $(this).val();
                var ope = $(this).data("ope");
                 subeText(usu,text,ope);


            });

        });
    </script>
</head>
<body>
<div class="container">
    <?php
   // if ( ($visitante == false) || ($visitante == "local")){
    if (  $sesion->loged()){
        require_once("./css/nav.php");

    } else {
        require_once("./css/navbarVisitante.php");
    }
    ?>
    <br>
    <div id="resultadoBus">

    </div>
    <div class="alert alert-primary" role="alert">
        Perfil de <?=  $user->getAlias() ?>
    </div>
    <div class="row">


    <div class="col-4 linea">

        <img src="<?= $user->getAvatar(); ?>" class="rounded mx-auto d-block w-100"  alt="Foto usuario">


        <div class="infoSerie">
            <p>
                Detalles:</p>

            <hr>
            <li><b>Ubicacion:</b> <?= $user->getLocation() ?></li>
            <li><b>Miembro desde :</b> <?= $user->getFecReg() ?></li>
            <div><a class="btn btn-primary" href="./lista.php?idUsu=<?= $user->getIdUsu() ?>" role="button">Ver Lista Seguimiento</a>       </div>
        </div>
        <?php
        if ( ($visitante === "local") ) {
            ?>
            <div><button type="button" class="btn btn-primary btn1">Editar Perfil</button> </div>

        <?php
        }
        ?>


    </div>
    <div class="col-8">
        <div><p><?= $user->getAbout() ?></p></div>
        <div class="infoSerie"><p>Series Favoritas:</p>
            <?php
            $idusuS = $user->getIdUsu();
            $sql = "SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idusuS AND u.favoritausu = 1";
            $db->query($sql);
            $fav = $db->getArraid();
            if (empty($fav)){
                echo "No tiene series favorias aun :(";
            } else {
                ?>
            <ul>
            <?php

                foreach ($fav as $item){
                    ?>
                    <li><img src="<?= $item["img"] ?>" alt="Foto Serie" class="img-thumbnail" width="70vw" >  <a href=anime.php?id=<?=$item["idSe"] ?>> <?= $item["titulo"] ?></a></li>

            <?php
                }
                echo "</ul>";
            }
            ?>

        </div>

    </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Editando perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                    <span>
        <div>
            <form method="post" enctype="multipart/form-data">
                <div class="col form-group">
                    <label for="img">Sube una foto en .jpg</label>
                    <input type="file" class="form-control-file" id="img" name="img"
                           accept="image/jpg, image/png" />
                </div>
                <div class="col">
                    <button class="btn btn-primary uplpht" type="submit">Guardar Foto</button>
                </div>
            </form>


        </div>
                    </span>
                        <div>Ubicacion: <span ><input type="text" class="form-control txt" data-ope="location"  data-usu="<?= $idUsu ?>"  value="<?= $user->getLocation() ?>" maxlength="69"></span></div>
                        <div>Descripcion: <span ><input type="text" class="form-control txt" data-ope="about" data-usu="<?= $idUsu ?>"  value="<?= $user->getAbout() ?>" maxlength="499"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>




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