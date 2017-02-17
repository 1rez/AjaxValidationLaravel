<?php
namespace App\Helpers\JsComponents;


abstract class jsComponent {

    protected $scriptTag = true;
    protected $jsScript = null;

    protected function addToScript($code){
        if($code){
            $this->jsScript = $this->jsScript.$code;
        }
    }

    public function addScriptTag($scriptTag){
        $this->scriptTag = $scriptTag;
        return $this;
    }

    public function replaceQuotes($code){
        if($code){
            $arrFrom = array('@"','"@');
            $arrTo = array("'","'");

            return str_replace($arrFrom,$arrTo,$code);
        }
        return null;
    }
}
