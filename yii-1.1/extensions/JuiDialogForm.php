<?php
class JuiDialogForm extends CWidget {

	public $model = 'Edit';
	public $controller_id = null;
	public $dialog_id = null;
	public $title = null;
	public $show = 'fade';
	public $hide = 'fade'; // 'explode', 'puff',
	public $modal = true;
	public $width = '810';
	public $height = 'auto';
	public $draggable = true;
	public $success = null;
	public $registerScripts = null;
	public $forceDialog = false;
	
    public function run() {
		if ($this->controller_id === null) $this->controller_id = $this->controller->class2var($this->model);
		if ($this->dialog_id === null) $this->dialog_id = $this->controller->class2id($this->model);
		if ($this->title === null) $this->title = Yii::t('app', $this->controller->class2name($this->model));
		if ($this->registerScripts === null) $this->registerScripts = $this->modal;
        $this->render('juiDialogForm');
    }
}
?>