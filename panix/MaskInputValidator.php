<?php

namespace panix\ext\telinput;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use yii\helpers\Json;
use yii\validators\Validator;

class MaskInputValidator extends Validator
{
    public function init()
    {
        if (!$this->message) {
            $this->message = \Yii::t('yii', 'The format of {attribute} is invalid.');
        }
        parent::init();
    }

    protected function validateValue($value)
    {
        return null;

    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = Json::htmlEncode([
            'message' => \Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], \Yii::$app->language),
        ]);
        return <<<JS
        var options = $options, telInput = $(attribute.input);
        if($.trim(telInput.val())){
            if (!telInput.inputmask("isComplete")){
                messages.push(options.message);
            }
        }
JS;
    }
}
