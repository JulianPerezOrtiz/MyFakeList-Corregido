<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="./inicio.php">MyFakeList</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="./inicio.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./lista.php">Lista anime</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Perfil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="./perfil.php">Perfil</a>
                    <a class="dropdown-item" href="./logout.php">Cerrar Sesion</a>
                </div>
            </li>
            <li class="nav-item ">
                <?php
                if (isset($idUsuOri)) {
                    ?>
                <a class="btn btn-primary" href="./perfil.php" role="button">Bienvenid@! <?= $idUsuOri ?></a>   </li>
                <?php
                } else {
                    ?>
                    <a class="btn btn-primary" href="./perfil.php" role="button">Bienvenid@! <?= $user->getAlias() ?></a>   </li>
            <?php
                }
                ?>

        </ul>
        <form class="form-inline my-2 my-lg-0" method="get">
            <input class="form-control mr-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Busca un Anime o Usuario" aria-label="Search">



        </form>
        <br>
    </div>
</nav>