<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 16:52
 */

namespace common\services\AliyunVideoTranscode;

use function common\services\AliyunVideoTranscode\AliyunTools\Aliyun;
class Ali extends AliyunCommonParams
{
    public static $sysConfig;//系统参数配置

    public static $aliConfig;//阿里云接口参数配置

    public static $aliCommonConfig;//阿里云公共参数配置

    public static $aliClient;//阿里云API实例

    public static function init()
    {
        $rootConfig= getcwd().'\\..\\config\\AliZZHConfig.php';
        if(file_exists($rootConfig)){
            $config=require_once $rootConfig;
        }else{
            $config=Ali::$sysConfig = Aliyun('AliyunConfig');
        }
        $self=new self();
        $self->setAccessKeyId($config['accessKeyId']);
        $self->setAccessKeySecret($config['accessKeySecret']);
        $self->setEndpoint($config['endpoint']);
        $self->setMpsRegionId($config['mpsRegionId']);
        Ali::$aliCommonConfig=$self->configs;
    }
}