<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 10:17
 */
return [
    'accessKeyId' => 'xxx',//,//阿里云主账号AccessKeyId
    'accessKeySecret' => 'xxx',//,//阿里云主账号Access Key Secret
    'mpsRegionId'=>'cn-beijing',//自己的mps Region ID
    'endpoint' => 'oss-cn-beijing.aliyuncs.com',//地域节点
    'location' => 'oss-cn-beijing',//OSS 数据中心
    'host'=>'http://test.oss-cn-beijing.aliyuncs.com',//访问oss文件存储的url

    'vedio_bucket' => 'trialclub',//音/视频输入存储空间名
    'vedio_output_bucket' => 'trialclub',//音/视频输出存储空间
    #TODO 视频转码区
    'vedio_HD_output_storage_path'=>'mps2020/',//视频转码高清输出存放路径
    'vedio_Flv_output_storage_path' => 'mps2020/',//视频转码标清输出存放路径
    'vedio_Fluent_output_storage_path' => 'mps2020/',//视频转码流畅输出存放路径
    'videoOutPutFormat' => 'mp4',//视频转码输出格式
    #TODO 音频转码区
    'mp3_templateId' => '9337dxxxxxxxbe666a991a14fcbc',//自定义音频转码模板ID。
    'audio_output_storage_path' => 'mps2020/',//音频转码输出存放路径
    'audioOutPutFormat' => 'mp3',//音频转码输出格式

    'switchState'=>[//音/视频转码结果状态
        0=>'All',//所有状态
        1=>'Submitted',//转码已提交
        2=>'Transcoding',//转码中
        3=>'TranscodeSuccess',//转码成功
        4=>'TranscodeFail',//转码失败
        5=>'TranscodeCancelled',//转码取消
    ],
    'defaultSwitchState'=>0,//默认获取转码结果状态
    'defaultPutSwitchPageNum'=>10,//默认获取拉取转码每页显示条数.最大每页不能超过100条

    'pipelineId' => 'ee2045xxxxxxx5fae70064a',//转码管道ID

    'pic_bucket' => 'pic-bucket',//图片存储空间
    'oss_object_prefix'=>'outputLocal/',//oss资源文件存储前缀，在读取oss文件资源时需要,如果没有默认为空
    'policy'=>30,//设置该policy超时时间是10. 即这个policy过了这个有效时间，将不能访问（主要用于web直传情况）

    //文件权限类型
    'ObjectAcl'=>[
        0=>'default',//继承Bucket
        1=>'private',//私有
        2=>'public-read',//公共读
        3=>'public-read-write'//公共读写
    ],
    'defaultObjectAcl'=>0,//默认文件权限类型
    //系统MP4多码率工作流视频转码模板ID和自定义模板ID
    'systemTemplateId'=>[
        'Custom'=>'9337d4d8fxxxx10be666a991a14fcbc',//自定义视频转码模板ID
        'Fluent'=>'S00000001-200010',//MP4-流畅
        'Flv'=>'S00000001-200020',//MP4-标清
        'HD'=>'S00000001-200030'//MP4-高清
    ],
    'defaultSystemTemplateId'=>'Fluent',
];
