wgt-telinput
===========
Widget for Yii Framework 2.0

[![Latest Stable Version](https://poser.pugx.org/panix/wgt-taginput/v/stable)](https://packagist.org/packages/panix/wgt-taginput) [![Total Downloads](https://poser.pugx.org/panix/wgt-taginput/downloads)](https://packagist.org/packages/panix/wgt-taginput) [![Monthly Downloads](https://poser.pugx.org/panix/wgt-taginput/d/monthly)](https://packagist.org/packages/panix/wgt-taginput) [![Daily Downloads](https://poser.pugx.org/panix/wgt-taginput/d/daily)](https://packagist.org/packages/panix/wgt-taginput) [![Latest Unstable Version](https://poser.pugx.org/panix/wgt-taginput/v/unstable)](https://packagist.org/packages/panix/wgt-taginput) [![License](https://poser.pugx.org/panix/wgt-taginput/license)](https://packagist.org/packages/panix/wgt-taginput)

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

