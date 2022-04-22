<?php
class skin2head {
    static function getskin($skinurl, $size) {
        $ch = curl_init($skinurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status == 200) {
            $skin = file_get_contents($skinurl);
            $im = imagecreatefromstring($skin);
            $view = 'f';
            $av = imagecreatetruecolor($size, $size);
            $x = array('f' => 8, 'l' => 16, 'r' => 0, 'b' => 24);
            imagecopyresized($av, $im, 0, 0, $x[$view], 8, $size, $size, 8, 8);
            imagecolortransparent($im, imagecolorat($im, 63, 0));
            imagecopyresized($av, $im, 0, 0, $x[$view] + 32, 8, $size, $size, 8, 8);
            header('Content-type: image/png');
            imagepng($av);
            imagedestroy($im);
            imagedestroy($av);
            exit();
        } else {
            return header("status: 404 Not Found");
            exit;
        }
    }
}