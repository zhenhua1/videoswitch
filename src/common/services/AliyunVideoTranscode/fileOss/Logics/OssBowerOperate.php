<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/24
 * Time: 14:29
 */

namespace common\services\AliyunVideoTranscode\fileOss\Logics;

use common\services\AliyunVideoTranscode\AliyunCommonLogic;
use DateTime;
/**
 * 浏览器相关操作
 * Class ossBowerOperate
 * @package common\services\AliyunVideoTranscode\fileOss\Logics
 */
class OssBowerOperate extends AliyunCommonLogic
{
    public function authorizeBower()//授权浏览器上传文件到oss
    {
        $end = time() + $this->config['policy'];
        $expiration = $this->gmt_iso8601($end);
        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$this->config['prefix']);
        $conditions[] = $start;
        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->config['accessKeySecret'], true));
        $response = array();
        $response['accessid'] = $this->config['accessKeyId'];
        $response['host'] = $this->config['host'];
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $this->config['prefix'];
        return $response;
    }

    public function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}