<?php
//API数据库设置//
$host = 'your database host'; // mysql服务器主机地址
$port = 3306; //mysql服务器端口
$user = 'your mysql user'; // mysql用户名
$pass = 'your mysql pass'; // mysql用户名密码
//定义数据库//
$luckperms = 'luckperms'; //LuckPerms数据库
$blessing = 'skin'; //Blessing Skin Server数据库
$ucenter = 'ucenter';//Discuz(Ucenter)数据库
//支持的皮肤站，可指定多个//
$support = array(
    "https://skin.9cymc.cn",//九境尘域皮肤站，有皮肤和披风API
    "https://mcskin.littleservice.cn",//LittleSkin皮肤站，有皮肤和披风API
    "https://minotar.net",//Minotar正版皮肤站，有皮肤API
    "https://crafatar.com",//Craftatar正版皮肤站，有皮肤和披风API
    "https://uc.zhjlfx.cn",//仅用来加载Dz论坛的头像
    "https://api.zhjlfx.cn",//方便内部调用
    "https://api.mojang.com/profiles/minecraft",//Mojang 的 API
    "https://sessionserver.mojang.com/session/minecraft/profile"
);
//皮肤加载地址//
$skinurl = 'https://api.zhjlfx.cn';