<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getSkinByName($player) {
    global $support;
    $skin1 = $support[0].'/skin/'.$player.'.png';
    $skin2 = $support[1].'/skin/'.$player.'.png';
    $skin3 = $support[2].'/skin/'.$player;
    $default = $support[0].'/skin/noavatar.png';
    if (@fopen($skin1,'r')) {
        return file_get_contents($skin1);
        exit;
    } else if (@fopen($skin2,'r')) {
        return file_get_contents($skin2);
        exit;
    } else if (@fopen($skin3,'r')) {
        return file_get_contents($skin3);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }
}
function getSkinByUuid($uuid) {
    global $support;
    $uuidskin = $support[2].'/skin/'.$uuid;
    $default = $support[0].'/skin/noavatar.png';
    if (@fopen($uuidskin,'r')) {
        return file_get_contents($uuidskin);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }
}