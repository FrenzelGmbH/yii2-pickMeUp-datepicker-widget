<?php

namespace gudron\datepicker;

use yii\web\AssetBundle;

class PMUDatePickerAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@bower/pickmeup';

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'css/pickmeup.css',
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'js/pickmeup.js',
      	'js/js.pickmeup.twitter-bootstrap.js',
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
    }
}