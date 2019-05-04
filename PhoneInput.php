<?php

namespace panix\ext\telinput;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use panix\engine\Html;

class PhoneInput extends InputWidget
{

    /** @var string HTML tag type of the widget input ("tel" by default) */
    public $htmlTagType = 'tel';
    /** @var array Default widget options of the HTML tag */
    public $defaultOptions = ['autocomplete' => "off", 'class' => 'form-control'];
    /**
     * @link https://github.com/jackocnr/intl-tel-input#options More information about JS-widget options.
     * @var array Options of the JS-widget
     */
    public $jsOptions = [
        'autoPlaceholder' => 'aggressive',
        'onlyCountries' => ['ua', 'ru', 'by'],
    ];

    public function init()
    {
        parent::init();
        $assets = Asset::register($this->view);
        $id = ArrayHelper::getValue($this->options, 'id');

        // if ($this->utils) {
        $this->jsOptions['utilsScript'] = $assets->baseUrl . '/js/utils.js';
        // }
        $this->jsOptions['autoHideDialCode']=false;
        $this->jsOptions['initialCountry']='auto';


        $this->jsOptions['geoIpLookup']= new JsExpression('function(success, failure) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                success(countryCode);
            });
        }');

        $jsOptions = $this->jsOptions ? Json::encode($this->jsOptions) : "";

        $this->view->registerJs("$('#$id').intlTelInput($jsOptions)");
        if ($this->hasModel()) {
            $this->view->registerJs("
                $('#$id').parents('form').on('submit', function() {
                    $('#$id').val($('#$id').intlTelInput('getNumber'));
                });
            ");
        }
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
