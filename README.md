# videoswitch
阿里云视频转码封装

## 使用前须知

**本包只支持 laravel、yii2、thinkphp5 及更高版本**

## 使用前准备

需要去阿里云下载最新的视频转码包放到项目的vendor/aliyuncs *没有请创建* （若使用包中的oss相关功能原理同上）

需要将包中common\services\AliyunVideoTranscode\AliyunEnv 下的AliyunConfig.php复制到自己项目的config中并更名为AliZZHConfig.php

## 音(视)频示例

```
use common\services\AliyunVideoTranscode\AliyunClient;

$instance=AliyunClient::GetInstance();
$acsClient=$instance->acsClients();
$acsClient->client();
$file='d3ae5eaf2eaf002d2eef71a53247c68a.mp4';
var_dump($acsClient->mp4SwitchManage('submitJobsRequest',$file));//视频转码
var_dump($acsClient->mp3SwitchManage('submitJobsRequest',$file));//音频转码

```

## Oss使用示例

```
use common\services\AliyunVideoTranscode\AliyunClient;

$instance=AliyunClient::GetInstance();
$acsClient=$instance->ossClients();
$acsClient->client();
var_dump($acsClient->ossManage('listBuckets'));//列举存储空间

```

### 备注

有关更多的使用功能请看common\services\AliyunVideoTranscode\AliyunEnv\AliyunAliasesMaps.php中所列
