<?php
/**
 * User: keven
 * Date: 2016/10/13
 * Time: 10:56
 */
if(!empty($_POST)) {
    $name = $_POST['name'];
    $total = (int)$_POST['total'];
    $index = (int)$_POST['index'];

    //保存分片到磁盘上

    var_dump($_POST);
    var_dump($_FILES);
    $dir = dirname(__FILE__) . '\\';
    echo $dir . $name . '_' . $index;

    $content = file_get_contents("php://input");
    file_put_contents($dir . $name . '_' . $index, $content);


}


