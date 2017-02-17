<?php

namespace App\Helpers\JsComponents;

use JsValidator;

class AjaxRequest extends JsComponent{

    public $requestUrl = '/';
    public $requestMethod = 'post';

    public $formId = null;
    public $formData = null;

    protected $onSuccessEvent = null;
    protected $onErrorEvent = null;
    protected $alwaysEvent = null;

    protected $validatorRequestClass = null;

    protected $loadingButton = null;

    public function build(){
        if($this->scriptTag){
            $this->addToScript('<script>');
        }

        if($this->checkHasValidator()){
            $this->addToScript('jQuery(document).ready(function() {');
            $this->addToScript(JsValidator::formRequest($this->validatorRequestClass, $this->formId)->render());
        }
        if($this->loadingButton){
            $this->addToScript('$("'.$this->loadingButton.'").on("click",function(e){');
        }
        $this->buildOptions();

        if($this->onSuccessEvent){
            $this->addToScript(
                $this->replaceQuotes($this->onSuccessEvent)
            );
        }

        if($this->onErrorEvent){
            $this->addToScript(
                $this->replaceQuotes($this->onErrorEvent)
            );
        }

        $this->addToScript('});');



        if($this->checkHasValidator()){
            $this->addToScript('}');
        }

        if($this->checkHasValidator()){
            $this->addToScript('});');
        }
        if($this->loadingButton){
                $this->addToScript('});');
        }
        if($this->scriptTag){
            $this->addToScript('</script>');
        }

        return $this->jsScript;
    }

    protected function buildOptions(){
        if($this->formId){
            $this->addToScript('
                var ajaxData = $("'.$this->formId.'").serialize();');
        }elseif($this->formData){
            $this->addToScript('
                var ajaxData = "'.$this->formData.'"');
        }

        if($this->checkHasValidator()){
            $this->addToScript('
                if(formValidator.checkForm()){');
        }
        if($this->loadingButton){
            $this->addToScript('
                var loginButton = Ladda.create(document.querySelector("'.$this->loadingButton.'"));
                loginButton.start();
            ');
        }
        $this->addToScript('
                    $.ajax({
                        url: "'.$this->requestUrl.'",
                        type: "'.$this->requestMethod.'",
                        dataType: "json",');
                        if(($this->formData) or ($this->formId)){
                            $this->addToScript('data: ajaxData,');
                        }
    }

    public function onSuccess($event){
        if ($event){
            $this->onSuccessEvent = '    success : function(response){';
            if($this->loadingButton){
                $this->onSuccessEvent = $this->onSuccessEvent . '
                    loginButton.stop();
                ';
            }
            $this->onSuccessEvent = $this->onSuccessEvent . '
                        '. $event;
            $this->onSuccessEvent = $this->onSuccessEvent . '
                    },';

        }
        return $this;
    }

    public function onError($event){
        if ($event){
            $this->onErrorEvent = '    error: function(jqxhr,textStatus,errorThrown){';
            if($this->loadingButton){
                $this->onErrorEvent = $this->onErrorEvent . '
                    loginButton.stop();
                ';
            }
            if($this->checkHasValidator()){
                $this->onErrorEvent = $this->onErrorEvent . '
                    formValidator.addLaravelErrors(jqxhr);
                ';
            }
            $this->onErrorEvent = $this->onErrorEvent . '
                        '. $event;
            $this->onErrorEvent = $this->onErrorEvent . '
                    },';
        }
        return $this;
    }

    public function always($event){

    }

    public function setValidator($validatorRequestClass){
        $this->validatorRequestClass = $validatorRequestClass;
        return $this;
    }

    public function setSubmitButton($buttonId){
        if($buttonId){
            $this->loadingButton = $buttonId;
        }
        return $this;
    }

    protected function checkHasValidator(){
        if(($this->formId) and ($this->validatorRequestClass)){
            return true;
        }
        return false;
    }

}
