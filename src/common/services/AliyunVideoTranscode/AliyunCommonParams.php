<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 10:12
 */

namespace common\services\AliyunVideoTranscode;

/**
 * 阿里云公共参数配置
 * Class AliyunCommonParams
 * @package common\services\AliyunVideoTranscode
 */
class AliyunCommonParams
{
    private $configs = [];//获取配置数据

    protected function setAccessKeyId($accessKeyId)//阿里云主账号AccessKeyId
    {
        $this->configs['accessKeyId'] = $accessKeyId;
    }

    protected function setAccessKeySecret($accessKeySecret)//阿里云主账号Access Key Secret
    {
        $this->configs['accessKeySecret'] = $accessKeySecret;
    }

    protected function setEndpoint($endpoint)//地域节点
    {
        $this->configs['endpoint'] = $endpoint;
    }

    protected function setMpsRegionId($mpsRegionId)//mps region id
    {
        $this->configs['mpsRegionId'] = $mpsRegionId;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}