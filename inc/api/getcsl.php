<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getCSL($csldata) {
    $skin = $csldata[0];
    $cape = $csldata[1];
    $type = $csldata[2];
    $name = $csldata[3];
    if ($name != "") {
        if ($cape != "") {
            $cslout = array(
                "username" => $name,
                "skins" => array(
                    $type => $skin
                ),
                "cape" => $cape
            );
        } else {
            $cslout = array(
                "username" => $name,
                "skins" => array(
                    $type => $skin
                ),
                "cape" => null
            );
        }
        return json_encode($cslout, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        exit;
    }
    header('HTTP/1.1 404 Not Found');
    exit;
}