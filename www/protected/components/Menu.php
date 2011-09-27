<?
class Menu
{
	public static $mainMenuItems = array('Allotment', 'Item', 'Key', 'Lock', 'Door', 'Building', 'ItemType', 'ItemCategory');
	
	private $_items = array();
	private $moduleId = '';
	private $controllerId = '';
	private $actionId = '';
	private $route = '';

	function __construct($route = '')
	{
		$this->route = $route;
		
		$a = explode('/', $route);
		if (sizeOf($a) == 1)
		{
			$this->controllerId = $a[0];
		}
		elseif (sizeOf($a) == 2)
			{
				$this->controllerId = $a[0];
				$this->actionId = $a[1];
			}
			elseif (sizeOf($a) == 3)
				{
					$this->moduleId = $a[0];
					$this->controllerId = $a[1];
					$this->actionId = $a[2];
				}
		$this->initItems();
	}

	protected function initItems()
	{
		$sp = Yii::app()->getStatePersister();
		$state = $sp->load();
		
		// System
		$this->_items['_main'] = array();
		$this->insertItems(self::$mainMenuItems);
		$this->insertItem('Site', '_main', 'setting', 'Settings');

		if ($this->route == 'site/setting' || $this->moduleId == 'rbam' || $this->controllerId == 'user')
		{
			$this->insertItem('User', '_setting');
			$this->insertItem('RBAC Manager', '_setting', '/rbam', 'Access permissions');
			$this->insertItem('Administrator', '_setting', '//myadmin', 'Database', array('target'=>'_blank'));
		}

		if ($this->moduleId == 'rbam' && user()->checkAccess('RBAC Manager'))
		{
			$this->_items['rbam'] = app()->getModule('rbam')->getMenuItems();
		}
		
		// Modules
		if ($this->moduleId != $this->controllerId)
		{
			$actions = $this->getActions($this->controllerId);
			$this->_items[$this->controllerId] = array();
			if (user()->checkAccess(ucfirst($this->controllerId)) || user()->checkAccess(ucfirst($this->controllerId).':Index'))
			{
				foreach ($actions as $actionId=>$actionName)
				{
					if ($actionId != $this->actionId && user()->checkAccess(ucfirst($this->controllerId).':'.ucfirst($actionId)))
					{
						switch ($actionId)
						{
							case 'update': case 'view':
								if (isset($_GET['id']) && is_numeric($_GET['id'])) $this->_items[$this->controllerId][] = array('label'=>$actionName, 'url'=>array($actionId, 'id'=>$_GET['id']), 'linkOptions'=>array('id'=>"menu-${actionId}-record"));
								break;
							case 'delete':
								if (isset($_GET['id']) && is_numeric($_GET['id'])) $this->_items[$this->controllerId][] = array('label'=>$actionName, 'url'=>'#', 'linkOptions'=>array('id'=>"menu-${actionId}-record", 'submit'=>array('delete','id'=>$_GET['id']),'confirm'=>'Odstranit záznam?'));
								break;
							default:
								$this->_items[$this->controllerId][] = array('label'=>$actionName, 'url'=>array($actionId), 'linkOptions'=>array('id'=>"menu-${actionId}-record"));
								break;
						}
					}
				}
			}
		}
		$this->insertItem('Item:Create', 'key', '/item/create', 'Create Key');
		$this->insertItem('Item:Create', 'lock', '/item/create', 'Create Lock');
	}
	
	public function insertItems($items, $type = '_main')
	{
		foreach ($items as $item) $this->insertItem($item, $type);		
	}
		
	public function insertItem($rights, $type = '_main', $action = 'admin', $title = '', $linkOptions = array(), $accessParams = array())
	{
		$model = explode(':', $rights);
		$modelClass = $model[0];
		
		if ($title == '') $title = $this->pluralize($this->class2name($modelClass));
		if (substr($action, 0, 2) == '//')
		{
			$action = substr($action, 1);
		}
		elseif (substr($action, 0, 1) == '/')
			{
				$action = array($action);
			}
			else
			{
				$action = array('/'.$this->class2var($modelClass).'/'.$action);
			}
		if (user()->checkAccess($rights, $accessParams) || (sizeof($model) == 1 && user()->checkAccess($modelClass.':Index'))) $this->_items[$type][] = array('label'=>t($title), 'url'=>$action, 'linkOptions'=>$linkOptions);
	}

	protected function getActions($name)
	{
		$name = $this->class2name($name);
		$pluralName = $this->pluralize($name);
		return array('admin'=>t('Manage '.$pluralName), 'index'=>t('View '.$pluralName), 'update'=>t('Update '.$name), 'view'=>t('View '.$name), 'delete'=>t('Delete '.$name), 'create'=>t('Create '.$name));
	}
	
	public function items($type = '')
    {
		if ($type == '') return $this->_items[($this->moduleId != '' ? $this->moduleId : $this->controllerId)]; else return $this->_items[$type];
    }
    
    protected function pluralize($name)
	{
		$rules=array(
				'/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
				'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
				'/(m)an$/i' => '\1en',
				'/(child)$/i' => '\1ren',
				'/(r|t)y$/i' => '\1ies',
				'/s$/' => 's',
		);
		foreach($rules as $rule=>$replacement)
		{
				if(preg_match($rule,$name))
						return preg_replace($rule,$replacement,$name);
		}
		return $name.'s';
	}
	
	protected function class2name($name,$ucwords=true)
	{
		$result=trim(strtolower(str_replace('_',' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name))));
		return $ucwords ? ucwords($result) : $result;
	}

	protected function class2var($name)
	{
			$name[0]=strtolower($name[0]);
			return $name;
	}
}