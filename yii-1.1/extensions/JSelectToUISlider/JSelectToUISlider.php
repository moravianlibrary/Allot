<?
class JSelectToUISlider extends CWidget
{
	private $_data = array();
	private $_selected = array();

	protected $id;

	public $name;
	public $htmlOptions;

	public function setData($data)
	{
		if(!is_array($data))
			throw new CException(Yii::t(get_class($this),
				'Invalid type. Property "data" must be an array.'));

		$this->_data = $data;
	}

	public function getData()
	{
		return $this->_data;
	}

	public function setSelected($selected)
	{
		if(!is_array($selected))
			throw new CException(Yii::t(get_class($this),
				'Invalid type. Property "selected" must be an array.'));

		$this->_selected = $selected;
	}

	public function getSelected()
	{
		return $this->_selected;
	}

	protected function registerClientScript()
	{
		$baseUrl = CHtml::asset(dirname(__FILE__).'/assets');
		
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerScriptFile($baseUrl.'/js/selectToUISlider.jQuery.js');
		$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
		$cs->registerCssFile($baseUrl.'/css/ui.slider.extras.css');
		$cs->registerScript(__CLASS__.'#'.$this->id, "jQuery('select#{$this->id}').selectToUISlider();", CClientScript::POS_READY);
	}

	public function init()
	{		
		$this->htmlOptions['name']=$this->name;
		$this->id=CHtml::getIdByName($this->name);
		$this->htmlOptions['id']=$this->id;
		$this->registerClientScript();
	}

	public function run()
	{
		echo CHtml::dropDownList($this->name, $this->_selected, $this->_data, $this->htmlOptions);
	}
}