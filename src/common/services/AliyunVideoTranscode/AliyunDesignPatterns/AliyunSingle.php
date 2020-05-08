<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:38
 */

namespace common\services\AliyunVideoTranscode\AliyunDesignPatterns;


use common\services\AliyunVideoTranscode\AliyunEnv\AliyunServiceIndex;

class AliyunSingle
{
    private static $instance = null;

    private function __construct(){}

    static public function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AliyunServiceIndex(__DIR__ . '/../AliyunEnv');
        }

        return self::$instance;
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}