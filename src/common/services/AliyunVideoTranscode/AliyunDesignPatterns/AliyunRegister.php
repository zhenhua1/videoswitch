<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:44
 */

namespace common\services\AliyunVideoTranscode\AliyunDesignPatterns;


class AliyunRegister
{
    private static $register = [];

    public static function Set($alias, $object)
    {
        self::$register[$alias] = $object;
    }

    public static function Get($alias)
    {
        return isset(self::$register[$alias]) ? self::$register[$alias] : null;
    }

    /**
     * @param $alias
     * @return mixed|null
     * @throws \Exception
     */
    public static function Make($alias)
    {
        if (is_null(self::Get($alias))) {
            if (!class_exists($alias)) throw new \Exception('未找到类别名：' . $alias, 999805);
            self::Set($alias, new $alias());
        }
        return self::Get($alias);
    }

    public static function Unset($alias)
    {
        unset(self::$register[$alias]);
    }
}