<?php
    $a = 'c:/';
    $handle = opendir($a);
    while(FALSE != ($file = readdir($handle))){
        if(is_dir($a.$file)){
            echo $file.'<br/>';
        }
    }
?>