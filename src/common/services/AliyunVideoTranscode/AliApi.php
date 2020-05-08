<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/23
 * Time: 11:49
 */

namespace common\services\AliyunVideoTranscode;

use function common\services\AliyunVideoTranscode\AliyunTools\Aliyun;
/**
 * 对外API接口
 * Class AliApi
 * @package common\services\AliyunVideoTranscode
 */
class AliApi extends AliyunRequestParams
{
    use AliRoute;

    public function mp4SwitchManage($method,...$args)//MP4视频转码
    {
        $config=Ali::$sysConfig;
        if(func_num_args()>=2&&is_string(func_get_arg(1))){//需要检查是否有设置视频转码格式
            $templateKeys=array_keys($config['systemTemplateId']);
            $templateType=ucfirst(func_get_arg(1));
            if(in_array($templateType,$templateKeys)) $config['defaultSystemTemplateId']=$templateType;
        }
        $this->setMp4TemplateId($config);
        $this->setPipelineId($config);
        $outputStoragePath=$config['vedio_'.$config['defaultSystemTemplateId'].'_output_storage_path'];
        $this->setSwitchOutputStoragePath($outputStoragePath);
        $this->setSwitchOutPutFormat($config['videoOutPutFormat']);
        return $this->logicMain($method,$args);
    }

    public function mp3SwitchManage($method,...$args)//MP3音频转码
    {
        $config=Ali::$sysConfig;
        $this->setMp3TemplateId($config);
        $this->setPipelineId($config);
        $this->setSwitchOutputStoragePath($config['audio_output_storage_path']);
        $this->setSwitchOutPutFormat($config['audioOutPutFormat']);
        return $this->logicMain($method,$args);
    }

    public function ossManage($method,...$args)//oss资源操作
    {
        $config=Ali::$sysConfig;
        $this->setBucket($config);
        $this->setObjectAclType($config);
        $this->setResourcePrefix($config);
        $this->setPolicy($config);
        $this->setHost($config);
        return $this->logicMain($method,$args);
    }

    public function distributeLogic($clientName,$method)//路由分发处理
    {
        $methodMaps=Aliyun('AliyunAliasesMaps')[$clientName]['methodName'];
        $methodVal=array_keys($methodMaps);
        if(!in_array($method,$methodVal)) throw new \Exception(AliyunError::VISIT_METHOD_NO_FOUND[1],AliyunError::VISIT_METHOD_NO_FOUND[0]);
        $className=$methodMaps[$method];
        $reflectionClass=$this->runInstance($className);
        $object=$reflectionClass->newInstance();
        if(is_null($object)) throw new \Exception(AliyunError::INSTANCE_RUN_CLASS_FAIL[1],AliyunError::INSTANCE_RUN_CLASS_FAIL[0]);
        if (!method_exists($object,$method)) throw new \Exception(AliyunError::INTERFACE_ACTION_NO_EXITS[1], AliyunError::INTERFACE_ACTION_NO_EXITS[0]);
        $property=$reflectionClass->getProperty('config');
        Ali::$aliConfig=array_merge(Ali::$aliCommonConfig,$this->requestConfigure);
        $property->setValue($object,Ali::$aliConfig);
        return $object;
    }

    public function getVideoSwitchTemplate()//获取视频转码模板
    {
        if(Ali::$sysConfig['systemTemplateId']=='Custom') return null;//说明启用了自定义视频转码模板（调用该方法的后续逻辑自行处理）
        return Ali::$sysConfig['systemTemplateId'];
    }

    public function getAudioSwitchTemplate()//获取音频转码模板
    {
        return Ali::$sysConfig['mp3_templateId'];
    }
}