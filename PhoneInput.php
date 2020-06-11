<?php

namespace panix\ext\telinput;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;
use panix\engine\Html;

class PhoneInput extends InputWidget
{


    public $defaultOptions = ['autocomplete' => "off", 'class' => 'form-control'];

    /**
     * @link https://github.com/jackocnr/intl-tel-input#options More information about JS-widget options.
     * @var array Options of the JS-widget
     */
    public $jsOptions = [];

    public function init()
    {
        parent::init();
        $assets = Asset::register($this->view);
        $id = ArrayHelper::getValue($this->options, 'id');


        // if ($this->utils) {
        $this->jsOptions['utilsScript'] = $assets->baseUrl . '/js/utils.js?' . time();
        // }
        $this->jsOptions['autoPlaceholder'] = 'aggressive'; //polite, aggressive
        $this->jsOptions['onlyCountries'] = ['ua', 'ru', 'by'];
        $this->jsOptions['nationalMode'] = true;
        $this->jsOptions['initialCountry'] = 'auto';
        //$this->jsOptions['autoHideDialCode'] = false;
        if(!isset($this->jsOptions['hiddenInput']))
            $this->jsOptions['hiddenInput'] = ($this->hasModel()) ? $this->attribute : $this->name;


        if (isset($this->jsOptions['initialCountry']) && $this->jsOptions['initialCountry'] == 'auto') {
            $this->jsOptions['geoIpLookup'] = new JsExpression("function(success, failure) {
                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : '';
                    success(countryCode);
                });
            }");
        }
        $jsOptions = Json::encode($this->jsOptions);
        $hash = md5($this->getId());
        $this->view->registerJs("var iti{$hash} = $('#$id').intlTelInput($jsOptions);", View::POS_END);


        $this->view->registerJs("
            var input{$hash} = $('#$id');
            input{$hash}.parents('form').on('submit', function() {
                //var intlNumberType{$hash} = input{$hash}.intlTelInput('getCountryData');
                input{$hash}.next().val(iti{$hash}.intlTelInput('getNumber'));
            });
            
            input{$hash}.on('change', function() {
               // var intlNumberType{$hash} = input{$hash}.intlTelInput('getCountryData');
                input{$hash}.next().val(iti{$hash}.intlTelInput('getNumber'));
            });
        ", View::POS_END);
    }

    /**
     * @return string
     */
    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        if ($this->hasModel()) {
            return Html::activeInput('tel', $this->model, $this->attribute, $options);
        }
        return Html::input('tel', $this->name, $this->value, $options);
    }

}
