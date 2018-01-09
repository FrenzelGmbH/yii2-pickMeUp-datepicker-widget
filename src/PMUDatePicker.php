<?php

namespace gudron\datepicker;

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use yii\web\View;

class PMUDatePicker extends InputWidget
{
	 /**
     * @var array clientOptions the HTML attributes for the widget container tag.
     */
    public $clientOptions = [
        'hide_on_select' => true
    ];
  
  	/**
    * @var array options the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = [
        'class' => 'pickmeup',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
      
      	//checks for the element class
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'pickmeup';
        }
      
         //checks for the element format
        if (!isset($this->clientOptions['format'])) {
            $this->clientOptions['format'] = 'Y-m-d';
        }
        
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /*$input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);
        */

      	echo Html::beginTag('div', $this->options) . "\n";
        echo Html::endTag('div')."\n";
      
        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as DatePicker
     */
    public function registerClientScript()
    {
        $js = [];
      
      	$js[] = "pickmeup.defaults.locales['" . \Yii::$app->language . "'] = " . Json::encode(require(__DIR__ . '/locales/' . \Yii::$app->language . '/locale.php'));
      
        $id = $this->options['id'];
        $view = $this->getView();

        PMUDatePickerAsset::register($view);
      
        $this->clientOptions['locale'] = \Yii::$app->language;        

        if(!isset($this->clientOptions['change'])) {
        	$this->clientOptions['change'] = new JsExpression("function(e){jQuery('#$id').trigger('change')}");
        }

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';
      
        $js[] = "pickmeup('#$id',$options);";

        $view->registerJs(implode("\n", $js),View::POS_READY);
    }
}
