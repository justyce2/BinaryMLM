<?php
namespace common\components;

class Request extends \yii\web\Request {
    public $route_web;
    public $adminUrl;

    public function getBaseUrl(){
        return str_replace($this->route_web, "", parent::getBaseUrl()) . $this->adminUrl;
    }
    
    public function resolvePathInfo(){
        if($this->getUrl() === $this->adminUrl){
            return "";
        }else{
            return parent::resolvePathInfo();
        }
    }
} ?>