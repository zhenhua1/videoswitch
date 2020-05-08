<?php
/**
 * Created by PhpStorm.
 * User: 华
 * Date: 2020/4/24
 * Time: 21:06
 */

namespace common\services\AliyunVideoTranscode;


trait AliRoute
{
    public function runInstance($objectName)//获取运行时实例
    {
        $rootDir=dirname(__FILE__);
        $classObject=null;
        $this->comparisonObject($rootDir,$objectName,$classObject);
        if(is_null($classObject)) return $classObject;
        $className=__NAMESPACE__.str_replace($rootDir,'',$classObject);
        return new \ReflectionClass($className);
    }

    public function comparisonObject($path,$object,&$classObject)
    {
        $dir = scandir($path);
        foreach ($dir as $value){
            if($value == '.' || $value == '..') continue;
            $subPath =$path .'\\'.$value;
            if(is_dir($subPath)){
                $this->comparisonObject($subPath,$object,$classObject);
            }else{
                $fileName=str_replace('.php','',$value);
                if(strcmp($fileName,$object)==0) return $classObject=$path.'\\'.$fileName;
            }
        }
    }
}