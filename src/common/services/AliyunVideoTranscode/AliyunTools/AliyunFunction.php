<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:30
 */

namespace common\services\AliyunVideoTranscode\AliyunTools;


use common\services\AliyunVideoTranscode\AliyunDesignPatterns\AliyunRegister;
use common\services\AliyunVideoTranscode\AliyunDesignPatterns\AliyunSingle;

class AliyunFunction
{
    static function load(){}
}

function Aliyun(String $config)
{
    if ($config) {
        if (is_null(AliyunRegister::Get($config))) {
            AliyunRegister::Set($config, AliyunSingle::GetInstance()[$config]);
        }
    }
    return AliyunRegister::Get($config);
}

function AliResponse($result_code,$error_code,$message,$data)//统一接口返回结果
{
    return [
        'result_code'=>$result_code,
        'error_code'=>$error_code,
        'message'=>$message,
        'data'=>$data,
    ];
}