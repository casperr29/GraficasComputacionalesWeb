<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
      I
    />
    <link rel="stylesheet" href="css/oneplayer.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <script type="module" id="lvl1">
      import * as THREE from "/js/three.module.js";
      import { OrbitControls } from "/js/OrbitControls.js";
      import { GLTFLoader } from "/js/GLTFLoader.js";
      import { FBXLoader } from "/js/FBXLoader.js";

      ////////////////////////variables////////////////////////
      var clock, deltaTime;
      var miniWindowSize = {
        width: window.innerWidth,
        height: window.innerHeight,
      };

      var right1 = false,
        left1 = false,
        right2 = false,
        left2 = false;
      ////////////////////////loaders////////////////////////
      const backgroundLoader = new THREE.TextureLoader();
      const fbxLoader = new FBXLoader();
      const gltfLoader = new GLTFLoader();

      ////////////////////////setup scene////////////////////////
      clock = new THREE.Clock();
      const scene = new THREE.Scene();
      const currentTheme = localStorage.getItem("currentTheme");

      switch (currentTheme) {
        case "1":
          scene.background = backgroundLoader.load("/imagenes/OPFondo1.png");

          break;

        case "2":
          scene.background = backgroundLoader.load("/imagenes/OPFondo2.png");

          break;

        case "3":
          scene.background = backgroundLoader.load("/imagenes/OPFondo3.png");

          break;

        default:
          scene.background = backgroundLoader.load("/imagenes/OPFondo1.png");
          break;
      }
      const camera = new THREE.PerspectiveCamera(
        50,
        miniWindowSize.width / miniWindowSize.height
      );
      camera.position.set(0, 0, 180);

      const renderer = new THREE.WebGLRenderer({ precision: "mediump" });
      renderer.setClearColor(new THREE.Color(0, 0, 0));
      renderer.setPixelRatio(miniWindowSize.width / miniWindowSize.height);
      renderer.setSize(miniWindowSize.width, miniWindowSize.height);
      document.body.appendChild(renderer.domElement);
      //const cameraControl = new OrbitControls(camera, renderer.domElement)

      ////// Players //////

      fbxLoader.load("/assets/free_car_1.fbx", (rover) => {
        rover.position.set(0, -58, 0);
        rover.scale.set(15, 15, 15);

        rover.rotateY(3.142);
        rover.rotateZ(0);

        scene.add(rover);
        rover.name = "rover";
      });

      fbxLoader.load("/assets/Gema_ED.fbx", (gem) => {
        const [x, y, z] = Array(3)
          .fill()
          .map(() => THREE.MathUtils.randFloatSpread(100));
        gem.position.set(x, 1, 1);
        gem.rotation.x += 0.01;
        gem.rotation.y += 0.01;
        gem.scale.set(0.1, 0.1, 0.1);
        scene.add(gem);
        gem.name = "gem";
      });

      fbxLoader.load("/assets/cone2_fbx.fbx", (cono) => {
        const [x, y, z] = Array(3)
          .fill()
          .map(() => THREE.MathUtils.randFloatSpread(100));
        cono.position.set(x, 1, 1);
        cono.rotation.x += 0.01;
        cono.rotation.y += 0.01;
        cono.scale.set(0.4, 0.4, 0.4);
        scene.add(cono);
        cono.name = "cono";
      });

      fbxLoader.load("/assets/cone2_fbx.fbx", (cono1) => {
        const [x, y, z] = Array(3)
          .fill()
          .map(() => THREE.MathUtils.randFloatSpread(100));
        cono1.position.set(x, 1, 1);
        cono1.rotation.x += 0.01;
        cono1.rotation.y += 0.01;
        cono1.scale.set(0.4, 0.4, 0.4);
        scene.add(cono1);
        cono1.name = "cono1";
      });

      ////////////////////////luces////////////////////////
      const directionalLight = new THREE.DirectionalLight(0xffffff);
      directionalLight.position.set(30, 30, 0);
      //scene.add(directionalLight);
      const ambientlight = new THREE.AmbientLight();
      scene.add(ambientlight);

      ////////////////////////movement////////////////////////
      function movis(obj1, obj2) {
        document.onkeydown = function (e) {
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
        };
        document.onkeyup = function (e) {
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

      function animate() {
        requestAnimationFrame(animate);
        //character.rotation.x += 0.01;
        //character.rotation.y += 0.01;
        var rover = scene.getObjectByName("rover");

        movis(rover);

        ///////MOVIMIENTOS DE GEMA Y OBSTACULOS //////////
        var gem = scene.getObjectByName("gem");
        gem.position.y -= 0.7;
        if (gem.position.y <= -80) {
          gem.position.y = 1;
          const [x, y, z] = Array(3)
            .fill()
            .map(() => THREE.MathUtils.randFloatSpread(100));
          gem.position.set(x, 1, 1);
        }

        var cono = scene.getObjectByName("cono");
        cono.position.y -= 0.7;
        if (cono.position.y <= -80) {
          const [x, y, z] = Array(3)
            .fill()
            .map(() => THREE.MathUtils.randFloatSpread(100));
          cono.position.set(x, 1, 1);
        }

        var cono1 = scene.getObjectByName("cono1");
        cono1.position.y -= 0.7;
        if (cono1.position.y <= -80) {
          const [x, y, z] = Array(3)
            .fill()
            .map(() => THREE.MathUtils.randFloatSpread(100));
          cono1.position.set(x, 1, 1);
        }

        /////MOVIMIENTO DE CARROS////
        if (left1 == true) {
          rover.position.x -= 1;
          if (rover.position.x < -125) {
            rover.position.x = -125;
          }
        }
        if (right1 == true) {
          rover.position.x += 1;
          if (rover.position.x > 125) {
            rover.position.x = 125;
          }
        }
        renderer.render(scene, camera);
      }

      animate();
    </script>

    <div
      id="inferior"
      class="d-flex flex-row align-items-center justify-content-between"
    >
      <a href="#modalPause" class="btn-neon mx-3">
        <span id="span1"></span>
        <span id="span2"></span>
        <span id="span3"></span>
        <span id="span4"></span>
        PAUSAR JUEGO
      </a>

      <div class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-light text-center">Objetos Recogidos</h2>
        <h3 class="text-light text-center">1</h3>
      </div>

      <div class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-light text-center">Puntuación</h2>
        <h3 class="text-light text-center">1000000000</h3>
      </div>

      <!-- <i class="bx bx-time"></i> -->
    </div>

    <div
      class="overlay d-flex justify-content-center align-items-center"
      id="modalPause"
    >
      <div
        class="container-neon d-flex flex-column justify-content-center align-items-center position-relative"
      >
        <a href="#" class="close fs-1 text-light top-0 end-0">&times;</a>
        <h3 class="display-4">PAUSA</h3>
        <a href="#" class="close btn-neon">
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
  </body>
</html>