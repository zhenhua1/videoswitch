<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/5/8
 * Time: 20:55
 */
require_once './vendor/autoload.php';
use common\services\AliyunVideoTranscode\AliyunClient;
$instance=AliyunClient::GetInstance();
$acsClient=$instance->acsClients();
$acsClient->client();
$file='d3ae5eaf2eaf002d2eef71a53247c68a.mp4';
var_dump($acsClient->mp4SwitchManage('listJob'));