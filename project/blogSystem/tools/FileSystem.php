<?php

/**
 * User: sometimes
 * Date: 2016/11/1
 * Time: 22:02
 */
namespace tools\FileSystem;

class FileSystem
{
    /**
     * 获取磁盘大小
     *      1.若给定一个文件，则计算文件大小，
     *      2.若给定一个文件夹,则计算整个文件夹的大小
     * Note that
     * @param $url
     */
    public static function getDiskSpace($url)
    {
        $fileSize=0;
        if(is_file($url)) return filesize($url);
        if ( is_dir ( $url )) {
            if ( $dh  =  opendir ( $url )) {
                while (( $file  =  readdir ( $dh )) !==  false ) {
                    $fileSize+=self::getDiskSpace($url);
                }
                closedir ( $dh );
            }
        }
        return $fileSize;
    }
}