<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" I />
    <link rel="stylesheet" href="css/oneplayer.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <script src="js/jquery.js"></script>

    <script type="text/javascript" src="js/three2.js"></script>
    <!-- <script type="text/javascript" src="js/OrbitControls.js"></script> -->
    <!-- <script type="text/javascript" src="js/GLTFLoader.js"></script> -->
    <script type="text/javascript" src="js/FBXLoader2.js"></script>
    <script type="text/javascript" src="js/inflate.min.js"></script>


    <script type="text/javascript">
    // import * as THREE from "/js/three.module.js";
    // import {
    //   OrbitControls
    // } from "/js/OrbitControls.js";
    // import {
    //   GLTFLoader
    // } from "/js/GLTFLoader.js";
    // import {
    //   FBXLoader
    // } from "/js/FBXLoader.js";

    ////////////////////////variables////////////////////////
    var scene;
    var camera;
    var renderer;

    //Material y mesh de prueba
    var geometriaCubo = new THREE.BoxGeometry(1.5, 1.5, 1.5);
    var geometriaPrismaRectangular = new THREE.BoxGeometry(1.0, 1.0, 1.0);
    var materialCubo = new THREE.MeshLambertMaterial({
        color: new THREE.Color(0, 0.6, 0.7),
        wireframe: false,
    });

    var materialCuboInv = new THREE.MeshLambertMaterial({
        color: new THREE.Color(0, 0.6, 0.7),
        opacity: 0.0,
        transparent: true,
    });

    //Objeto maestro de los items
    var items = {
        gems: "gems",
        clocks: "clocks",
        cones: "cones",
        speed_ramps: "speed_ramps",
    };
    //Arreglo de cada tipo de item
    items.gems = [];
    items.clocks = [];
    items.cones = [];
    items.speed_ramps = [];

    ////////////colisiones/////////////
    var rayCaster;
    var collisionItems = [];
    var detectionDistace = 20;

    ////////////manejo del tiempo/////////////

    var clock;
    var start_clock;
    var deltaTime;
    var isPaused = false;
    var distanceLeft = 5000;

    var miniWindowSize = {
        width: window.innerWidth,
        height: window.innerHeight,
    };

    ////////////Movimiento/////////////

    var right1 = false,
        left1 = false,
        right2 = false,
        left2 = false;

    var car_velocity = 100.0;
    var obj_velocity = car_velocity * 0.6;
    var track_size = 60;
    var obj_z_distance = -5.0;
    var player_score = 0;
    var player_progress = 0;
    var player_lifes = 3;
    var keys = {};

    ////////////////////////loaders////////////////////////
    const backgroundLoader = new THREE.TextureLoader();
    const fbxLoader = new THREE.FBXLoader();
    // const fbxLoader = new FBXLoader();
    // const gltfLoader = new GLTFLoader();

    ////////////////////////setup scene////////////////////////

    $(document).ready(function() {
        setUpScene();

        rayCaster = new THREE.Raycaster();

        animate();
    });

    function addCollisionBox(item_type, asset) {
        var assetColl = new THREE.Mesh(
            geometriaPrismaRectangular,
            materialCuboInv
        );

        assetColl.taken = false;
        assetColl.model = asset;
        asset.collBox = assetColl;

        asset.add(assetColl);
        assetColl.itemType = item_type;

        items[item_type + "s"].push(assetColl);
    }

    function loadModels() {
        ////// Players //////

        fbxLoader.load("assets/free_car_1.fbx", (rover) => {
            rover.position.set(0, -58, 0);
            rover.scale.set(14, 14, 14);

            rover.rotateY(3.142);
            rover.rotateZ(0);

            scene.add(rover);
            rover.name = "rover";
        });

        fbxLoader.load("assets/cone3.fbx", (cono) => {
            const [x, y, z] = Array(3)
                .fill()
                .map(() => THREE.MathUtils.randFloatSpread(100));
            cono.position.set(x, 1, obj_z_distance);
            cono.scale.set(10, 10, 10);

            addCollisionBox("cone", cono);

            scene.add(cono);
            collisionItems.push(cono.collBox);
            cono.name = "cono";
        });

        fbxLoader.load("assets/cone3.fbx", (cono1) => {
            const [x, y, z] = Array(3)
                .fill()
                .map(() => THREE.MathUtils.randFloatSpread(100));
            cono1.position.set(x, 1, obj_z_distance);
            cono1.scale.set(10, 10, 10);

            addCollisionBox("cone", cono1);

            scene.add(cono1);
            collisionItems.push(cono1.collBox);

            cono1.name = "cono1";
        });

        ////// Items //////

        fbxLoader.load("assets/Gema_ED_02.fbx", (gem) => {
            const [x, y, z] = Array(3)
                .fill()
                .map(() => THREE.MathUtils.randFloatSpread(100));
            gem.position.set(x, 1, obj_z_distance);

            gem.scale.set(12, 12, 12);

            addCollisionBox("gem", gem);

            scene.add(gem);
            collisionItems.push(gem.collBox);

            gem.name = "gem";
        });


    }

    function setUpScene() {
        clock = new THREE.Clock();
        scene = new THREE.Scene();

        const currentTheme = localStorage.getItem("currentTheme");

        switch (currentTheme) {
            case "1":
                scene.background = backgroundLoader.load("imagenes/OPFondo1.png");

                break;

            case "2":
                scene.background = backgroundLoader.load("imagenes/OPFondo2.png");

                break;

            case "3":
                scene.background = backgroundLoader.load("imagenes/OPFondo3.png");

                break;

            default:
                scene.background = backgroundLoader.load("imagenes/OPFondo1.png");
                break;
        }

        camera = new THREE.PerspectiveCamera(
            50,
            miniWindowSize.width / miniWindowSize.height
        );

        camera.position.set(0, 0, 180);

        camera.rays = [
            new THREE.Vector3(1, 0, 0),
            new THREE.Vector3(-1, 0, 0),
            new THREE.Vector3(0, 0, 1),
            new THREE.Vector3(0, 0, -1),
        ];

        renderer = new THREE.WebGLRenderer({
            precision: "mediump"
        });
        renderer.setClearColor(new THREE.Color(0, 0, 0));
        renderer.setPixelRatio(miniWindowSize.width / miniWindowSize.height);
        renderer.setSize(miniWindowSize.width, miniWindowSize.height);
        document.body.appendChild(renderer.domElement);
        //const cameraControl = new OrbitControls(camera, renderer.domElement)

        loadModels();

        ////////////////////////luces////////////////////////
        const directionalLight = new THREE.DirectionalLight(0xffffff);
        directionalLight.position.set(30, 30, 0);
        //scene.add(directionalLight);
        const ambientlight = new THREE.AmbientLight();
        scene.add(ambientlight);
    }

    function updateCollisions(player) {
        for (var i = 0; i < camera.rays.length; i++) {
            rayCaster.set(player.position, camera.rays[i]);

            var collisionIt = rayCaster.intersectObjects(collisionItems, true);

            /////////////////////////////////
            /////COLISIONES CON ITEMS/////
            /////////////////////////////////

            Object.keys(items).forEach(function(key) {
                items[key].forEach(function(item) {
                    if (item.taken && item.model.scale.x > 0) {
                        item.model.scale.x -= 25.5 * deltaTime;
                        item.model.scale.y -= 25.5 * deltaTime;
                        item.model.scale.z -= 25.5 * deltaTime;
                        //item.model.rotation.y += THREE.Math.degToRad(150) * deltaTime;
                    } else if (item.taken) {
                        item.taken = false;
                        const [x, y, z] = Array(3)
                            .fill()
                            .map(() => THREE.MathUtils.randFloatSpread(90));
                        item.model.scale.set(10, 10, 10);
                        item.model.position.set(x, 5, 0.0);
                    }
                });
            });

            if (
                collisionIt.length > 0 &&
                collisionIt[0].distance < detectionDistace
            ) {
                if (!collisionIt[0].object.taken) {
                    collisionIt[0].object.taken = true;

                    if (collisionIt[0].object.itemType == "gem") {
                        console.log("Gema obtenida");
                        player_score += 1000;
                    }

                    if (collisionIt[0].object.itemType == "cone") {
                        console.log("Chocaste con un cono");
                        player_lifes -= 1;
                        player_score -= 1000;
                    }

                    if (collisionIt[0].object.itemType == "clock") {
                        console.log("Enemigos ralentizados");
                        slowerEnemies = true;
                        player_score += 500;
                        timer2.start();
                    }
                }
            }
        }
    }

    ////////////////////////movement////////////////////////
    function movis(obj1, obj2) {
        document.onkeydown = function(e) {
            if (e.keyCode === 37) {
                left1 = true;
            }
            if (e.keyCode === 39) {
                right1 = true;
            }
            if (e.keyCode === 65) {
                left2 = true;
            }
            if (e.keyCode === 68) {
                right2 = true;
            }
            if (e.keyCode === 80 || e.keyCode === 27) {
                isPaused = !isPaused;
                if (isPaused) window.location.href = "#modalPause";
                else window.location.href = "#";
                localStorage.setItem("isPaused", isPaused);
            }
        };
        document.onkeyup = function(e) {
            if (e.keyCode === 37) {
                left1 = false;
            }
            if (e.keyCode === 39) {
                right1 = false;
            }
            if (e.keyCode === 65) {
                left2 = false;
            }
            if (e.keyCode === 68) {
                right2 = false;
            }
        };
    }

    function onKeyDown(event) {
        keys[String.fromCharCode(event.keyCode)] = true;
    }

    function onKeyUp(event) {
        keys[String.fromCharCode(event.keyCode)] = false;
    }

    function animate() {
        requestAnimationFrame(animate);
        //character.rotation.x += 0.01;
        //character.rotation.y += 0.01;
        deltaTime = clock.getDelta();
        var rover = scene.getObjectByName("rover");

        //Obtenemos la teclas presionadas
        movis(rover);

        var pausedState = localStorage.getItem("isPaused");

        if (pausedState != undefined) {
            isPaused = pausedState == "true" ? true : false;
        }
        //Si el juego esta pausado, entonces no seguimos renderizando
        if (isPaused) return;

        $("#playerScore").html(player_score);
        $("#playerProgress").html(distanceLeft);

        ///////////PLAYER UPDATES//////////
        if (left1 == true) {
            rover.position.x -= car_velocity * deltaTime;
            if (rover.position.x < -track_size) {
                rover.position.x = -track_size;
            }
        }
        if (right1 == true) {
            rover.position.x += car_velocity * deltaTime;
            if (rover.position.x > track_size) {
                rover.position.x = track_size;
            }
        }

        /////////////ITEMS UPDATES///////////
        if (clock.running && clock.getElapsedTime() > 3) {
            player_progress += Math.ceil(car_velocity * deltaTime);
            distanceLeft -= Math.ceil(player_progress * 0.001);
            if (distanceLeft <= 0) {
                distanceLeft = 0;
                $("#playerProgress").html(distanceLeft);
                isPaused = true;
                localStorage.setItem("isPaused", isPaused);
                $("#modalPlayerName").html(localStorage.getItem("playerName1"));
                $("#modalPlayerScore").html(player_score);
                $("#iPlayerName").val(localStorage.getItem("playerName1"));
                $("#iPlayerScore").val(player_score);
                window.location = "#modalSubmitScore";
                clock.stop();
            }

            ///////MOVIMIENTOS DE GEMA Y OBSTACULOS //////////
            var gem = scene.getObjectByName("gem");
            if (gem != undefined) {
                gem.position.y -= obj_velocity * deltaTime;
                gem.rotation.y += 0.01;
                gem.collBox.rotation.y -= 0.01;
                if (gem.position.y <= -80) {
                    const [x, y, z] = Array(3)
                        .fill()
                        .map(() => THREE.MathUtils.randFloatSpread(90));
                    gem.position.set(x, 10, obj_z_distance);
                }
            }

            var cono = scene.getObjectByName("cono");
            if (cono != undefined) {
                cono.position.y -= obj_velocity * deltaTime;
                if (cono.position.y <= -80) {
                    const [x, y, z] = Array(3)
                        .fill()
                        .map(() => THREE.MathUtils.randFloatSpread(85));
                    cono.position.set(x, 5, obj_z_distance);
                }
            }

            var cono1 = scene.getObjectByName("cono1");
            if (cono1 != undefined) {
                cono1.position.y -= obj_velocity * deltaTime;
                if (cono1.position.y <= -80) {
                    const [x, y, z] = Array(3)
                        .fill()
                        .map(() => THREE.MathUtils.randFloatSpread(85));
                    cono1.position.set(x, 15, obj_z_distance);
                }
            }

            updateCollisions(rover);
        }

        renderer.render(scene, camera);
    }
    </script>

    <div id="inferior" class="d-flex flex-row align-items-center justify-content-between">
        <a href="#modalPause" class="btn-neon mx-3">
            <span id="span1"></span>
            <span id="span2"></span>
            <span id="span3"></span>
            <span id="span4"></span>
            PAUSAR JUEGO
        </a>

        <div class="d-flex flex-column justify-content-center align-items-center">
            <h2 class="text-light text-center">Distancia restante</h2>
            <h3 id="playerProgress" class="text-light text-center">1</h3>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center">
            <h2 class="text-light text-center">Puntuación</h2>
            <h3 id="playerScore" class="text-light text-center">1000000000</h3>
        </div>

        <!-- <i class="bx bx-time"></i> -->
    </div>

    <div class="overlay d-flex justify-content-center align-items-center" id="modalPause">
        <div class="container-neon d-flex flex-column justify-content-center align-items-center position-relative">
            <a href="#" class="close fs-1 text-light top-0 end-0" onclick="togglePause()">&times;</a>
            <h3 class="display-4">PAUSA</h3>
            <a href="#" class="close btn-neon" onclick="togglePause()">
                <span id="span1"></span>
                <span id="span2"></span>
                <span id="span3"></span>
                <span id="span4"></span>
                Resumir
            </a>
            <a href="index.html" class="btn-neon">
                <span id="span1"></span>
                <span id="span2"></span>
                <span id="span3"></span>
                <span id="span4"></span>
                Salir al menú
            </a>
        </div>
    </div>

    <div class="overlay d-flex justify-content-center align-items-center" id="modalSubmitScore">
        <div class="container-neon d-flex flex-column justify-content-center align-items-center position-relative">
            <h3 class="display-4 mb-5">Puntuación</h3>
            <h5 id="modalPlayerName" class="display-5 mb-2">JUGADOR</h5>
            <h5 id="modalPlayerScore" class="display-5">0000</h5>
            <form action="#modalSubmitScore" method="post">
                <input hidden type="text" name="iPlayerName" id="iPlayerName" />
                <input hidden type="text" name="iPlayerScore" id="iPlayerScore" />
                <input hidden type="text" name="tableIndex" id="tableIndex" value=2 />
                <button type="submit" class="btn-neon fs-1">
                    <span id="span1"></span>
                    <span id="span2"></span>
                    <span id="span3"></span>
                    <span id="span4"></span>
                    Subir puntuación
                </button>
            </form>

            <?php
            include "db/save_scores.php"
            ?>

            <a href="#" class="btn-neon fs-2" onclick="togglePause('oneplayerObjects')">
                <span id="span1"></span>
                <span id="span2"></span>
                <span id="span3"></span>
                <span id="span4"></span>
                Volver a jugar
            </a>
            <a href="index.html" class="btn-neon fs-2">
                <span id="span1"></span>
                <span id="span2"></span>
                <span id="span3"></span>
                <span id="span4"></span>
                Salir al menú
            </a>
        </div>
    </div>
    <!--  <div class="row">
        <audio controls autoplay>
            <source src ="assets/Musica y Efectos/KnightSpeed.mp3" type="audio/mp3">
        </audio>
    </div>

    <div class="row">
      <audio controls autoplay>
          <source src ="assets/Musica y Efectos/CarEngine.mp3" type="audio/mp3">
      </audio>
  </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script>
    function togglePause(location = "#") {
        var pausedState = localStorage.getItem("isPaused");
        pausedState = pausedState == "true" ? "false" : "true";
        localStorage.setItem("isPaused", pausedState);

        window.location = location == "#" ? location : location + ".html";
    }
    </script>
</body>

</html>