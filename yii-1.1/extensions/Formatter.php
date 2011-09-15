<?
class Formatter extends CFormatter
{
	public function formatCzk($value)
	{
		return Yii::app()->numberFormatter->formatCurrency($value, 'CZK');
	}
	
	public function formatBoolean($value)
	{
		return Yii::t('app', parent::formatBoolean($value));
	}
}
?>