<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/include.php');
function getAvatarByName($name, $size) {
    global $support;
    $path = '/avatar/player/'.$name.'?png&size='.$size;
    $avatar1 = $support[0].$path;
    $avatar2 = $support[1].$path;
    $avatar3 = $support[7]."/?type=skin2head&name=".$name."&size=".$size;
    $avatar4 = $support[3].$path;
    $avatar5 = $support[4].'/helm/'.$name.'/'.$size;
    $default = $support[0].'/avatar/player?png&size='.$size;
    $defmd5 = md5(file_get_contents($default));
    if (getheader($avatar1)) {
        $avatar1md5 = md5(file_get_contents($avatar1));
        if ($avatar1md5 != $defmd5) {
            return file_get_contents($avatar1);
            exit;
        }
        if (getheader($avatar5)) {
            return file_get_contents($avatar5);
            exit;
        }
    }
    if (getheader($avatar2)) {
        $avatar2md5 = md5(file_get_contents($avatar2));
        if ($avatar2md5 != $defmd5) {
            return file_get_contents($avatar2);
            exit;
        }
        if (getheader($avatar5)) {
            return file_get_contents($avatar5);
            exit;
        }
    }
    if (getheader($avatar3)) {
        return file_get_contents($avatar3);
        exit;
    }
    if (getheader($avatar4)) {
        $avatar2md5 = md5(file_get_contents($avatar4));
        if ($avatar2md5 != $defmd5) {
            return file_get_contents($avatar4);
            exit;
        }
        if (getheader($avatar5)) {
            return file_get_contents($avatar5);
            exit;
        }
    }
    if (getheader($avatar5)) {
        return file_get_contents($avatar5);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }

}
function getAvatarByUuid($uuid, $size) {
    global $support;
    $uuidavatar = $support[4].'/helm/'.$uuid."/".$size;
    $default = $support[7].'/?type=getavatar&method=dz&name='.$uuid;
    if (getheader($uuidavatar)) {
        return file_get_contents($uuidavatar);
        exit;
    } else {
        return file_get_contents($default);
        exit;
    }
}
function getAvatarFromDz($name) {
    global $support;
    $dz = $support[6];
    $api = $support[7];
    $def = $dz.'/p_w_picpaths/noavatar_middle.gif';
    $dzuser = $dz.'/avatar2.php?username='.$name.'&size=middle';
    $apiuser = $api.'/?type=getavatar&method=name&name='.$name.'&size=120';
    $dzcontent = file_get_contents($dzuser);
    $dzdef = file_get_contents($def);
    $def_skin = $support[0].'/avatar/player/noavatar?size=120';
    if (md5($dzcontent) == md5($dzdef)) {
        if (getheader($apiuser)) {
            return file_get_contents($apiuser);
            exit;
        } else {
            return file_get_contents($def_skin);
            exit;
        }

    } else {
        return $dzcontent;
        exit;
    }
}