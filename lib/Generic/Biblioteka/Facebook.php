<?php
namespace Generic\Biblioteka;


/**
 * Description of Facebook
 *
 * @author Adrian Sieracki
 */
class Facebook
{
	public static function getJavaScriptSDK()
	{
		$js = "<div id=\"fb-root\"></div>
<script type=\"text/javascript\">
<!--
$(document).ready(function(){
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = \"//connect.facebook.net/pl_PL/all.js#xfbml=1\";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
});
-->
</script>";

		return $js;
	}

	public static function displayJavaScriptSDK()
	{
		echo self::getJs();
	}
}


class FacebookException extends \Exception
{
	public function __construct($message) {
		parent::__construct($message);
	}
}
?>
