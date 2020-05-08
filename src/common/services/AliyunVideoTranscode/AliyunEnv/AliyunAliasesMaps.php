<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 9:48
 */
return [
    'acsClients' => [//音/视频转码
        'className' => 'common\services\AliyunVideoTranscode\videoTranscode\AcsClients',//音/视频转码client
        'methodName' => [//键名是方法名=>值是类名
            'submitJobsRequest'=>'VideoSwitch',//提交转码Job请求
            'queryJobList'=>'SearchVideoSwitch',//通过转码JobID，批量查询转码Job
            'listJob'=>'SwitchJobList',//列出转码Job
            'searchPipeline'=>'PublicLogic',//搜索mps管道
        ],
    ],
    'ossClients' => [//oss资源存储
        'className' => 'common\services\AliyunVideoTranscode\fileOss\OssClients',//oss client
        'methodName' => [//键名是方法名=>值是类名
            'listObject'=>'ListObjects',//列举指定条件的文件
            'doesObjectExists'=>'ListObject',//判断文件是否存在
            'getObjectAcl'=>'ListObject',//获取文件访问权限
            'putObjectAcl'=>'ListObject',//设置文件访问权限
            'listBuckets'=>'ListObject',//列举存储空间
            'deleteObject'=>'ListObject',//删除存储空间中的指定一个或多个文件
            'authorizeBower'=>'OssBowerOperate',//授权浏览器上传文件到oss
        ],
    ],
];