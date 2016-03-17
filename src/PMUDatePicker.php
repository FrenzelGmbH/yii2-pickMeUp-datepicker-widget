<?php

namespace gudron\datepicker;

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class PMUDatePicker extends InputWidget
{

    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->clientOptions['format'] = 'Y-m-d';

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);

        echo $input;
        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as DatePicker
     */
    public function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        PMUDatePickerAsset::register($view);

        $id = $this->options['id'];
        $selector = ";jQuery('#$id')";

        if(!empty($this->clientOptions)) {
            // set locales
            if(!isset($this->clientOptions['locale'])) {
                $this->clientOptions['locale'] = require(__DIR__ . '/locales/' . \Yii::$app->language . '/locale.php');
            }

            if(!isset($this->clientOptions['change'])) {
                $this->clientOptions['change'] = "function(e){jQuery('#$id').trigger('change')});";
            }
        }

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';

        $js[] = "$selector.pickmeup($options);";

        $view->registerJs(implode("\n", $js));
    }
} 