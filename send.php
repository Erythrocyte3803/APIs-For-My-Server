<?php
require_once('rcon.php');
function getthread($data,$author){
//引用类文件
    //初始化返回数据
    $host = 'play.9cymc.cn';
    // 服务器的ip地址
    $port = 23232;
    // rcon端口，在服务器配置文件里的 rcon.port= 一行
    $password = "A+Koakuma+135";
    // rcon密码，在服务器配置文件里的 rcon.password= 一行
    $timeout = 3000;
    // 连接超时时间

    $rcon = new Rcon($host, $port, $password, $timeout);
    //连接到服务器
    if ($rcon->connect()) {
        $rcon->send_command("sync console all broadcast ".$data);
        $rcon->send_command("give ".$author." paper n &b10金币兑换券 l &a论坛发帖奖励 l &c防伪标识");
        $rcon->send_command("sync console all give ".$author." paper n &a物品兑换券 l &b物品兑换券 l &a论坛发帖奖励 l &c防伪标识");
    } else {
        echo "连接失败！";
        //连接失败时的信息
    }
}
?>