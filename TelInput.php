<?php

/**
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */

namespace panix\ext\telinput;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TelInput extends InputWidget {

    public $placeholder;

    public function run() {
        $this->options['type']='tel';
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript() {
        $view = $this->getView();
        Asset::register($view);

        if ($this->placeholder)
            $this->options['placeholder'] = $this->placeholder;

        $options = Json::encode($this->options);
        $js[] = "$('#{$this->options['id']}').tagEditor({$options});";
        $view->registerJs(implode("\n", $js));
    }

}
