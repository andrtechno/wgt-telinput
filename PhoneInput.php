<?php

namespace panix\ext\telinput;

use panix\engine\CMS;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use panix\engine\Html;

class PhoneInput extends InputWidget
{


    public $htmlTagType = 'tel';

    public $defaultOptions = ['autocomplete' => "off", 'class' => 'form-control'];

    /**
     * @link https://github.com/jackocnr/intl-tel-input#options More information about JS-widget options.
     * @var array Options of the JS-widget
     */
    public $jsOptions = [
        'autoPlaceholder' => 'aggressive',
        'onlyCountries' => ['ua', 'ru', 'by'],
        'nationalMode' => true,
        //'separateDialCode'=>true,
    ];

    public function init()
    {
        parent::init();
        $assets = Asset::register($this->view);
        $id = ArrayHelper::getValue($this->options, 'id');

        // if ($this->utils) {
        $this->jsOptions['utilsScript'] = $assets->baseUrl . '/js/utils.js?' . time();
        // }
        //$this->jsOptions['autoHideDialCode'] = false;
        $this->jsOptions['initialCountry'] = 'auto';
        //$this->jsOptions['hiddenInput'] = 'full_phone';

        $hash = CMS::hash($id);
        if (isset($this->jsOptions['initialCountry']) && $this->jsOptions['initialCountry'] == 'auto') {
            $this->jsOptions['geoIpLookup'] = new JsExpression("function(callback) {
                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : '';
                    callback(countryCode);
                });
            }");
        }

        $jsOptions = $this->jsOptions ? Json::encode($this->jsOptions) : "";

        $this->view->registerJs("var intlTelInput{$hash} = $('#$id').intlTelInput($jsOptions);");


        //if ($this->hasModel()) {
        $this->view->registerJs("
                $('#$id').parents('form').on('submit', function() {
                    var intlNumber = $('#$id').intlTelInput('getNumber');
                    var intlNumberType = $('#$id').intlTelInput('getCountryData');
                    $('#$id').val($('#$id').intlTelInput('getNumber'));
                    //console.log(intlNumber,intlNumberType);
                });
            ");
        // }
    }

    /**
     * @return string
     */
    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        if ($this->hasModel()) {
            return Html::activeInput($this->htmlTagType, $this->model, $this->attribute, $options);
        }
        return Html::input($this->htmlTagType, $this->name, $this->value, $options);
    }

}
