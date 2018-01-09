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
    ];
  
  	/**
    * @var array jsHandler for the different elements
    */
  	public $jsHandler = [
    ];
  
  	/**
    * @var array options the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = [
        'class' => 'pmufancy',
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
            $this->options['class'] = 'pmufancy';
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
      
        $id = $this->options['id'];
        $view = $this->getView();

        PMUDatePickerAsset::register($view);
      
        // setting the correct locale (globaly)
      	$js[] = "pickmeup.defaults.locales['" . \Yii::$app->language . "'] = " . Json::encode(require(__DIR__ . '/locales/' . \Yii::$app->language . '/locale.php'));
      	
        $this->clientOptions['locale'] = \Yii::$app->language;               	
      
      	$options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';
      
        $js[] = "pickmeup('#$id',$options);";
      	
        if(!isset($this->jsHandler['change'])) {
        	$js[] = new JsExpression("$('#$id').on('pickmeup-change', function (e) {
  console.log(e.detail.formatted_date); // New date according to current format
  console.log(e.detail.date); // New date as Date object
})");
        }else{
        	$js[] = $this->jsHandler['change'];
        }
                   
        $view->registerJs(implode("\n", $js),View::POS_READY);
    }
}
