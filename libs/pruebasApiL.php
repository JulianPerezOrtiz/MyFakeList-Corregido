
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
<h1>HOLAAAAAAAAAAAAA</h1>
<?php
require_once("./Database.php");
/**
 * @var PDO
 */
function yoquese(){
    echo"ENTRO ENTRO";
    $pdo = new PDO("mysql:host=localhost;dbname=myanimelistv2","root","");
    $pdo->exec("set names utf8");
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );

   // $series = file_get_contents("https://api.jikan.moe/v3/search/anime?q=hibike&limit=16",false, stream_context_create($arrContextOptions));
    $productor = file_get_contents("https://api.jikan.moe/v3/producer/7/1",false, stream_context_create($arrContextOptions));

    $infoPro = json_decode($productor);
 //   echo "<pre>".print_r($infoPro, true)."</pre>" ;
    $tam = count($infoPro->anime);
    echo "EL TAMAÑO ES".$tam;

    if ($productor) {
        echo "<pre>".print_r($productor, true)."</pre>" ;
        foreach ($infoPro->anime as $anime) {
            $malId = $anime->mal_id; // ID UNICO DE CADA SERIE DE MAL
            $serie = file_get_contents("https://api.jikan.moe/v3/anime/$malId",false, stream_context_create($arrContextOptions));
            $ser = json_decode($serie);
            echo "MOSTRANDO SERIES";
            $idSeMal = $ser->mal_id;
            $titulo = addslashes($ser->title);
            if ($ser->airing){
                $emitiendo = "true";
            } else {
                $emitiendo = "false";
            }
            $descripcion =addslashes($ser->synopsis) ;
            if ($ser->episodes == null) {
                $episodios = "NULL";
            } else {
                $episodios = $ser->episodes;
            }
            if ($ser->aired->from == null) {
                $fec_ini = "NULL";
            } else {
                $fec_ini = $ser->aired->from;
            }
            if ($ser->aired->to == null) {
                $fec_fin = "NULL";
            } else {
                $fec_fin = $ser->aired->to;
            }
            $pegi = addslashes($ser->rating) ;
            $foto = $ser->image_url;
            $tipo =$ser->type;
            $estado = addslashes($ser->status) ;
            if ($ser->duration == null) {
                $duracion = "NULL";
            } else {
                $duracion = addslashes($ser->duration) ;
            }
            if ($ser->trailer_url == null) {
                $trailer = "NULL";
            } else {
                $trailer = $ser->trailer_url;
            }
            $tituloJap = addslashes($ser->title_japanese) ;
            $estudio = $ser->studios[0]->mal_id;
            $estudioName = $ser->studios[0]->name;
            echo "INSERTADO DE ESTUDIO:";
            $es = "INSERT INTO estudio  ";
            $es.="VALUES ('$estudio','$estudioName') ;";
            echo $es."<br>";
                echo "Mostrando SERIE: ".$idSeMal." ".$titulo." emitiendo ".$emitiendo." descripcion: ".$descripcion."<br>";
                echo "episodios".$episodios." fec ini".$fec_ini." ".$fec_fin." pegi ".$pegi." foto ".$foto." ".$tipo." ".$estado." ".$duracion." TRAILER ".$trailer." ".$tituloJap."<br>";
     //       echo "INSERTADo DE SERIE <br>";
            $all = "INSERT INTO  serie ";
            $all.="VALUES ('$idSeMal','$descripcion','$duracion',$emitiendo,'$episodios','$estado','$fec_ini','$fec_fin','$foto','$pegi','$tipo','$titulo','$tituloJap','$trailer','$estudio') ;";
           // echo $all."<br>";
// comentado ini

            echo "Insertando serie: ".$tituloJap."<br>";
              $prep = $pdo->prepare($all);
      //         $prep->execute();

//comen fin
/*
               //PARA INSERTAR LOS TIPOS DE RELACIONADOS, NO EJECUTAR DE PRIMERAS!!!!
            $array = array(
                0 => "Spin-off",
                1 => "Alternative version",
                2 => "Alternative setting",
                3 => "Sequel",
                4 => "Other",
                5 => "Prequel",
                6 => "Summary",
                7 => "Side story",
                8 => "Adaptation"
            );
                for ($a = count($array); $a > 0; $a--) {
                    $name = $array[$a-1];
                    if (isset($ser->related->$name)) {
                        $x = count($ser->related->$name);
                        for (; $x > 0; $x-- ){
                            $idRel= $ser->related->$name[$x-1]->mal_id;
                            echo "INSERTADO DE RELACIONADOS: <br>";
                            $re = "INSERT INTO  relacionados ";
                            $re.="VALUES ('$malId','$idRel','$name') ;";
                            echo $re."<br>";
                            $prep = $pdo->prepare($re);
                           $prep->execute();

                        }

                    }
                }

*/
// HASTA AQUI LO DE ARRIBA




            $x = count($ser->genres);
          //  echo "<br> NUMERO DE GENEROS:".$x;
            for (; $x > 0; $x-- ) {
                $genero = $ser->genres[$x-1]->mal_id;
            //    echo "INSERTADO DE GENEROS: <br>";
                $ge = "INSERT INTO  sergen ";
                $ge.="VALUES ('$malId','$genero') ;";
                $sergen = $pdo->prepare($ge);
         //       $sergen->execute();
            }









          //  echo "<pre>".print_r($ser, true)."</pre>" ;


        }
    }
/*
    if ($series){



        echo "hola";
        echo "<pre>".print_r($series, true)."</pre>" ;
        foreach ($info->results as $hola){

                $titulo = addslashes($hola->title) ;
                $descripcion =  addslashes($hola->synopsis);
                $episodios = $hola->episodes;
                $fec_ini = $hola->start_date;
                $fec_fin = $hola->end_date;
                $pegi = $hola->rated;
                if ($hola->airing){
                    $emitiendo = "true";
                } else {
                    $emitiendo = "false";
                }
                $img = $hola->image_url;
                $tipo = $hola->type;

                $sql = "INSERT INTO serie ";
                $sql.="VALUES ('','$titulo',$emitiendo,'$descripcion','$episodios','$fec_ini','$fec_fin','$pegi','$img','$tipo') ;";
                //echo $sql."<br>";

                echo "Insertando serie: ".$titulo;
                echo "<br>";
             //  $prep = $pdo->prepare($sql);
             //   $prep->execute();


        }
    } else {
        echo "Esto no furrula";
    } */
}

yoquese();
?>


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