<?php
//API数据库设置//
$host = ''; // mysql服务器主机地址
$port = 3306; //mysql服务器端口
$user = 'root'; // mysql用户名
$pass = ''; // mysql用户名密码
//定义数据库//
$luckperms = 'luckperms'; //LuckPerms数据库
$blessing = 'skin'; //Blessing Skin Server数据库
$ucenter = 'ucenter';//Discuz(Ucenter)数据库
$server_stat = 'server_stat';//plan数据库
$statuscache = 'onlinestatus';//缓存服务器在线状态
$mcserver = ''; //服务器状态查询
$baseport = 0;//服务器默认端口，用于检测服务器状态，如果设为bungeecord的端口，则当bungeecord宕机后，所有子服均会显示无法连接
//支持的皮肤站，可指定多个//
$support = array(
    "https://skin.9jcy.cn",//九境尘域皮肤站，有皮肤和披风API
    "https://mcskin.cn",//红石皮肤站，有皮肤和披风API
    "https://skin.prin.studio",//Blessing皮肤站，有皮肤和披风API
    "https://littleskin.cn",//LittleSkin皮肤站，有皮肤和披风API
    "https://crafthead.net",//Minotar正版皮肤站，有皮肤API
    "https://crafatar.com",//Craftatar正版皮肤站，有皮肤和披风API
    "https://uc.zhjlfx.cn",//仅用来加载Dz论坛的头像
    "https://api.zhjlfx.cn",//方便内部调用
    "https://api.mojang.com/profiles/minecraft",//Mojang 的 API
    "https://sessionserver.mojang.com/session/minecraft/profile"
);
//皮肤加载地址//
$skinurl = 'https://api.zhjlfx.cn';