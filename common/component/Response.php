<?php
namespace common\component;
/**
 * User: keven
 * Date: 2016/9/30
 * Time: 17:13
 */
class Response
{
    public static function encodeJSON($code,$message,$data){
        $result=[
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ];
        echo json_encode($result);
    }

    public static function encodeXML($code,$message,$data){

    }
}