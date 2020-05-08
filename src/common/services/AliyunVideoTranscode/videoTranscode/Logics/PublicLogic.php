<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/23
 * Time: 22:20
 */

namespace common\services\AliyunVideoTranscode\videoTranscode\Logics;


use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliyunCommonLogic;
use Mts\Request\V20140618\SearchPipelineRequest;

class PublicLogic extends AliyunCommonLogic
{
    public function searchPipeline()//搜索mps管道
    {
        $request=new SearchPipelineRequest();
        $response = Ali::$aliClient->getAcsResponse($request);
        $pipelines = $response->PipelineList->Pipeline;
        $pipeLineData=[];
        foreach ($pipelines as $pipeline) {
            $pipeLineData[]=[
                'pipelineId'=>$pipeline->Id,
                'pipelineName'=>$pipeline->Name,
                'pipelineState'=>$pipeline->State,
            ];
        }
        return $pipeLineData;
    }
}