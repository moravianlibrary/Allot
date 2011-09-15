<?
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 */
function user()
{
    return Yii::app()->getUser();
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::app()->createUrl($route,$params,$ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'app', $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null)
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}

function dump($target)
{
	return CVarDumper::dump($target, 10, true);
}

function dumps($target)
{
	return CVarDumper::dumpAsString($target);
}

function ylog($target)
{
	Yii::log(dumps($target));
}

function currf($val, $cur = 'CZK')
{
    return Yii::app()->numberFormatter->formatCurrency($val, $cur);
}

function datef($val, $df = 'medium', $tf = null)
{
	if (strtotime($val)) return Yii::app()->dateFormatter->formatDateTime($val, $df, $tf); else return "";
}

function dayf($val, $pat = 'eee')
{
	if (strtotime($val)) return Yii::app()->dateFormatter->format($pat, $val); else return "";
}

function monthf($val, $pat = 'LLLL')
{
	if (strtotime($val)) return Yii::app()->dateFormatter->format($pat, $val); else return "";
}

function db()
{
	return Yii::app()->getDb();
}

function am()
{
	return Yii::app()->getAuthManager();
}

function req()
{
	return Yii::app()->getRequest();
}

function asm()
{
	return Yii::app()->getAssetManager();
}

function sess()
{
	return Yii::app()->getSession();
}
?>