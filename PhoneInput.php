<?php

namespace panix\ext\telinput;

use panix\engine\CMS;
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


        $hash = CMS::hash($id);
        if (isset($this->jsOptions['initialCountry']) && $this->jsOptions['initialCountry'] == 'auto') {
            $this->jsOptions['geoIpLookup'] = new JsExpression("function(callback) {
                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : '';
                    callback(countryCode);
                });
            }");
        }
        $jsOptions = Json::encode($this->jsOptions);

        $this->view->registerJs("var intlTelInput{$hash} = $('#$id').intlTelInput($jsOptions);", View::POS_END);


        $this->view->registerJs("
            var input = $('#$id');
            input.parents('form').on('submit', function() {
                var intlNumber = input.intlTelInput('getNumber');
                var intlNumberType = input.intlTelInput('getCountryData');
                console.log(intlNumber,intlNumberType);
                input.next().val(intlNumber);
            });
            
            input.on('change', function() {
                var intlNumber = input.intlTelInput('getNumber');
                var intlNumberType = input.intlTelInput('getCountryData');
                console.log(intlNumber,intlNumberType);
                input.next().val(intlNumber);
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
