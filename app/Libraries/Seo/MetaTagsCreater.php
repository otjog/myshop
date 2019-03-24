<?php

namespace App\Libraries\Seo;

class MetaTagsCreater {

    private $data;

    private $search = [];

    private $replace = [];

    public function getTagsForPage($data){

        $this->data = $data;

        $resourceName = $this->getResourceName();

        $resourceData = $this->getResourceData($resourceName);

        $configData = $this->getConfigData($resourceName);

        $this->getReplaceData($configData, $resourceData);

        return $this->getMetaTags($configData['tags']);
    }

    private function getResourceName(){
        if(isset($this->data['template']['resource']) && $this->data['template']['resource'] !== null){
            return $this->data['template']['resource'];
        }else{
            return 'default';
        }
    }

    private function getResourceData($resourceName){
        if(isset($this->data['data'][$resourceName][0])){
            return $this->data['data'][$resourceName][0];
        }elseif(isset($this->data['data'][$resourceName])){
            return $this->data['data'][$resourceName];
        }
        return [];
    }

    private function getConfigData($resourceName){

        $defaultConfigData = config('metatags.default');

        $resourceConfigData = config('metatags.' . $resourceName);

        if($defaultConfigData === null){
          $defaultConfigData = [];
        }

        if($resourceConfigData === null){
            $resourceConfigData = [];
        }

        $configData['relations']    = array_merge($defaultConfigData['relations'], $resourceConfigData['relations']);
        $configData['values']       = array_merge($defaultConfigData['values'], $resourceConfigData['values']);
        $configData['tags']         = array_merge($defaultConfigData['tags'], $resourceConfigData['tags']);

        return $configData;
    }

    private function getReplaceData($configData, $resourceData){

        $configRelations = $configData['relations'];

        foreach ($configRelations as $pattern => $relation) {
            $this->search[] = '{{' . $pattern . '}}';

            if(isset($resourceData[$relation]) && $resourceData[$relation] !== null){
                $this->replace[] = $resourceData[$relation];
            }else{
                $this->replace[] = '';
            }
        }

        $configValues = $configData['values'];

        foreach ($configValues as $pattern => $value) {
            $this->search[] = '{{' . $pattern . '}}';

            $this->replace[] = $value;
        }

    }

    private function getMetaTags($configTags){
        $resultTags = [];

        foreach ($configTags as $nameTag => $strTag) {
            $resultTags[$nameTag] = str_replace($this->search, $this->replace, $configTags[$nameTag]);
        }

        return $resultTags;
    }

}
