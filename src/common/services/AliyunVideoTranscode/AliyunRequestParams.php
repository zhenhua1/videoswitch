<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/23
 * Time: 13:32
 */

namespace common\services\AliyunVideoTranscode;

/**
 * 阿里云接口请求参数配置
 * Class AliyunRequestParams
 * @package common\services\AliyunVideoTranscode
 */
class AliyunRequestParams
{
    public $requestConfigure;

    public $alias;//实例client别名
    public function setMp4TemplateId($config)//视频转码模板id
    {
        $this->requestConfigure['templateId'] = $config['systemTemplateId'][$config['defaultSystemTemplateId']];
    }

    public function setMp3TemplateId($config)//音频转码模板id
    {
        $this->requestConfigure['templateId']=$config['mp3_templateId'];
    }

    public function setPipelineId($config)//转码管道ID
    {
        $this->requestConfigure['pipelineId']=$config['pipelineId'];
    }

    public function setSwitchOutputStoragePath($outputStoragePath)//设置转码输出存放路径
    {
        $this->requestConfigure['outputStoragePath']=$outputStoragePath;
    }

    public function setSwitchOutPutFormat($outPutFormat)//设置转码输出格式
    {
        $this->requestConfigure['OutPutFormat']=$outPutFormat;
    }

    public function setObjectAclType($config)//设置文件访问权限类型
    {
        $this->requestConfigure['ObjectAcl']=$config['ObjectAcl'][$config['defaultObjectAcl']];
    }

    public function setBucket($config)//设置oss资源存储空间
    {
        $this->requestConfigure['Bucket']=$config['pic_bucket'];
    }

    public function setResourcePrefix($config)//设置oss资源存储前缀
    {
        $this->requestConfigure['prefix']=$config['oss_object_prefix'];
    }

    protected function setPolicy($config)//设置policy超时时间
    {
        $this->requestConfigure['policy'] = $config['policy'];
    }

    protected function setHost($config)//设置访问oss文件存储的url
    {
        $this->requestConfigure['host']=$config['host'];
    }
}