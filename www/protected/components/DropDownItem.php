<?
class DropDownItem
{
	private static $_items=array(
		//'model.name'=>array('key'=>'val'),
		'itemCategory.ext_table'=>array("key"=>"Klíče", "lock"=>"Zámkové vložky"),
		'allotment.return_status'=>array("A"=>"v pořádku", "P"=>"poškozeno", "Z"=>"ztraceno/zničeno"),
	);

    public static function items($type)
    {
       return self::$_items[$type];
    }

    public static function item($type, $code)
    {
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }
}