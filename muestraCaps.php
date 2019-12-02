<?php
require_once("./Database.php");
            $db = Database::getInstancia("root", "", "myanimelistV2");
            $db->query(" SELECT * FROM `serie` ORDER BY rand() LIMIT 4;");
            ?>
            <div class="card-group ">
            <?php
            while ($RanSer = $db->getObject("infoSeries")) {

                ?>

                <div class="card">
                    <img src="<?= $RanSer->getImg() ?>" class="card-img-top img-fluid rounded mx-auto w-100 d-block" alt="...">
                    <div class="card-body"><a href="anime.php?id=<?=$RanSer->getIdSerie() ?>">
                            <h5 class="card-title"> <?= $RanSer->getTituloJap() ?></h5> </a>
                    </div>
                </div>

                <?php

            }

         ?>
            </div>
