<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/22
 * Time: 11:41
 */
namespace common\services\AliyunVideoTranscode\fileOss\Logics;
use common\services\AliyunVideoTranscode\Ali;
use common\services\AliyunVideoTranscode\AliyunCommonLogic;

/**
 * 管理文件
 * Class ListObejct
 */
class ListObjects extends AliyunCommonLogic
{
    public function listObject()//列举指定条件的文件
    {
        $bucket=$this->config['Bucket'];//存储空间
        $prefix = $this->config['prefix'];//'outputLocal/';//本次查询结果的前缀。
        $delimiter = '/';//对文件名称进行分组的一个字符。CommonPrefixes是以delimiter结尾，并有共同前缀的文件集合
        $nextMarker = '';
        $maxkeys = 10;//列举文件的最大个数。默认为100，最大值为1000。
        $options = array(
            'delimiter' => $delimiter,
            'prefix' => $prefix,
            'max-keys' => $maxkeys,
            'marker' => $nextMarker,
        );
        try {
            $listObjectInfo = Ali::$aliClient->listObjects($bucket, $options);
        } catch (\OSS\Core\OssException $e) {
            printf($e->getMessage() . PHP_EOL);
            return;
        }
        $objectList = $listObjectInfo->getObjectList(); // object list
        $prefixList = $listObjectInfo->getPrefixList(); // directory list
        if (!empty($objectList)) {
            foreach ($objectList as $objectInfo) {
                print($objectInfo->getKey() . PHP_EOL);
            }
        }
        if (!empty($prefixList)) {
            foreach ($prefixList as $prefixInfo) {
                print($prefixInfo->getPrefix() . PHP_EOL);
            }
        }
    }

    public function doesObjectExists()//判断文件是否存在
    {
        $args=func_get_args();
        return Ali::$aliClient->doesObjectExist($this->config['Bucket'], $args[0]);//参数1：文件存储空间名 2：文件路径
    }

    public function getObjectAcl()//获取文件访问权限
    {
        $args=func_get_args();
        return Ali::$aliClient->getObjectAcl($this->config['Bucket'], $args[0]);//参数1：文件存储空间名 2：文件路径
    }

    public function putObjectAcl()//设置文件访问权限
    {
        $args=func_get_args();
        return Ali::$aliClient->putObjectAcl($this->config['Bucket'], $args[0],$this->config['ObjectAcl']);//参数1：文件存储空间名 2：文件路径 3:设置文件的访问权限
    }

    public function deleteObject()//删除存储空间中指定一个或多个文件
    {
        $args=func_get_args();
        if(func_num_args()>1){//删除多个文件
            return Ali::$aliClient->deleteObjects($this->config['Bucket'], func_get_args());
        }
        return Ali::$aliClient->deleteObject($this->config['Bucket'], $args[0]);
    }

    public function listBuckets()//列举存储空间
    {
        $bucketListInfo =Ali::$aliClient->listBuckets();
        $bucketList = $bucketListInfo->getBucketList();
        if(count($bucketList)<=0) return [];
        foreach($bucketList as $bucket) {
            $bucketData[]=[
                'location'=>$bucket->getLocation(),
                'name'=>$bucket->getName(),
                'createDate'=>$bucket->getCreatedate(),
            ];
        }
        return $bucketData;
    }
}