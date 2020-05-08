<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 8:48
 */

namespace common\services\AliyunVideoTranscode;


use common\services\AliyunVideoTranscode\AliyunDesignPatterns\AliyunRegister;

class AliyunClientBase
{
    //通过别名获取类实例
    public function ByAliasGetRegisterObject($alias)
    {
        $object = AliyunRegister::Get($alias);
        if (!isset($object)) {
            if (!class_exists($alias)) throw new \Exception(AliyunError::NO_FOUND_CLASS_ALIAS[1] . $alias, AliyunError::NO_FOUND_CLASS_ALIAS[0]);
            $object = new $alias();
            AliyunRegister::Set($alias, $object);
        }
        return $object;
    }
}