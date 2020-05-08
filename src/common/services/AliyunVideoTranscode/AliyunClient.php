<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/21
 * Time: 16:11
 */

namespace common\services\AliyunVideoTranscode;

use function common\services\AliyunVideoTranscode\AliyunTools\Aliyun;

require_once __DIR__.'/../../../../vendor/aliyuncs/aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';
require_once __DIR__ . '/AliyunTools/AliyunContainer.php';

class AliyunClient extends AliyunClientBase
{
    private static $instance;

    private function __construct(){}

    public static function GetInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClient($client)
    {
        $aliasesMapsKeys = array_keys(Aliyun('AliyunAliasesMaps'));
        if (!in_array($client, $aliasesMapsKeys)) throw new \Exception(AliyunError::CLASS_NO_FOUND[1], AliyunError::CLASS_NO_FOUND[0]);
        $objectClass=$this->ByAliasGetRegisterObject(Aliyun('AliyunAliasesMaps')[$client]['className']);
        $objectClass->alias=$client;
        return $objectClass;
    }

    public function __call($method, $args)
    {
        Ali::init();
        return $this->getClient($method);
    }

    private function __clone(){}
}