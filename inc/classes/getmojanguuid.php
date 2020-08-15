<?php
class getMojangUuid {
    static function uuid($pname) {
        global $support;
        if (preg_match('/^[_0-9a-zA-Z]{1,16}$/i',$pname)) {
            $data = array($pname);
            $uuidurl = $support[6];
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'content-type:application/json;charset=utf8',
                    'content' => json_encode($data),
                    'timeout' => 15*60
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($uuidurl,false,$context);
            $data_json = json_decode($result,true);
            $res = $data_json[0]['id'];
            if ($res != "") {
                return $res;
            } else {
                return false;
            }
        }else {
            return false;
        }
    }
}