<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 11:31
 */

namespace common\services\AliyunVideoTranscode\fileOss;


use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliApi;
use common\services\AliyunVideoTranscode\ClientInterface;
use OSS\OssClient;

class OssClients extends AliApi implements ClientInterface
{
    public function client()
    {
        $config=Ali::$aliCommonConfig;
        $ossClient = new OssClient($config['accessKeyId'], $config['accessKeySecret'], $config['endpoint'], false);
        Ali::$aliClient = $ossClient;
    }

    public function logicMain($method,$args)
    {
        $clientName=$this->alias;
        $object=$this->distributeLogic($clientName,$method);
        return call_user_func_array([$object,$method],$args);
    }
}