<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/23
 * Time: 10:24
 */

namespace common\services\AliyunVideoTranscode\videoTranscode\Logics;

use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliyunCommonLogic;
use common\services\AliyunVideoTranscode\AliyunError;
use Mts\Request\V20140618\ListJobRequest;

/**
 * 转码作业列表
 * Class switchJobList
 * @package common\services\AliyunVideoTranscode\videoTranscode\Logics
 */
class SwitchJobList extends AliyunCommonLogic
{
    public function listJob()
    {
        $request=new ListJobRequest();
        $request->setAcceptFormat('JSON');
        $request->setMaximumPageSize(Ali::$sysConfig['defaultPutSwitchPageNum']);
        $request->setState(Ali::$sysConfig['switchState'][Ali::$sysConfig['defaultSwitchState']]);
        $request->setPipelineId($this->config['pipelineId']);
        $switchJobList=[];
        $this->loopJobsLIstData($request,$switchJobList);
        return $switchJobList;
    }

    public function loopJobsLIstData($request,&$switchJobList)//获取任务列表数据
    {
        $response=Ali::$aliClient->getAcsResponse($request);
        $responseArr=json_decode(json_encode($response),true);
        if(count($responseArr['JobList']['Job'])<0) throw new \Exception(AliyunError::SWTICH_LIST_EMPTY[1],AliyunError::SWTICH_LIST_EMPTY[0]);
        foreach($responseArr['JobList']['Job'] as $val){
            array_push($switchJobList,$this->buildJobListData($val));
        }
        if(isset($responseArr['NextPageToken'])&&!empty($responseArr['NextPageToken'])){
            $request->setNextPageToken($responseArr['NextPageToken']);
            $this->loopJobsLIstData($request,$switchJobList);
        }
        return ;
    }

    public function buildJobListData($jobInfo)//构建返回jobList信息
    {
        return [
            'JobId'=>$jobInfo['JobId'],
            'InputObject'=>urldecode($jobInfo['Input']['Object']),
            'OutputObject'=>urldecode($jobInfo['Output']['OutputFile']['Object']),
            'TemplateId'=>$jobInfo['Output']['TemplateId'],
            'State'=>$jobInfo['State'],
            'Code'=>isset($jobInfo['Code'])?$jobInfo['Message']:'',
            'Message'=>isset($jobInfo['Message'])?$jobInfo['Message']:'',
            'CreationTime'=>$jobInfo['CreationTime'],
        ];
    }
}