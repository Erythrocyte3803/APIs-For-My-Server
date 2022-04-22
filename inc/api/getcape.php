<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getCapeByName($name) {
    global $support;
    $cape1 = $support[0].'/cape/'.$name.'.png';
    $cape2 = $support[1].'/cape/'.$name.'.png';
    $cape3 = $support[2].'/cape/'.$name.'.png';
    $cape4 = $support[3].'/cape/'.$name.'.png';
    $mojang = getMojangUuid::uuid($name);
    $cape5 = $support[5].'/capes/'.$mojang;
    if (getheader($cape1)) {
        return file_get_contents($cape1);
        exit;
    } else if (getheader($cape2)) {
        return file_get_contents($cape2);
        exit;
    } else if (getheader($cape3)) {
        return file_get_contents($cape3);
        exit;
    } else if (getheader($cape4)) {
        return file_get_contents($cape4);
        exit;
    } else if (getheader($cape5)) {
        return file_get_contents($cape5);
        exit;
    } else {
        return header(Exceptions::$codes[404]);;
        exit;
    }
}
function getCapeByUuid($uuid) {
    $uuidcape = $support[8].'/capes/'.$uuid;
    if (getheader($uuidcape)) {
        return file_get_contents($uuidcape);
        exit;
    } else {
        return header(Exceptions::$codes[404]);;
        exit;
    }
}