<?php
class MojangSkin {
    static function getskin($uuid) {
        global $profile;
        $json = file_get_contents($profile.'/'.$uuid);
        $data = json_decode($json,true);
        $skinjson = base64_decode($data['properties'][0]['value']);
        return $skinjson;
    }
}