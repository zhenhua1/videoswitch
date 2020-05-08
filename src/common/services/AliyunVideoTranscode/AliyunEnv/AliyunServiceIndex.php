<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:39
 */

namespace common\services\AliyunVideoTranscode\AliyunEnv;


class AliyunServiceIndex implements \ArrayAccess
{
    private $path;
    protected $configs = array();

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function offsetExists($key)
    {
        return isset($this->configs[$key]);
    }

    public function offsetGet($key)
    {
        if (empty($this->configs[$key])) {
            $file_path = $this->path . '/' . $key . '.php';
            $config = require $file_path;
            $this->configs[$key] = $config;
        }
        return $this->configs[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws \Exception
     */
    public function offsetSet($key, $value)
    {
        throw new \Exception("cannot write config file.", 000001);
    }

    public function offsetUnset($key)
    {
        unset($this->configs[$key]);
    }
}