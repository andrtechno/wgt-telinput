wgt-telinput
===========
Widget for Yii Framework 2.0

[![Latest Stable Version](https://poser.pugx.org/panix/wgt-telinput/v/stable)](https://packagist.org/packages/panix/wgt-telinput) [![Total Downloads](https://poser.pugx.org/panix/wgt-telinput/downloads)](https://packagist.org/packages/panix/wgt-telinput) [![Monthly Downloads](https://poser.pugx.org/panix/wgt-telinput/d/monthly)](https://packagist.org/packages/panix/wgt-telinput) [![Daily Downloads](https://poser.pugx.org/panix/wgt-telinput/d/daily)](https://packagist.org/packages/panix/wgt-telinput) [![Latest Unstable Version](https://poser.pugx.org/panix/wgt-telinput/v/unstable)](https://packagist.org/packages/panix/wgt-telinput) [![License](https://poser.pugx.org/panix/wgt-telinput/license)](https://packagist.org/packages/panix/wgt-telinput)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist panix/wgt-telinput "*"
```

or add

```
"panix/wgt-telinput": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```php
<?php
        $form->field($model, 'text')->widget(TelInput::className(), [
            'options' => [],
        ]);
 ?>
```

