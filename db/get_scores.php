<?php

include_once("conect.php");

$con = conectar();


switch ($tableIndex) {
    case 1:
        $sql = 'SELECT PLAYER_NAME, PLAYER_SCORE FROM SINGLEPLAYER_TIME_SCORES ORDER BY PLAYER_SCORE ASC';
        break;
    case 2:
        $sql = 'SELECT PLAYER_NAME, PLAYER_SCORE FROM SINGLEPLAYER_OBJECTS_SCORES ORDER BY PLAYER_SCORE DESC';
        break;
    case 3:
        $sql = 'SELECT PLAYER_NAME, PLAYER_SCORE FROM MULTIPLAYER_TIME_SCORES ORDER BY PLAYER_SCORE ASC';
        break;
    case 4:
        $sql = 'SELECT PLAYER_NAME, PLAYER_SCORE FROM MULTIPLAYER_OBJECTS_SCORES ORDER BY PLAYER_SCORE DESC';
        break;

    default:
        $sql = 'SELECT \'Caso_default \' as PLAYER_NAME, 000 as PLAYER_SCORE';

        break;
}

$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    while ($mostrar = mysqli_fetch_array($result)) {

?>
        <tr>
            <td class="fs-5"><?php echo $mostrar['PLAYER_NAME'] ?></td>

            <?php if ($tableIndex == 2 || $tableIndex == 4) {
            ?>

                <td class="fs-5"><?php echo $mostrar['PLAYER_SCORE'] ?></td>

            <?php } else { ?>
                <td class="fs-5"><?php echo intdiv($mostrar['PLAYER_SCORE'], 60) . ':' . ($mostrar['PLAYER_SCORE'] % 60); ?></td>

            <?php } ?>
        </tr>

    <?php
    }
} else {
    ?>
    <tr>
        <td class="fs-6">NO HAY PUNTUACIONES</td>

        <?php if ($tableIndex == 2 || $tableIndex == 4) {
        ?>

            <td class="fs-5">000</td>


        <?php } else { ?>
            <td class="fs-5">0:00</td>


        <?php } ?>
    </tr>

<?php
}
