<?php
/////// CONEXIÓN A LA BASE DE DATOS /////////
require_once("./Database.php");
require_once("./infoSeries.php");
$db = Database::getInstancia("root","","myanimelistV2");


$query="SELECT * FROM serie ORDER BY idSe";
if(isset($_POST['texto']))
{
    $text = addslashes($_POST['texto']);
    $query="SELECT * FROM serie WHERE titulo like '%$text%' ";
}


$re=$db->query($query);

// $item = $db->getObject("infoSeries");

$resultado = false;
?>
    <?php
    echo "<h3>Resultados de la Busqueda</h3>";
    while( $item = $db->getObject("infoSeries"))
    {

        ?>
            <a href="anime.php?id=<?=$item->getIdSerie() ?>">
            <h6 class="card-title"><img src="<?= $item->getImg() ?>" alt="Foto Serie" class="img-thumbnail" width="70vw" > <?= $item->getTitulo() ?></h6> </a>
<?php
        $resultado = true;
}
$query="SELECT * FROM usuario WHERE alias like '%$text%' ";
$db->query($query);
while( $item = $db->getObject("usuario"))
{
    ?>
    <a href="perfil.php?idUsu=<?=$item->getIdUsu() ?>">
        <h6 class="card-title"><img src="<?= $item->getAvatar() ?>" alt="Foto Usuario" class="img-thumbnail" width="70vw" ><?= $item->getAlias() ?></h6> </a>



   <?php
    $resultado = true;
}

if ($resultado == false) {
    echo "No se encuentran resultados con los datos introducidos";
}








//echo $tabla;
?>
