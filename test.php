<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/9
 * Time: 下午1:03
 */
$dir = "./vendor/illuminate/pagination/resources/views";
if(is_dir($dir)){
    echo "{$dir} is a val directory!\n";
}else{
    echo "{$dir} is not a directory!\n";
}