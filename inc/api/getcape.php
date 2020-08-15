<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getCapeByName($name) {
    global $support;
    $cape1 = $support[0].'/cape/'.$name.'.png';
    $cape2 = $support[1].'/cape/'.$name.'.png';
    $mojang = getMojangUuid::uuid($name);
    $cape3 = $support[3].'/capes/'.$mojang;
    if (@fopen($cape1,'r')) {
        return file_get_contents($cape1);
        exit;
    } else if (@fopen($cape2,'r')) {
        return file_get_contents($cape2);
        exit;
    } else if (@fopen($cape3,'r')) {
        return file_get_contents($cape3);
        exit;
    } else {
        return header(Exceptions::$codes[404]);;
        exit;
    }
}
function getCapeByUuid($uuid){
    $uuidcape = $support[3].'/capes/'.$uuid;
        if (@fopen($uuidcape,'r')) {
        return file_get_contents($uuidcape);
        exit;
    } else {
        return header(Exceptions::$codes[404]);;
        exit;
    }
}