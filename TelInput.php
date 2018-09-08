<?php

/**
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 * @see https://github.com/jackocnr/intl-tel-input#options
 */

namespace panix\ext\telinput;

use Yii;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use panix\engine\Html;

class TelInput extends InputWidget
{

    public $placeholder;
    public $utils = true;
    public $jsOptions = [
        'preferredCountries' => ['ua', 'ru'],

    ];

    public function run()
    {
        $this->options['type'] = 'tel';
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        $assets = Asset::register($view);

        if ($this->utils) {
            $this->jsOptions['utilsScript'] = $assets->baseUrl . '/js/utils.js';
        }

        //$this->jsOptions['initialCountry']= "auto";

        /*$this->jsOptions['geoIpLookup']= new \yii\web\JsExpression("function(callback) {
            $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : '';
                callback(countryCode);
            });
        }");*/


        $jsOptions = Json::encode($this->jsOptions);
        //$js[] = "$('#{$this->options['id']}').intlTelInput({utilsScript:'$assets->baseUrl/js/utils.js'});";
        $js[] = "$('#{$this->options['id']}').intlTelInput({$jsOptions});";
        $view->registerJs(implode("\n", $js));
    }

}
