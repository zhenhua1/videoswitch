<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 14:54
 */

namespace common\services\AliyunVideoTranscode;


class AliyunError
{
    //公共错误码
    const CLASS_NO_FOUND=[90001,'未找到该client'];
    const INTERFACE_ACTION_NO_EXITS=[90002,'client不存在该方法'];
    const NO_FOUND_CLASS_ALIAS=[999804,'未找到类别名：'];
    const TRANSCODE_SUCCESS=[90003,'转码失败'];
    const SUBMIT_TRANSCODE_FAIL=[90004,'提交转码失败'];
    const TRANSCODE_PART_FAIL=[90005,'转码部分失败'];
    const TRANSCODE_PART_DEALED=[90006,'转码部分处理中'];
    const CUSTOM_TEMPLATEID=[90007,'自定义模板ID为空'];
    const SWTICH_LIST_EMPTY=[90008,'获取转码列表为空'];
    const INSTANCE_RUN_CLASS_FAIL=[90009,'实例化运行类失败'];
    const METHOD_NO_RELATIVE_CLASS=[90010,'该方法没有对应的类'];
    const VISIT_METHOD_NO_FOUND=[90011,'访问方法未找到'];
    const ALI_YUN_SYSTEM_ERROR=[92000];
}