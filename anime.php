<?php
require_once("./controlSesion.php");
require_once("./Database.php");
require_once("./infoSeries.php");
require_once("./relacionados.php");
$ses = controlSesion::getInstancia();
$id = addslashes($_GET["id"]?? null) ;
    if (!is_numeric($id)){
        $ses->rediret("inicio.php");
    }
$db = Database::getInstancia("root","","myanimelistV2");
$sql = " SELECT * FROM serie WHERE idSe =".$id;
$db->query($sql);
$anime = $db->getObject("infoSeries");
if ($anime == FALSE) {
    $ses->rediret("inicio.php");
}
    if (!($ses->loged())){
        $visitante = true;
    } else {
        $visitante = false;
        $user = $ses->getUsu();
      //  echo "<pre>" . print_r($anime, true) . "</pre>" ;
    }
?>
<html lang="en">
<head>
    <title><?= $anime->getTituloJap() ?></title>
    <link rel="icon" type="image/png" href="<?= $anime->getImg() ?>">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="./css/estilos.css">
    <script src="https://kit.fontawesome.com/b873749123.js" crossorigin="anonymous"></script>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="peticion.js"></script>

    <script>
        function setEst(usu, se, sts) {
            $.ajax({
               url: 'subeCap.php',
               type: 'POST',
               data: {
                   usu : usu,
                   se : se,
                   sts : sts,
                   ope : "status"

               }
            })
                .done(function (data) {
                    location.reload();
                })

        }
        function subeCa(usu, se, capTo) {

            $.ajax({
                url: 'subeCap.php',
                type: `POST`,
                data: { usu : usu, se : se, capmax : capTo, ope : "cap"},
            })
                .done(function (data) {

                    $("#cap"+se).html(data);
                })
        }
        function subeSc(usu, se, sc){
            $.ajax({
                url: 'subeCap.php',
                type: 'POST',
                data: {
                    usu : usu,
                    se : se,
                    sc : sc,
                    ope : "sc"
                }

            })

        }
        function borraSeUsu(usu, se){
            $.ajax({
                url : 'subeCap.php',
                type : 'POST',
                data : {
                    usu : usu,
                    se : se,
                    ope : "del"
                }
            })
                .done(function () {
                    location.reload();
                })
        }
        function modEst(usu, se, est){
            $.ajax({
                url : 'subeCap.php',
                type : 'POST',
                data : {
                    usu : usu,
                    se : se,
                    est : est,
                    ope : "modSe"
                }
            })
                .done(function () {
                    location.reload();
                })
        }
        function modFav(usu, se, opeS){
            $.ajax({
               url : 'subeCap.php',
               type: 'POST',
               data : {
                   usu : usu,
                   se : se,
                   opeS : opeS,
                   ope : "fav"
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
            $("#add").click(function () {
                var usu = $(this).data("usu");
                var se = $(this).data("se");
                var sts = "Para Ver";
               setEst(usu,se,sts);

            });
            $( ".fa-plus-circle" ).click(function() { // repetida de lista;
                var usu = $(this).data("usu");
                var se = $(this).data("se");
                var capTo = $(this).data("capmax");
                subeCa(usu, se, capTo);
            });
            $(".score").focusout(function () { // repetida de lista pero con cosas borradas
                var score = $(this).val();
                var usu = $(this).data("usu");
                var se = $(this).data("se");
                subeSc(usu,se,score);


            });
            $(".btn-danger").click(function () {
                var usu = $(this).data("usu");
                var se = $(this).data("se");
                var ti = $(this).data("til");
                $("#md").text(ti);
                $("#staticBackdrop").modal();
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
    <br>
    <div id="resultadoBus">

    </div>
    <div class="alert alert-primary" role="alert">
        <?= $anime->getTitulo(); ?>
    </div>

    <div class="row">


    <div class="col-4 linea">
        <img src="<?= $anime->getImg(); ?>" class="rounded mx-auto d-block" alt="...">

        <div class="infoSerie">
            <p>Detalles:</p>
            <hr>
            <ul>
                <li><b>Titulo Japones:</b> <?= $anime->getTituloJap() != "NULL" ? $anime->getTituloJap() : "No disponible" ?> </li>
                <?php
                $est = $anime->getIdEst();
                $qer = "SELECT NombreEstudio FROM estudio where idEst =$est ";
                $es = $db->getArraid($db->query($qer));
                $est = $es[0][0];
                ?>
                <li><b>Estudio:</b> <?= $est ?> </li>
                <li><b>Estado:</b> <?= $anime->getEstado() != "NULL" ? $anime->getEstado() : "No disponible" ?> </li>
                <li><b>Tipo:</b> <?= $anime->getTipo() != "NULL" ? $anime->getTipo() : "No disponible" ?> </li>
                <li><b>Capitulos:</b> <?= $anime->getEpisodios() != "NULL" ? $anime->getEpisodios() : "No disponible" ?> </li>
                <li><b>Duracion:</b> <?= $anime->getDuracion() != "NULL" ? $anime->getDuracion() : "No disponible" ?> </li>

                <li><b>Fecha Emision:</b> <?= $anime->getFecIni() != "NULL" ? $anime->getFecIni() : "No disponible" ?> </li>

                <?php
                if ($anime->getFecFin() != "0000-00-00"){
                    ?>
                    <li><b>Fecha Terminado:</b> <?= $anime->getFecFin(); ?></li>
                <?php
                }
                ?>
                <li><b>Genero:</b>
                    <?php
                    $sqlGen = "SELECT Genero AS 'a' FROM generos WHERE idGen IN (SELECT IdGen FROM `sergen` WHERE idSe = $id) ";

                    $db->query($sqlGen);
                    $itemGen = $db->getArraid();
                    $ul = end($itemGen);

                    foreach ($itemGen as $gen){
                       print_r($gen["a"]);
                       if ($ul["a"] != $gen["a"]) {
                           echo ", ";
                       } else {
                           echo ".";
                       }

                    }
                    ?>
                </li>
                <li><b>PEGI:</b> <?= $anime->getPegi() != "NULL" ? $anime->getPegi() : "No disponible" ?> </li>
            </ul>
        </div>
    </div>

    <div class="col-8">
        <?php
        if ($visitante == false) {


        ?>
        <div id="addser">

            <?php
            $estados = array(
                0 => "Viendo",
                1 => "Para_Ver",
                2 => "Droppeada",
                3 => "Completada"
            );
            $idusu = $user->getIdUsu();
            $idse = $anime->getIdSerie();
            $sql = "SELECT idSe FROM ususer WHERE id_usu = $idusu AND idSe = $idse";
            $vis = false;
            if ($db->query($sql)) {
                $vis = true;
            ?>
                <!-- COMPROBAMOS SI EL USUARIO ESTA SIGUIENDO LA SERIE O NO -->
            <div class="form-group"  >
                <p>Estado:</p>
                <select class="form-control selEst"  data-se="<?= $anime->getIdSerie() ?>" data-usu="<?= $user->getIdUsu() ?>" >

                    <?php
                    $sql = "SELECT status FROM ususer WHERE id_usu = $idusu AND idSe = $idse";


                    $db->query($sql);
                    $est = $db->getArraid();
                    foreach ($estados as $estado) {
                        $yy = $estado;

                        if ($estado == $est[0][0]){ ?>
                            <option selected class="p-3 mb-2 bg-success text-white" ><?= $estado == "Para_Ver" ? "Para Ver" : $estado ?></option>
                            <?php
                        } else {
                            ?>
                            <option ><?=  $estado == "Para_Ver" ? "Para Ver" : $estado ?></option>
                            <?php
                        }
                        ?>

                        <?php

                    }
                    ?>


                </select>
            </div>
                <!-- SACAMOS LA SERIE QUE ESTA SIGUIENDO EL USUARIO -->
            <?php
                $sql = "SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idusu AND u.idSe = $idse";
                $db->query($sql);
                $item = $db->getArraid();
                foreach ($item as $ser){
                    ?>
                    <!-- SELECTOR DE CAPITULO -->
                    <p>Capitulos Vistos:</p>
                    <span id="cap<?= $ser["idSe"] ?>"><?= $ser["cap"] ?> </span> / <?= $ser["episodios"] ?><i class="fas fa-plus-circle" data-capmax="<?= $ser["episodios"] ?>"   data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>"></i>
                   <!-- SELECTOR DE PUNTUACION -->
                    <div class="form-group">
                        <p>Puntuacion:</p>
                        <select class="form-control score" data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>">
                            <?php
                            for ($x = 1; $x <=10;$x++){
                                if ($ser["score"] == $x){
                                    ?>
                                    <option selected><?= $x ?></option>
                                    <?php
                                }
                                ?>
                                <option><?= $x ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                    <button type="button" class="btn btn-danger" data-til="<?= $ser["titulo"] ?>" data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>">Borrar Serie De la Lista</button>
                    <?php
                    if ($ser["favoritausu"] > 0) {
                        ?>
                        <button type="button" class="btn btn-danger" id="fav" data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>" data-ope="0">Borrar Serie de Favoritos</button>

                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-info" id="fav" data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>" data-ope="1">Añadir Serie a Favoritos</button>

                        <?php
                    }
                    ?>

                      <?php
                }
                ?>

                <?php
            } else {

                ?>

            <div>
                <button type="button" class="btn btn-info" id="add"  data-usu="<?= $idusu ?>" data-se="<?= $idse ?>">Añadir Serie a lista</button>

            </div>

            <?php
            }
            ?>



        </div>
        <?php
        }
        ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php


            if ( $anime->getTrailer() != "NULL") {

                ?>
               <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Trailer</a>
                </li>
            <?php
            }
            ?>

            <li class="nav-item">
                <a class="nav-link <?= $anime->getTrailer() == "NULL" ? "active" : "" ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Descripcion</a>
            </li>
            <?php
            $sql = "SELECT * FROM relacionados WHERE idSe = ".$id;
            $db->query($sql);
            $tipoAnt = null;
            $aa = $db->getArraid();
            if (!(empty($aa))){
                ?>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Animes Relacionados</a>
                </li>
            <?php
            }
            ?>

        </ul>
        <div class="tab-content" id="myTabContent">
            <?php
                if ($anime->getTrailer() != "NULL") {
                    ?>
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">





                        <div class="embed-responsive embed-responsive-16by9">

                            <iframe class="embed-responsive-item" src="<?= $anime->getTrailer(); ?>" allowfullscreen></iframe>

                        </div>


                        </div>
            <?php
                }
            ?>

            <div class="tab-pane fade  <?= $anime->getTrailer() == "NULL" ? "show active" : "" ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab"><?= $anime->getDescripcion() != "" ? $anime->getDescripcion() : " No hay informacion disponible todavia." ?></div>
            <?php

            if (!empty($aa)){
            ?>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <?php




                foreach ($aa as $itemrel) {
                    $tipo = $itemrel["tipo"];
                    $rel = $itemrel["idRel"];

                    if (!($tipo == $tipoAnt)) {
                        ?>

                        <ul>
                            <li><b><?= $itemrel["tipo"] ?></b></hr></li>
                            <p>
                                <?php

                                $sql1 = "SELECT * FROM serie WHERE idSe IN (SELECT idRel FROM relacionados WHERE idSe = '$id' AND tipo LIKE '$tipo') ";

                                $db->query($sql1);
                                while ($re = $db->getObject("infoSeries")){
                                    ?> <a href="./anime.php?id=<?=$re->getIdSerie()?>"><?=$re->getTitulo(); ?><br></a>    <?php
                                }
                                ?>


                            </p>
                        </ul>
                        <?php
                    }

                    $tipoAnt = $tipo;
                }


                ?>


            </div>
            <?php
            }
            ?>

        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tas seguro de querer borrarla ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estas seguro de borrar <span id="md"></span> de tu lista de seguimiento ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mantener</button>
                    <button type="button" class="btn btn-primary" id="del">Borrar</button>
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
