<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 10:56
 */

namespace common\services\AliyunVideoTranscode\videoTranscode\Logics;

use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliyunCommonLogic;
use common\services\AliyunVideoTranscode\AliyunError;
use Mts\Request\V20140618\SubmitJobsRequest;
use function common\services\AliyunVideoTranscode\AliyunTools\AliResponse;
/**
 * 提交转码作业
 * Class videoSwitch
 * @package common\services\AliyunVideoTranscode\videoTranscode\Logics
 */
class VideoSwitch extends AliyunCommonLogic
{
    public function submitJobsRequest()//参数2：输入的文件资源
    {
        $inputFilePath=func_get_args();
        $request = new SubmitJobsRequest();
        $request = $this->videoInput($request, $inputFilePath[0]);
        $request=$this->videoOutput($request, $inputFilePath[0]);
        $data=[];
        $result_code=200;
        try {
            $response = Ali::$aliClient->getAcsResponse($request);
            $responseArr=json_decode(json_encode($response),true);
            $data['RequestId']=$responseArr['RequestId'];
            if($responseArr['JobResultList']['JobResult'][0]['Success']){
                $error_code=0;
                $message='提交转码成功';
                $data['JobId']=$responseArr['JobResultList']['JobResult'][0]['Job']['JobId'];
            }else{
                $error_code=AliyunError::SUBMIT_TRANSCODE_FAIL[0];
                $message=AliyunError::SUBMIT_TRANSCODE_FAIL[1];
                $data['code']=$responseArr['JobResultList']['JobResult'][0]['Code'];
                $data['message']=$responseArr['JobResultList']['JobResult'][0]['Message'];
            }
        } catch (\ServerException $e) {
            $error_code=AliyunError::ALI_YUN_SYSTEM_ERROR[0];
            $message='Error: ' . $e->getErrorCode() . ' Message: ' . $e->getMessage();
        }
        return AliResponse($result_code,$error_code,$message,$data);
    }

    public function videoInput($request, $putFilePath)//视频转码输入参数配置
    {
        $request->setAcceptFormat('JSON');
        $input = [
            'Location' => Ali::$sysConfig['location'],//OSS 数据中心
            'Bucket' => Ali::$sysConfig['vedio_bucket'],
            'Object' => urlencode($putFilePath),
        ];
        $request->setInput(json_encode($input));
        return $request;
    }

    public function videoOutput($request, $putFilePath)//视频转码输出参数配置
    {
        $outputObject=$this->config['outputStoragePath'] . pathinfo($putFilePath)['filename'].'.'.$this->config['OutPutFormat'];
        $output = ['OutputObject' => urlencode($outputObject)];
        $output['Container'] = array('Format' => $this->config['OutPutFormat']);
        if(strtotime($this->config['OutPutFormat'])!=Ali::$sysConfig['audioOutPutFormat']){//如果不是MP3转码需用视频配置
            $output['Video']=$this->getVideoConfigure();
        }
        $output['Audio']=$this->getAudioConfigure();
        $output['TemplateId'] = $this->config['templateId'];
        $outputs = array($output);
        $request->setOUtputs(json_encode($outputs));
        $request->setOutputBucket(Ali::$sysConfig['vedio_output_bucket']);
        $request->setOutputLocation(Ali::$sysConfig['location']);
        $request->setPipelineId($this->config['pipelineId']);
        return $request;
    }

    public function getVideoConfigure()//获取视频配置
    {
         return [//视频参数
            'Codec' => 'H.264',
            'Bitrate' => 1500,
            'Width' => 1280,
            'Fps' => 25
        ];
    }

    public function getAudioConfigure()//获取音频配置
    {
         return [//音频参数
            'Codec' => 'AAC',
            'Bitrate' => 128,
            'Channels' => 2,
            'Samplerate' => 44100
        ];
    }
}