<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 11:27
 */

namespace common\services\AliyunVideoTranscode\videoTranscode\Logics;


use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliyunCommonLogic;
use common\services\AliyunVideoTranscode\AliyunError;
use Mts\Request\V20140618\QueryJobListRequest;
use function common\services\AliyunVideoTranscode\AliyunTools\AliResponse;
/**
 * 通过jobIds查看转码情况
 * Class searchVideoSwitch
 * @package common\services\AliyunVideoTranscode\videoTranscode\Logics
 */
class SearchVideoSwitch extends AliyunCommonLogic
{
    public function queryJobList($jobIds)
    {
        $jobIds=func_get_args();
        $request = new QueryJobListRequest();
        $request->setAcceptFormat('JSON');
        $request->setJobIds($jobIds[0]);
        $response = Ali::$aliClient->getAcsResponse($request);
        $responseArr=json_decode(json_encode($response),true);
        $jobList=$responseArr['JobList']['Job'];
        $jobCount=count($jobList);
        $success=$fail=0;
        $failInfoList=[];
        foreach($jobList as $val){
            if($val['State']=='TranscodeSuccess'){//转码成功
                $success++;
            }
            if($val['State']=='TranscodeFail'){//转码失败
                $fail++;
                $failInfoList[]=[
                    'JobId'=>$val['JobId'],
                    'Code'=>$val['Code'],
                    'Message'=>$val['Message'],
                    'CreationTime'=>$val['CreationTime'],
                ];
            }
        }
        return $this->responseResult($jobCount,$success,$fail,$failInfoList);
    }

    public function responseResult($total,$success,$fail,$failInfoList)
    {
        $data=[
            'total'=>$total,
            'successNum'=>$success,
            'failNum'=>$fail,
            'TranscodeNum'=>$total-$success-$fail,
            'failInfoList'=>$failInfoList
        ];
        $result_code=200;
        switch($total){
            case $fail:
                $error_code=AliyunError::TRANSCODE_SUCCESS[0];
                $message=AliyunError::TRANSCODE_SUCCESS[1];
                break;
            case $success:
                $error_code=0;
                $message='转码成功';
                break;
            case ($success+$fail):
                $error_code=AliyunError::TRANSCODE_PART_FAIL[0];
                $message=AliyunError::TRANSCODE_PART_FAIL[1];
                break;
            default:
                $error_code=AliyunError::TRANSCODE_PART_DEALED[0];
                $message=AliyunError::TRANSCODE_PART_DEALED[1];
        }
        return AliResponse($result_code,$error_code,$message,$data);
    }
}