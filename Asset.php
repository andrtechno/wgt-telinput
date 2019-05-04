<?php

/**
 *
 * telinput
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */

namespace panix\ext\telinput;

use yii\web\AssetBundle;

class Asset extends AssetBundle {

    public $sourcePath = '@bower/intl-tel-input/build';
    
    public $css = [
        YII_ENV_DEV ? 'css/intlTelInput.css' : 'css/intlTelInput.min.css',
    ];
    
    public $js = [

        YII_ENV_DEV ? 'js/intlTelInput.js' : 'js/intlTelInput.min.js',
        'js/utils.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

}
