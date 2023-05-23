<?php

include("conect.php");

$con = conectar();
$result;
$sql;

if ($_POST) {

    if (strlen($_POST['iPlayerName']) >= 1 and strlen($_POST['iPlayerScore']) >= 1) {

        $PLAYER_NAME = $_POST['iPlayerName'];
        $PLAYER_SCORE = $_POST['iPlayerScore'];

        switch ($_POST['tableIndex']) {
            case 1:
                $sql = "INSERT INTO SINGLEPLAYER_TIME_SCORES(PLAYER_NAME,PLAYER_SCORE) VALUES ('$PLAYER_NAME', $PLAYER_SCORE)";
                break;
            case 2:
                $sql = "INSERT INTO SINGLEPLAYER_OBJECTS_SCORES(PLAYER_NAME,PLAYER_SCORE) VALUES ('$PLAYER_NAME', $PLAYER_SCORE)";
                break;
            case 3:
                $sql = "INSERT INTO MULTIPLAYER_TIME_SCORES(PLAYER_NAME,PLAYER_SCORE) VALUES ('$PLAYER_NAME', $PLAYER_SCORE)";
                break;
            case 4:
                $sql = "INSERT INTO MULTIPLAYER_OBJECTS_SCORES(PLAYER_NAME,PLAYER_SCORE) VALUES ('$PLAYER_NAME', $PLAYER_SCORE)";
                break;

            default:
                # code...
                break;
        }


        $result = mysqli_query($con, $sql);
        //header("index.html");
        //exit();
    }
}
