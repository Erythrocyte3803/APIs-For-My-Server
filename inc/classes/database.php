<?php
class database {
    public $mysqli;
    function __construct() {
        global $host,$port,$user,$pass;
        $iscon = mysqli_connect($host.":".$port,$user,$pass);
        if (!$iscon) {
            echo "无法连接至MySQL数据库：".mysqli_connect_error();
            header(Exceptions::$codes[500]);
            die();
        }
        $this->mysqli = new mysqli($host.":".$port,$user,$pass);
    }
    function query($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $ret->fetch_all();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    function query_change($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $this->mysqli->affected_rows;
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    //通过UUID获取玩家名字//
    function getNameByUuid($uuid) {
        global $blessing,$luckperms,$ucenter;
        $from_blessing = $this->query("select name from ".$blessing.".uuid where uuid = '".$uuid."'");
        $uuid_formated = UUID::createJavaUuid($uuid);
        $from_luckperm = $this->query("select username from ".$luckperms.".luckperms_players where uuid = '".$uuid_formated."'");
        $from_ucenter = $this->query("select username from ".$ucenter.".users where uuid = '".$uuid."'");
        if ($from_blessing[0][0]) {
            return $from_blessing[0][0];
        } else if ($from_luckperm[0][0]) {
            return $from_luckperm[0][0];
        } else if ($from_ucenter[0][0]) {
            return $from_ucenter[0][0];
        } else {
            return false;
        }
    }
    //判断UUID是否存在//
    function isUuidExist($uuid) {
        global $blessing,$luckperms,$ucenter;
        $from_blessing = $this->query("select uuid from ".$blessing.".uuid where uuid = '".$uuid."'");
        $uuid_formated = UUID::createJavaUuid($uuid);
        $from_luckperm = $this->query("select uuid from ".$luckperms.".luckperms_players where uuid = '".$uuid_formated."'");
        $from_ucenter = $this->query("select uuid from ".$ucenter.".users where uuid = '".$uuid."'");
        if ($from_blessing[0][0]) {
            return $from_blessing[0][0];
        } else if ($from_luckperm[0][0]) {
            $puuid = str_replace('-', '', $from_luckperm[0][0]);
            return $puuid;
        } else if ($from_ucenter[0][0]) {
            return $from_ucenter[0][0];
        } else {
            return false;
        }
    }
    //通过UUID获取Ucenter玩家名，用于皮肤json信息//
    function getUserFromUcenter($uuid) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".users where uuid = '".$uuid."'");
        $player = $ret[0][1];
        if (!$ret) {
            return false;
        } else {
            return $player;
        }
    }
    //将皮肤信息写入数据库//
    function creSkinData($skin_hash,$cape_hash,$model,$player,$uuid) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".texturedata where uuid = '".$uuid."'");
        if (!$ret) {
            $this->query_change("insert into ".$ucenter.".texturedata (skin_hash, cape_hash, model, playername, uuid, time) values ('".$skin_hash."', '".$cape_hash."', '".$model."', '".$player."', '".$uuid."', '".time()."')");
        } else {
            $this->query_change("update ".$ucenter.".texturedata set skin_hash = '".$skin_hash."', cape_hash = '".$cape_hash."', model = '".$model."', playername = '".$player."', time = '".time()."' where uuid = '".$uuid."'");
        }
    }
    //判断获取的皮肤HASH是否和数据库的一致//
    function isSkinHashSameAsDatabase($hash,$uuid) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".texturedata where uuid = '".$uuid."'");
        $skinhash = $ret[0][1];
        if (!$ret) {
            return false;
        } else {
            $result = ($hash == $skinhash);
            return $result;
        }
    }
    //查询皮肤信息//
    function getSkinInfo($uuid) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".texturedata where uuid = '".$uuid."'");
        $skinhash = $ret[0][1];
        $capehash = $ret[0][2];
        $model = $ret[0][3];
        $player = $ret[0][4];
        $uuid_db = $ret[0][5];
        $time = $ret[0][6];
        if (!$ret) {
            return false;
        } else {
            if ($model == 'Alex') {
                $type = 'slim';
            } else {
                $type = 'default';
            }
            return array($skinhash,$capehash,$type,$player,$uuid_db,$time);
        }
    }
    //更新数据库皮肤对应的玩家名//
    function updatePlayer($pname,$uuid) {
        global $ucenter;
        $this->query_change("update ".$ucenter.".texturedata set playername = '".$pname."' where uuid = '".$uuid."'");
    }
    //更新披风数据//
    function updateCape($hash,$uuid) {
        global $ucenter;
        $this->query_change("update ".$ucenter.".texturedata set cape_hash = '".$hash."' where uuid = '".$uuid."'");
    }
    //通过玩家名获取UUID//
    function getUuidByName($pname) {
        global $blessing,$luckperms,$ucenter;
        $from_blessing = $this->query("select uuid from ".$blessing.".uuid where name = '".$pname."'");
        $from_luckperm = $this->query("select uuid from ".$luckperms.".luckperms_players where username = '".$pname."'");
        $from_ucenter = $this->query("select uuid from ".$ucenter.".users where username = '".$pname."'");
        if ($from_blessing[0][0]) {
            return $from_blessing[0][0];
        } else if ($from_luckperm[0][0]) {
            $puuid = str_replace('-', '', $from_luckperm[0][0]);
            return $puuid;
        } else if ($from_ucenter[0][0]) {
            return $from_ucenter[0][0];
        } else {
            return false;
        }
    }
    //判断对应玩家是不是正版玩家//
    function isPlayerGenuine($user) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".users where username = '".$user."'");
        $gen = $ret[0][16];
        if ($gen == 'true') {
            return true;
        } else {
            return false;
        }
    }
    //判断对应玩家UUID是不是正版//
    function isUuidGenuine($uuid) {
        global $ucenter;
        $ret = $this->query("select * from ".$ucenter.".users where uuid = '".$uuid."'");
        $gen = $ret[0][16];
        $uuid = $ret[0][14];
        $name = $ret[0][1];
        if (!$ret) {
            return false;
        } else if ($gen != 'true') {
            $res = '非正版玩家';
        } else {
            $res = '正版玩家';
        }
        return array($name,$uuid,$res);
    }
    //判断玩家是否存在//
    function isUserExist($name) {
        global $luckperms;
        $ret = $this->query("select username from ".$luckperms.".luckperms_players where username = '".$name."'");
        if (!$ret[0][0]) {
            return false;
        } else {
            return $ret[0][0];
        }
    }
    //判断玩家是否已完成正版验证//
    function isVerified($uuid) {
        global $ucenter;
        $res = $this->query("select * from ".$ucenter.".users where uuid = '".$uuid."'");
        $verified = $res[0][16];
        if ($verified == 'true') {
            return true;
        } else {
            return false;
        }
    }
    //根据邮箱获取原皮肤站玩家UUID//
    function getSkinUuid($email) {
        global $blessing;
        $pname = $this->query("select nickname from ".$blessing.".users where email = '".$email."'");
        $uuid = $this->query("select uuid from ".$blessing.".uuid where name = '".$pname[0][0]."'");
        if ($uuid[0][0] == "") {
            return false;
        } else {
            return $uuid[0][0];
        }
    }

}