<?php

/**
 *
 * taginput
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */

namespace panix\ext\taginput;

use yii\web\AssetBundle;

class Asset extends AssetBundle {

    public $sourcePath = '@vendor/panix/wgt-taginput/assets';
    
    public $css = ['css/jquery.tag-editor.css'];
    
    public $js = [
        YII_ENV_DEV ? 'js/jquery.tag-editor.js' : 'js/jquery.tag-editor.min.js',
        'js/jquery.caret.min.js'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];

}
