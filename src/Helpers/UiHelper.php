<?php

namespace App\Helpers;
use Illuminate\Http\Request;
use App\Helpers\JsComponents\AjaxRequest;
use App\Helpers\JsComponents\OnClick;

class UiHelper {

    public function __construct(Request $request){
    }

    public function makeAjaxFormRequest($ajaxUrl,$method,$formId){
        $ajaxRequest = new AjaxRequest;

        $ajaxRequest->requestUrl = $ajaxUrl;
        $ajaxRequest->requestMethod = $method;
        $ajaxRequest->formId = $formId;

        return $ajaxRequest;
    }

    public function makeAjaxDataRequest($ajaxUrl,$method,$data){
        $ajaxRequest = new AjaxRequest;

        $ajaxRequest->requestUrl = $ajaxUrl;
        $ajaxRequest->requestMethod = $method;
        $ajaxRequest->formData = $data;

        return $ajaxRequest;
    }
    
    public function makeAjaxRequest($ajaxUrl,$method){
        $ajaxRequest = new AjaxRequest;

        $ajaxRequest->requestUrl = $ajaxUrl;
        $ajaxRequest->requestMethod = $method;

        return $ajaxRequest;
    }

    public function makeOnClickEvent($element){
        $onClick = new OnClick;

        $onClick->element = $element;

        return $onClick;
    }
}
