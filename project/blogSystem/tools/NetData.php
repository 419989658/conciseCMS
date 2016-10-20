<?php

/**
 * User: keven
 * Date: 2016/10/20
 * Time: 13:07
 */

//参考 http://www.nowamagic.net/academy/detail/12220245
class NetData
{
    public static function fileGetContents($url,$flag=null)
    {
        return file_get_contents($url);
    }

}