<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 8:57
 */

namespace common\services\AliyunVideoTranscode;


interface ClientInterface
{
    public function client();

    public function logicMain($method,$args);
}