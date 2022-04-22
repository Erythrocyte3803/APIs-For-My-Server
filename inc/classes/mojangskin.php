<?php
class MojangSkin {
    static function getskin($uuid) {
        global $support;
        $profile = $support[7];
        $header = get_headers($profile.'/'.$uuid);
        if ($header[0] != "HTTP/1.1 200 OK") {
            $skinjson = '{"timestamp":1597140006232,"profileId":"cabb3c5768f33e1c87a407ad30e355bf","profileName":"noavatar","isPublic":true,"textures":{"SKIN":{"url":"https://api.zhjlfx.cn/textures/83cee5ca6afcdb171285aa00e8049c297b2dbeba0efb8ff970a5677a1b644032","metadata":{"model":"slim"}}}}';
        } else {
            $json = file_get_contents($profile.'/'.$uuid);
            $data = json_decode($json,true);
            $skinjson = base64_decode($data['properties'][0]['value']);
        }
        return $skinjson;
    }
}