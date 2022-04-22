<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getSkinByName($player) {
    global $support;
    $skin1 = $support[0].'/skin/'.$player.'.png';
    $skin2 = $support[1].'/skin/'.$player.'.png';
    $skin3 = $support[2].'/skin/'.$player.'.png';
    $skin4 = $support[3].'/skin/'.$player.'.png';
    $skin5 = $support[4].'/skin/'.$player;
    $default = $support[0].'/skin/noavatar.png';
    if (getheader($skin1)) {
        return file_get_contents($skin1);
        exit;
    } else if (getheader($skin2)) {
        return file_get_contents($skin2);
        exit;
    } else if (getheader($skin3)) {
        return file_get_contents($skin3);
        exit;
    } else if (getheader($skin4)) {
        return file_get_contents($skin4);
        exit;
    } else if (getheader($skin5)) {
        return file_get_contents($skin5);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }
}
function getSkinByUuid($uuid) {
    global $support;
    $uuidskin = $support[4].'/skin/'.$uuid;
    $default = $support[0].'/skin/noavatar.png';
    if (@fopen($uuidskin, 'r')) {
        return file_get_contents($uuidskin);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }
}