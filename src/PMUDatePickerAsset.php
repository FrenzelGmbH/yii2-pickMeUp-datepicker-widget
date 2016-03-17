<?php

namespace gudron\datepicker;

use yii\web\AssetBundle;

class PMUDatePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/gudron/yii2-pickMeUp-datepicker-widget/src/assets';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->css[] = YII_DEBUG ? 'css/pickmeup.css' : 'css/pickmeup.min.min.css';
        $this->js[] = YII_DEBUG ? 'js/jquery.pickmeup.js' : 'js/jquery.pickmeup.min.min.js';

        parent::init();
    }

} 