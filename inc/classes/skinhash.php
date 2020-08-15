<?php
class skinhash {
    static function skininfo($uuid) {
        global $support;
        $api = $support[5];
        $res = $api.'/?type=getskin&method=uuid&uuid='.$uuid;
        $res_cape = $api.'/?type=getcape&method=uuid&uuid='.$uuid;
        $img = file_get_contents($res);
        $hash = datahash::sha256($img);
        $savepath = $_SERVER['DOCUMENT_ROOT'].'/textures/'.$hash;
        file_put_contents($savepath,$img);
        //判断皮肤模型类型[Steve(Default)/Alex(Slim)]//
        $model = skinviewer2d::createPreview($savepath);
        if (@fopen($res_cape,'r')) {
            $img_cape = file_get_contents($res_cape);
            $capehash = datahash::sha256($img_cape);
            $savepath_cape = $_SERVER['DOCUMENT_ROOT'].'/textures/'.$capehash;
            file_put_contents($savepath_cape,$img_cape);
        }
        if (!$model) {
            $model = 'Steve';
        } else {
            $model = 'Alex';
        }
        return array($hash,$capehash,$model);
    }
}