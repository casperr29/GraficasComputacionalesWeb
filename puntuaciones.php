<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

    <link rel="stylesheet" href="css/puntuaciones.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" I />
</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column justify-content-center align-items-center w-100 flex-fill">

        <div class="d-flex flex-column justify-content-center align-items-center w-100">
            <div id="main-table-container" class="d-flex flex-row justify-content-center align-items-center flex-wrap">

                <div class="d-flex flex-column justify-content-center align-items-center">

                    <h2 class="fs-4 table_title">UN JUGADOR - MODO TIEMPO</h2>
                    <table class="tabletiempo px-2">
                        <thead>
                            <tr>
                            </tr>
                            <tr>
                                <th class="fs-3">Nombre</th>
                                <th class="fs-3">Tiempo</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $tableIndex = 1;
                            include 'db/get_scores.php' ?>

                            <!-- <tr>
              <td>GODSPEED</td>
              <td>1:30</td>
            </tr>
            <tr>
              <td>MrWhite</td>
              <td>2:05</td>
            </tr> -->
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h2 class="fs-4 table_title">UN JUGADOR - MODO OBJETOS</h2>

                    <table class="tableobjetos px-2">
                        <thead>
                            <tr>
                                <th class="fs-3">Nombre</th>
                                <th class="fs-3">Puntuación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tableIndex = 2;
                            include 'db/get_scores.php' ?>


                        </tbody>
                    </table>
                </div>

                <!-- <div class="d-flex flex-column justify-content-center align-items-center">

                    <h2 class="fs-4 table_title">MULTIJUGADOR - MODO TIEMPO</h2>
                    <table class="tabletiempo px-2">
                        <thead>
                            <tr>
                            </tr>
                            <tr>
                                <th class="fs-3">Nombre</th>
                                <th class="fs-3">Tiempo</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $tableIndex = 3;
                            include 'db/get_scores.php' ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h2 class="fs-4 table_title">MULTIJUGADOR - MODO OBJETOS</h2>

                    <table class="tableobjetos px-2">
                        <thead>
                            <tr>
                                <th class="fs-3">Nombre</th>
                                <th class="fs-3">Puntuación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tableIndex = 4;
                            include 'db/get_scores.php' ?>
                        </tbody>
                    </table>
                </div> -->

            </div>
            <a href="index.html" class="btn-neon mt-4">
                <span id="span1"></span>
                <span id="span2"></span>
                <span id="span3"></span>
                <span id="span4"></span>
                REGRESAR
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>