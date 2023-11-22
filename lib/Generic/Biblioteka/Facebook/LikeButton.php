<?php
namespace Generic\Biblioteka\Facebook;
use Generic\Biblioteka\Facebook;
use Generic\Biblioteka\FacebookException;


/**
 * Description of LikeButton
 *
 * @author Adrian Sieracki
 */
class LikeButton extends Facebook
{
	/**
	 * Array of attributes for fb-like container
	 * @var array
	 */
	protected $fbAttributes;
	protected $tagAttributes;

	/**
	 * Stałe opcje parametrów z FB
	 */
	const ACTION_LIKE = 'like';
	const ACTION_RECOMMEND = 'recommend';

	const LAYOUT_STANDARD = 'standard';
	const LAYOUT_BUTTON_COUNT = 'button_count';
	const LAYOUT_BOX_COUNT = 'box_count';

	const COLORSCHEME_LIGHT = 'light';
	const COLORSCHEME_DARK = 'dark';

	/**
	 *
	 * @param array $fbAttributes Atrybuty like buttona, można je pobrać z dokumentacji FB like button. W trakcie generowania html będą miały prefix 'data-'.
	 * @param array $tagAttributes Atrybuty do taga html np. id, class, style itd.
	 * @throws FacebookException
	 */
	public function __construct($fbAttributes = array(), $tagAttributes = array("class" => "fb-like"))
	{
		if (is_array($fbAttributes) && is_array($tagAttributes))
		{
			$this->fbAttributes = $fbAttributes;
			$this->tagAttributes = $tagAttributes;
		}
		else
		{
			throw new FacebookException("Expected array");
		}
	}

	/**
	 * Tworzy kontener do like buttona. Każde wywołanie generuje nowy html.
	 * @return string Zwraca html z kontenerem do like buttona
	 */
	public function getButtonHTML()
	{
		$attributes = "";

		if(count($this->tagAttributes) > 0)
		{
			foreach($this->tagAttributes as $attr => $value)
			{
				$attributes .= " $attr=\"$value\"";
			}
		}

		if(count($this->fbAttributes) > 0)
		{
			foreach($this->fbAttributes as $attr => $value)
			{
				// poniższą linijkę należy zastosować w przypadku używania html 5
				$attributes .= " data-$attr=\"$value\"";
//				$attributes .= " $attr=\"$value\"";
			}
		}

		return "<div $attributes></div>";
	}
}
?>
