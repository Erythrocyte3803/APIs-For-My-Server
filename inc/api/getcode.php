<?php
function encode($name){
    $res = urlencode($name);
    return $res;
}
function decode($name){
    $res = urldecode($name);
    return $res;
}