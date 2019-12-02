<?php
    require_once("./Database.php");
    require_once("./controlSesion.php");

    $ses = controlSesion::getInstancia();
if (!($ses->loged())){
   $visitante = true;
    $idUsuList = $_GET["idUsu"] ?? null;
    if ($idUsuList == null){
        $ses->rediret("inicio.php");
    }
    $db = Database::getInstancia("root","","myanimelistV2");
} else {
    $visitante = false;
    $db = Database::getInstancia("root","","myanimelistV2");
    $idUsuList = $_GET["idUsu"] ?? null;
    $user = $ses->getUsu();
    $idUsu = $user->getIdUsu();
}
?>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/estilos.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/b873749123.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="peticion.js"></script>
    <script>
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
        function subDes(usu, se, text) {
            $.ajax({
               url: 'subeCap.php',
               type: 'POST',
               data: {
                   usu : usu,
                   se : se,
                   text : text,
                   ope : "des"
               }
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
        $(document).ready(function () {
            $( ".fa-plus-circle" ).click(function() {
                var usu = $(this).data("usu");
                var se = $(this).data("se");
                var capTo = $(this).data("capmax");
                subeCa(usu, se, capTo);
            });
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
            $(".sco1").click(function () {
                var id = $(this).data("idsc");
                $("#sco1"+id).hide();
                $("#sco"+id).removeAttr("hidden");

            });
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

            });
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

    </script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <table class="table table-striped">
        <thead>
        <tr>
            <?php
            if ($idUsuList != null) {
              if (is_numeric($idUsuList)) {
                  $sql = "SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idUsuList ORDER BY u.status DESC, s.titulo  ASC";
                  $edit = false;
              } else {
                 $ses->rediret("inicio.php");
              }

                } else {
                $edit = true;
                $sql = "SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idUsu ORDER BY u.status DESC, s.titulo  ASC";
            }

            $db->query($sql);
            $item = $db->getArraid();
        //   echo "<pre>" . print_r($item, true) . "</pre>" ;
            $count = 1;
           ?>

            <th scope="col">#</th>
            <th scope="col">Imagen</th>
            <th scope="col">Titulo</th>
            <th scope="col">Puntuacion</th>
            <th scope="col">Tipo
            <th scope="col">Progreso</th>
            <th scope="col">Comentarios</th>
        </tr>
        </thead>
        <tbody>


        <?php
        foreach ($item as $ser){
            if ($edit == false) {
                ?>

                <tr>
                    <th class="<?= $ser["status"] ?>" scope="row"><?=  $count?></th>
                    <td> <img class="w-25" src="<?= $ser["img"]  ?>">  </td>
                    <td> <a href=anime.php?id=<?=$ser["idSe"] ?>> <?= $ser["titulo"] ?></a>  </td>
                    <td><?= $ser["score"] == NULL ? "-" : $ser['score'] ?></td>
                    <td><?= $ser["tipo"] ?></td>
                    <?php
                    if ($ser["status"] == "Completada") {
                        ?>

                        <td> <?= $ser["episodios"] ?>  </td>
                        <?php
                    } else {
                        ?>
                        <td><?= $ser["cap"] ?> / <?= $ser["episodios"] ?></td>

                        <?php
                    }?>
                    <td> <?= $ser["review"] == "" ? "---" : $ser["review"] ?>  </td>


                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <th class="<?= $ser["status"] ?>" scope="row"><?=  $count?></th>
                    <td> <img class="w-25" src="<?= $ser["img"]  ?>">  </td>
                    <td> <a href=anime.php?id=<?=$ser["idSe"] ?>> <?= $ser["titulo"] ?></a>  </td>
                    <td>
                        <span class="sco1" id="sco1<?=  $count?>" data-idsc="<?=  $count?>"><?= $ser["score"] == NULL ? "-" : $ser['score'] ?> </span>


                        <div class="form-group sco" hidden id="sco<?=  $count?>" >
                            <select class="form-control score"  data-idscore="<?=  $count?>" data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>">
                                <option>-</option>
                                <?php
                                for ($x = 1; $x <=10;$x++){
                                    ?>
                                    <option><?= $x ?></option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>

                    </td>
                    <td><?= $ser["tipo"] ?></td>
                    <?php
                    if ($ser["status"] == "Completada") {
                        ?>

                        <td><span id="cap<?= $ser["idSe"] ?>"> <?= $ser["episodios"] ?>  </td>
                        <?php
                    } else {
                        ?>
                        <td><span id="cap<?= $ser["idSe"] ?>"><?= $ser["cap"] ?> </span> / <?= $ser["episodios"] ?><i class="fas fa-plus-circle" data-capmax="<?= $ser["episodios"] ?>"   data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>"></i></td>

                        <?php
                    }?>

                    <td> <span class="spanre" id="<?="s".$count?>" data-ids="<?=$count?>" data-re="<?= $ser["review"] ?>"><?= $ser["review"] == "" ? "---" : $ser["review"] ?> </span>
                        <textarea id="<?= "txt".$count?>" class="form-control tex1" hidden name="des" data-idt="<?=$count?>"  data-se="<?= $ser["idSe"] ?>" data-usu="<?= $ser["id_usu"] ?>" maxlength="999" rows="2"></textarea>
                    </td>
                </tr>
                <?php
            }

            $count++;
        }

        ?>




        </tbody>
    </table>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prueba Mierdosa de modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="mdes">

                    </span>
                    <p>UPDATE ususer SET cap = 1 WHERE id_usu = id AND idSe = 14829</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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