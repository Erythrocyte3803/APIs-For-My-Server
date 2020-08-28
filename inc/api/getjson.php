<?php
function getSkinJson($time,$id,$name,$skin_hash,$model,$cape_hash,$url) {
    $path = $url.'/textures/'.$skin_hash;
    $path_cape = $url.'/textures/'.$cape_hash;
    if ($cape_hash != '') {
        $capeinfo = json_encode($array);
        $skindata = array(
            "timestamp" => $time,
            "profileId" => $id,
            "profileName" => $name,
            "isPublic" => 'true',
            "textures" => array(
                "SKIN" => array(
                    "url" => $path,
                    "metadata" => array(
                        "model" => $model,
                    )
                ),
                "CAPE" => array(
                    "url" => $path_cape
                )
            )
        );
    }else{
        $skindata = array(
            "timestamp" => $time,
            "profileId" => $id,
            "profileName" => $name,
            "isPublic" => 'true',
            "textures" => array(
                "SKIN" => array(
                    "url" => $path,
                    "metadata" => array(
                        "model" => $model,
                    )
                )
            )
        );        
    }
    return json_encode($skindata/*,JSON_PRETTY_PRINT*/);
}