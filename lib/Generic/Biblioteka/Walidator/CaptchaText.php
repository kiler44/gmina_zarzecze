<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;


/**
 * Walidator sprawdzający poprawność tekstu captcha
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class CaptchaText extends Walidator
{

	protected $trescBledow = array(
		'walidator_captcha_text_nieprawidlowa_wartosc' => 'Podany wynik jest nieprawidłowy. Przykład: "cztery razy 1" - należy wpisać "4"',
	);

	private $nazwaInputa;



	function __construct($nazwaInputa)
	{
		if (empty($nazwaInputa))
		{
			trigger_error('Nie okreslono nazwy inputa dla walidatora '.get_class($this), E_USER_WARNING);
		}
		$this->nazwaInputa = $nazwaInputa;
	}



	function sprawdz($wartosc)
	{
		$cms = Cms::inst();
		if ( ! isset($cms->sesja->captcha))
		{
			$cms->sesja->captcha = array();
		}
		if (array_key_exists($this->nazwaInputa, $cms->sesja->captcha)
			&& $cms->sesja->captcha[$this->nazwaInputa]['pytanie'] == $wartosc['pytanie']
			&& $cms->sesja->captcha[$this->nazwaInputa]['odpowiedz'] == $wartosc['odpowiedz'])
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_captcha_text_nieprawidlowa_wartosc');
			return false;
		}
	}
}
