<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
$type = $_GET['type'];
$method = $_GET['method'];
$user = $_GET['name'];
$size = $_GET['size'];
$email = $_GET['email'];
$uuid_o = $_GET['uuid'];
$uuid = str_replace('-', '', $uuid_o);
$skinhash = $_GET['skinhash'];
$port = (int)$_GET['port'];
global $mcserver, $baseport;
switch ($type) {
    case 'severstat';
        header('content-type:application/json;charset=utf8');
        switch ($method) {
            case 'perf';
                if ($port == 0) {
                    $port = $baseport;
                }
                $pingdata = ($mcping->GetStatus($mcserver, $port)->Response());
                $isonline = $pingdata['online'];
                if (!$isonline) {
                    $onlinestat = 0;
                } else {
                    $onlinestat = 1;
                }
                $db->cacheOnlineStatus($onlinestat, $port);
                $online = $db->readOnlineStatus($port);
                $onlinep = $db->readOnlineStatus($baseport);
                if ($online == 1 && $onlinep == 1) {
                    $perfdata = $db->getServerStats($port);
                    $getdata = array(
                        'servername' => $perfdata[0],
                        'tps' => $perfdata[1],
                        'cpu' => $perfdata[2],
                        'ram' => $perfdata[3],
                        'entities' => $perfdata[4],
                        'chunks' => $perfdata[5]
                    );

                    echo json_encode($getdata, JSON_PRETTY_PRINT);
                    exit;
                } else {
                    $getdata = array(
                        'servername' => 'none',
                        'tps' => 0,
                        'cpu' => 0,
                        'ram' => 0,
                        'entities' => 0,
                        'chunks' => 0
                    );
                    echo json_encode($getdata, JSON_PRETTY_PRINT);
                    exit;
                }
                break;
            case 'playerping';
                if ($port == 0) {
                    $port = $baseport;
                }
                $pingdata = ($mcping->GetStatus($mcserver, $port)->Response());
                $isonline = $pingdata['online'];
                if (!$isonline) {
                    $onlinestat = 0;
                } else {
                    $onlinestat = 1;
                }
                $db->cacheOnlineStatus($onlinestat, $port);
                $online = $db->readOnlineStatus($port);
                $onlinep = $db->readOnlineStatus($baseport);
                if ($isonline == 1 && $onlinep == 1) {
                    $avgping = $db->getPlayerPing($port);
                    if ($avgping != false) {
                        $avgpingdata = array(
                            'max' => $avgping[0],
                            'min' => $avgping[1],
                            'avg' => $avgping[2]
                        );
                        echo json_encode($avgpingdata, JSON_PRETTY_PRINT);
                        exit;
                    } else {
                        $avgpingdata = array(
                            'max' => 0,
                            'min' => 0,
                            'avg' => 0
                        );
                        echo json_encode($avgpingdata, JSON_PRETTY_PRINT);
                        exit;
                    }
                } else {
                    $avgpingdata = array(
                        'max' => 0,
                        'min' => 0,
                        'avg' => 0
                    );
                    echo json_encode($avgpingdata, JSON_PRETTY_PRINT);
                    exit;
                }
                break;
        }
        break;
    case 'mcping';
        header('content-type:application/json;charset=utf8');
        if ($port == 0) {
            $port = $baseport;
        }
        $pingdata = ($mcping->GetStatus($mcserver, $port)->Response());
        $isonline = $pingdata['online'];
        if (!$isonline) {
            $onlinestat = 0;
        } else {
            $onlinestat = 1;
        }
        $db->cacheOnlineStatus($onlinestat, $port);
        $online = $db->readOnlineStatus($port);
        $onlinep = $db->readOnlineStatus($baseport);
        $onlineplayers = $pingdata['players'];
        $maxplayers = $pingdata['max_players'];
        $serverlat = $pingdata['ping'];
        if ($online == 1 && $onlinep == 1) {
            $serverstatus = array(
                'onlineplayers' => $onlineplayers,
                'maxplayers' => $maxplayers,
                'timeout' => $serverlat
            );
            echo json_encode($serverstatus, JSON_PRETTY_PRINT);
            exit;
        } else {
            $serverstatus = array(
                'onlineplayers' => 0,
                'maxplayers' => 0,
                'timeout' => 0
            );
            echo json_encode($serverstatus, JSON_PRETTY_PRINT);
            exit;
        }
        break;
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
            if ($db->isVerified($uuid) == false) {
                $skininfo = skinhash::skininfo($uuid);
                $ucplayer = $db->getUserFromUcenter($uuid);
                if (!$db->isSkinHashSameAsDatabase($skininfo[0], $uuid)) {
                    $db->creSkinData($skininfo[0], $skininfo[1], $skininfo[2], $ucplayer, $uuid);
                    $db->updatePlayer($ucplayer, $uuid);
                    $skindata = $db->getSkinInfo($uuid);
                } else {
                    $db->updateCape($skininfo[1], $uuid);
                    $db->updatePlayer($ucplayer, $uuid);
                    $skindata = $db->getSkinInfo($uuid);
                }
                $skinjson = getSkinJson($skindata[5], $skindata[4], $skindata[3], $skindata[0], $skindata[2], $skindata[1], $skinurl);
                echo $skinjson;
                break;
            } else {
                $skinjson = mojangskin::getskin($uuid);
                echo $skinjson;
            }
            break;
        } else {
            $skinjson = mojangskin::getskin($uuid);
            echo $skinjson;
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
                    if (!$db->isPlayerGenuine($user)) {
                        echo getAvatarByName($user, $size);
                        break;
                    } else {
                        $puuid = file_get_contents("https://api.zhjlfx.cn/?type=getuuid&method=name&name=".$user);
                        echo file_get_contents("https://api.zhjlfx.cn/?type=getavatar&method=uuid&uuid=".$puuid."&size=".$size);
                        break;
                    }

                    case 'uuid';
                        if (!$db->isUuidExist($uuid)) {
                            echo getAvatarByUuid($uuid, $size);
                            exit;
                        } else {
                            if (!$db->isVerified($uuid)) {
                                $player = $db->getNameByUuid($uuid);
                                echo getAvatarByName($player, $size);
                                exit;
                            } else {
                                echo getAvatarByUuid($uuid, $size);
                                exit;
                            }
                        }
                        break;
                    case 'dz';
                        echo getAvatarFromDz($user);
                        exit;
                }
                break;
                case 'getuuid';
                    switch ($method) {
                        case 'name';
                            if (!$db->getUuidByName($user)) {
                                echo getMojangUuid::uuid($user);
                                exit;
                            } else {
                                if ($db->isPlayerGenuine($user)) {
                                    if (getMojangUuid::uuid($user) == '') {
                                        echo $db->getUuidByName($user);
                                        exit;
                                    } else {
                                        echo getMojangUuid::uuid($user);
                                        exit;
                                    }

                                } else {
                                    echo $db->getUuidByName($user);
                                    exit;
                                }
                                break;
                            }
                            break;
                        case 'email';
                            if ($db->getSkinUuid($email)) {
                                echo $db->getSkinUuid($email);
                                exit;
                            } else {
                                echo '';
                                exit;
                            }
                            break;
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
                    case 'getcsl';
                        header('content-type:application/json;charset=utf8');
                        $csldata = $db->getCSLData($user);
                        echo getCSL($csldata);
                        break;
                    case 'skinimage';
                        header('Content-type: image/png');
                        $path = $_SERVER['DOCUMENT_ROOT'].'/textures/'.$skinhash;
                        $image = file_get_contents($path);
                        $size = filesize($path);
                        header('Content-length: '.$size);
                        echo $image;
                        break;
                    case 'skin2head';
                        $skinurl = "https://skin.prin.studio/skin/".$user.".png";
                        $data = skin2head::getskin($skinurl, $size);
                        echo $data;

                }