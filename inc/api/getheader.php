<?php
function getheader($url){
    $preg = preg_match('~HTTP/1\.\d\s+200\s+OK~', @current(get_headers($url)));
    return(bool)$preg;
}