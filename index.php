<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
$type = $_GET['type'];
$method = $_GET['method'];
$user = $_GET['name'];
$size = $_GET['size'];
$uuid_o = $_GET['uuid'];
$uuid = str_replace('-', '', $uuid_o);
switch ($type) {
    case 'getskin';
        header("Content-Type: image/png; charset=utf-8");
        switch ($method) {
            case 'name';
                echo getSkinByName($user);
                break;
            case 'uuid';
                if (!$db->isUuidExist($uuid)) {
                    echo getSkinByUuid($uuid);
                    exit;
                } else {
                    $player = $db->getNameByUuid($uuid);
                    echo getSkinByName($player);
                    exit;
                }
                break;
        }
        break;
    case 'getjson';
        header('content-type:application/json;charset=utf8');
        if ($db->isUuidExist($uuid)) {
            if (!$db->isVerified($uuid)) {
                $skininfo = skinhash::skininfo($uuid);
                $ucplayer = $db->getUserFromUcenter($uuid);
                if (!$db->isSkinHashSameAsDatabase($skin_hash,$uuid)) {
                    $db->creSkinData($skininfo[0],$skininfo[1],$skininfo[2],$ucplayer,$uuid);
                    $db->updatePlayer($ucplayer,$uuid);
                    $skindata = $db->getSkinInfo($uuid);
                } else {
                    $db->updateCape($skininfo[1],$uuid);
                    $db->updatePlayer($ucplayer,$uuid);
                    $skindata = $db->getSkinInfo($uuid);
                }
                $skinjson = getSkinJson($skindata[5],$skindata[4],$skindata[3],$skindata[0],$skindata[2],$skindata[1],$skinurl);
                break;
            } else {
                $skinjson = mojangskin::getskin($uuid);
            }
            echo $skinjson;
            break;
        } else {
            echo '{"timestamp":1597140006232,"profileId":"cabb3c5768f33e1c87a407ad30e355bf","profileName":"noavatar","isPublic":true,"textures":{"SKIN":{"url":"https://api.zhjlfx.cn/textures/83cee5ca6afcdb171285aa00e8049c297b2dbeba0efb8ff970a5677a1b644032","metadata":{"model":"slim"}}}}';
            break;
        }
    case 'getcape';
        header("Content-Type: image/png; charset=utf-8");
        switch ($method) {
            case 'name';
                echo getCapeByName($user);
                break;
            case 'uuid';
                if (!$db->isUuidExist($uuid)) {
                    echo getCapeByUuid($uuid);
                    exit;
                } else {
                    $player = $db->getNameByUuid($uuid);
                    echo getCapeByName($player);
                    exit;
                }
                break;
        }
        break;
    case 'getavatar';
        header("Content-Type: image/png; charset=utf-8");
        switch ($method) {
            case 'name';
                echo getAvatarByName($user,$size);
                break;
            case 'uuid';
                if (!$db->isUuidExist($uuid)) {
                    echo getAvatarByUuid($uuid,$size);
                    exit;
                } else {
                    $player = $db->getNameByUuid($uuid);
                    echo getAvatarByName($player,$size);
                    exit;
                }
                break;
            case 'dz';
                echo getAvatarFromDz($user);
                exit;
        }
        break;
    case 'getuuid';
        if (!$db->getUuidByName($user)) {
            echo getMojangUuid::uuid($user);
            exit;
        } else {
            echo $db->getUuidByName($user);
            exit;
        }
    case 'gen';
        switch ($method) {
            case 'name';
                if (!$db->isPlayerGenuine($user)) {
                    echo '玩家 '.$user.' 不是Minecraft正版玩家';
                    exit;
                } else {
                    echo '玩家 '.$user.' 是Minecraft正版玩家';
                    exit;
                }
                break;
            case 'uuid';
                $result = $db->isUuidGenuine($uuid);
                echo '玩家名：'.$result[0].'<br>玩家UUID：'.$result[1].'<br>是否为正版玩家：'.$result[2];
                break;
        }
        break;
    case 'namecode';
        switch ($method) {
            case 'encode';
                if (!$db->isUserExist($user)) {
                    break;
                } else {
                    $encoded = encode($user);
                    echo $encoded;
                    break;
                }
            case 'decode';
                $decoded = decode($user);
                echo $decoded;
                break;
        }
        break;
}