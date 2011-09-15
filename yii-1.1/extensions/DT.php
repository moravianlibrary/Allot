<?
class DT //DateTime
{
	private static $_holidays = array('01-01','05-01','05-08','07-05','07-06','09-28','10-28','11-17','12-24','12-25','12-26');
	
	public static function isoToday()
	{
		return date('Y-m-d');
	}
	
	public static function locToday()
	{
		return self::toLocDate(self::isoToday());
	}

	public static function add($d, $days = 1)
	{
		$a = explode('-', $d);
		return date('Y-m-d', mktime(0, 0, 0, $a[1] ,$a[2]+$days ,$a[0]));
	}
	
	public static function addLoc($d, $days = 1)
	{
		return self::toLoc(self::add(self::toIso($d), $days));
	}
	
	public static function addIso($d, $days = 1)
	{
		return self::add($d, $days);
	}
	
	public static function toIso($d = '')
	{
		return self::toIsoDate($d);
	}
	
	public static function toIsoDate($d = '')
	{
		if ($d === '0' || $d === "0" || $d === 0) return '0000-00-00';
		if (preg_match('/\d{4}-\d{2}-\d{2}/', $d)) return $d;
		if ($d) return date('Y-m-d', CDateTimeParser::parse($d, Yii::app()->locale->dateFormat)); else return '';
	}
	
	public static function toIsoDateTime($d)
	{
		if ($d === '0' || $d === "0" || $d === 0) return '0000-00-00 00:00:00';
		if (preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $d)) return $d;
		if ($d) return date('Y-m-d H:i:s', CDateTimeParser::parse($d, Yii::app()->locale->dateFormat.' '.Yii::app()->locale->timeFormat)); else return '';
	}
	
	public static function toLoc($d)
	{
		return self::toLocDate($d);
	}
	
	public static function toLocDate($d, $format = 'yyyy-MM-dd', $dateWidth='medium', $timeWidth=null)
	{
		if (!preg_match('/\d{4}-\d{2}-\d{2}/', $d)) return $d;
		if ($d != '0000-00-00') return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($d, $format), $dateWidth, $timeWidth); else return '';
	}

	public static function toLocDateTime($d)
	{
		if ($d != '0000-00-00 00:00:00') return self::toLocDate($d, 'yyyy-MM-dd hh:mm:ss', 'medium', 'medium'); else return '';
	}
	
	public static function eq($d1, $d2)
	{
		return (self::toIsoDate($d1) == self::toIsoDate($d2));
	}
	
	public static function gt($d1, $d2)
	{
		return (self::toIsoDate($d1) > self::toIsoDate($d2));
	}
	
	public static function gte($d1, $d2)
	{
		return (self::toIsoDate($d1) >= self::toIsoDate($d2));
	}
	
	public static function lt($d1, $d2)
	{
		return (self::toIsoDate($d1) < self::toIsoDate($d2));
	}
	
	public static function lte($d1, $d2)
	{
		return (self::toIsoDate($d1) <= self::toIsoDate($d2));
	}
	
	public static function holidays()
    {
       return self::$_holidays;
    }

	public static function isWorkingDay($d)
	{
		$a = explode('-', $d);
		if ((date('N', mktime(0, 0, 0, $a[1] ,$a[2] ,$a[0])) <=5) && !in_array("{$a[1]}-{$a[2]}", self::$_holidays) && ("{$a[1]}-{$a[2]}" != date("m-d", easter_date($a[0])+86400))) return true;
		else return false;
	}

	public static function getWorkingDays($start_date, $end_date)
    {
		$d = 0;
		while ($start_date <= $end_date)
		{
			if (self::isWorkingDay($start_date)) $d++;
			$start_date = self::add($start_date);
		}
		return $d;
	}
}
?>