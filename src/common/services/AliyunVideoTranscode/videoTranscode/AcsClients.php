<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:01
 */

namespace common\services\AliyunVideoTranscode\videoTranscode;

use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliApi;
use common\services\AliyunVideoTranscode\ClientInterface;

class AcsClients extends AliApi  implements ClientInterface
{
    public function client()//获取转码client
    {
        $config=Ali::$aliCommonConfig;
        $clientProfile = \DefaultProfile::getProfile($config['mpsRegionId'], $config['accessKeyId'], $config['accessKeySecret']);
        $client = new \DefaultAcsClient($clientProfile);
        Ali::$aliClient=$client;
    }

    public function logicMain($method,$args)
    {
        $clientName=$this->alias;
        $object=$this->distributeLogic($clientName,$method);
        return call_user_func_array([$object,$method],$args);
    }
}