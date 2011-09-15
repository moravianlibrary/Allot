<?php
/**
 * EMultiSelect class file.
 *
 * PHP Version 5.1
 * 
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
Yii::import('zii.widgets.jui.CJuiWidget');
/**
 * EMultiSelect Creates Multiple Select Boxes
 *
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: 1.0
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
class EMultiSelect extends CJuiWidget
{
    public $sortable=true;
    public $searchable=true;
    public $dividerLocation=0.6;
    public $language='en';

    /**
     * Run not used...
     *
     * @return void
     */
    function run()
    {
        
    }

    /**
     * Initializes everything
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->registerScripts();
    }

    /**
     * Registers the JS and CSS Files
     *
     * @return void
     */
    protected function registerScripts()
    {
        parent::registerCoreScripts();
		$resources = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$baseUrl = Yii::app()->assetManager->publish($resources);
		//$basePath=Yii::getPathOfAlias('application.extensions.emultiselect.assets');
        //$baseUrl = Yii::app()->getAssetManager()->publish($basePath);

		$cs=Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl.'/ui.multiselect.css');

        $this->scriptUrl=$baseUrl;
        $this->registerScriptFile('ui.multiselect.js');
        $this->registerScriptFile('plugins/localisation/jquery.localisation.js');

        $params = array();
        if ($this->sortable) {
            $params[] = "sortable:true";
        } else {
            $params[] = "sortable:false";
        }

        if ($this->searchable) {
            $params[] = "searchable:true";
        } else {
            $params[] = "searchable:false";
        }

        $params[] = "dividerLocation:".$this->dividerLocation;

        $parameters = '{' .implode(',', $params). '}';
        Yii::app()->clientScript->registerScript(
            'EMultiSelect',
            '$.localise(\'ui-multiselect\', {language: \''.$this->language.'\', path: [\''.$baseUrl.'\', \''.$baseUrl.'/locale/\']}); $(".multiselect").multiselect('. $parameters .');',
            CClientScript::POS_READY
        );

    }
}
?>