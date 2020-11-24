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

        if(!isset($this->options['autocomplete']))
            $this->options['autocomplete'] = 'ac-'.CMS::gen(5);

        // if ($this->utils) {
        $this->jsOptions['utilsScript'] = $assets->baseUrl . '/js/utils.js?' . time();
        // }

        if(!isset($this->jsOptions['autoPlaceholder']))
            $this->jsOptions['autoPlaceholder'] = 'aggressive'; //polite, aggressive

        if(!isset($this->jsOptions['onlyCountries']))
            $this->jsOptions['onlyCountries'] = ['by', 'ru', 'ua'];

        //if(!isset($this->jsOptions['preferredCountries']))
        //    $this->jsOptions['preferredCountries'] = ['ua', 'ru', 'by'];


        if(!isset($this->jsOptions['nationalMode']))
            $this->jsOptions['nationalMode'] = true;

        if(!isset($this->jsOptions['initialCountry']))
            $this->jsOptions['initialCountry'] = 'ua';

        //  $this->jsOptions['autoHideDialCode'] = false;
         $this->jsOptions['separateDialCode'] = true;

        if(!isset($this->jsOptions['hiddenInput']))
            $this->jsOptions['hiddenInput'] = ($this->hasModel()) ? $this->attribute : $this->name;


        /*if (isset($this->jsOptions['initialCountry']) && $this->jsOptions['initialCountry'] == 'auto') {
            $this->jsOptions['geoIpLookup'] = new JsExpression("function(success, failure) {
                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : '';
                    success(countryCode);
                });
            }");
        }*/


        //$this->jsOptions['customPlaceholder'] = new JsExpression("function(selectedCountryPlaceholder, selectedCountryData) {
     // console.log(selectedCountryData);
     //   return \"e.g. \" + selectedCountryPlaceholder;
    //}");



        $jsOptions = Json::encode($this->jsOptions);
        $hash = md5($this->getId());

        \yii\widgets\MaskedInputAsset::register($this->view);

        $this->view->registerJs("

            var iti{$hash} = $('#$id').intlTelInput($jsOptions);

            function addMask(input){
                if(input.attr('placeholder') == undefined){
                    var placeholder = '99 999 9999';
                }else{
                    var placeholder = input.attr('placeholder');
                }
                placeholder = placeholder.replace(/(\s)/gm,'-');
                placeholder = placeholder.replace(/(\d)/gm,'9');
                var mask = '['+placeholder+']';
                  
                var masked = input.inputmask({
                    mask:mask,
                });

            }
            
            addMask($('#$id'));

            $('#$id').closest('form').on('beforeValidateAttribute', function() {
                $('#$id').next().val(iti{$hash}.intlTelInput('getNumber'));
            });
            
            $('#$id').closest('form').on('submit', function() {
                $('#$id').next().val(iti{$hash}.intlTelInput('getNumber'));
            });
            
            $('#$id').on('change', function() {
                $('#$id').next().val(iti{$hash}.intlTelInput('getNumber'));
            });
            
            $('#$id').on('countrychange', function() {
                addMask($(this));
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
