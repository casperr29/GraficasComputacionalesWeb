<?php

include("conect.php");

$con = conectar();
$result;
$sql;

if ($_POST) {

    if (strlen($_POST['PLAYER_PLAYER_NAME']) >= 1 and strlen($_POST['PLAYER_SCORE']) >= 1) {

        $PLAYER_NAME = $_POST['PLAYER_NAME'];
        $PLAYER_SCORE = $_POST['PLAYER_SCORE'];

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
    }
}
