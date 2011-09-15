<?php
class JuiDialogCreateButton extends CWidget {

	public $model = 'Edit';
	public $controller_id = null;
	public $dialog_id = null;
	public $title = null;
	public $urlParams = array();
	
    public function run() {
		if ($this->controller_id === null) $this->controller_id = $this->controller->class2var($this->model);
		if ($this->dialog_id === null) $this->dialog_id = $this->controller->class2id($this->model);
		if ($this->title === null) $this->title = Yii::t('app', 'Create '.$this->controller->class2name($this->model));
        $this->render('juiDialogCreateButton');
    }
}
?>