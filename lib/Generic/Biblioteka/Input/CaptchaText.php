<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca captche tekstowa.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class CaptchaText extends Input
{
	protected $katalogSzablonu = 'CaptchaTextNew';
	protected $tpl = '
	<div class="captha_pytanie">{{$nowe_pytanie}}</div>
	<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} />
	<input type="hidden" name="{{$nazwa}}_pytanie" value="{{$nowe_pytanie_hash}}"/>
	';


	/**
	 * Ustawia wartosc poczatkowa inputa.
	 * UWAGA: nie można ustawiać wartości początkowej dla tego inputa!
	 *
	 * @param mixed $wartoscPoczatkowa Wartosc poczatkowa inputa.
	 * @param bool $wymus wymuszanie nadpisania wartosc.
	 */
	function ustawWartosc($wartoscPoczatkowa, $wymus = false)
	{
		$this->wartoscPoczatkowa = null;
		$this->wymusPoczatkowa = false;
	}



	function pobierzWartosc()
	{
		// nie powinno się nadawac wartosci poczatkowej temu inputowi

		$pytanie = Zadanie::pobierz($this->pobierzNazwe().'_pytanie', 'trim');
		if ($pytanie !== null)
		{
			return array(
				'pytanie' => $pytanie,
				'odpowiedz' => $this->filtrujWartosc(Zadanie::pobierz($this->pobierzNazwe())),
			);
		}
		else
		{
			// musi byc null
			return null;
		}
	}



	function pobierzHtml()
	{
		$nowePytanie = $this->generujPytanie();

		$cms = Cms::inst();
		if ( ! isset($cms->sesja->captcha))
		{
			$cms->sesja->captcha = array();
		}
		$cms->sesja->captcha[$this->nazwa] = array(
			'pytanie' => md5($nowePytanie['pytanie']),
			'odpowiedz' => $nowePytanie['odpowiedz'],
		);

		$dane = array(
			'nowe_pytanie' => $nowePytanie['pytanie'],
			'nazwa' => $this->nazwa,
			'atrybuty' => $this->pobierzAtrybuty(),
			'nowe_pytanie_hash' => md5($nowePytanie['pytanie']),
		);

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}



	protected function generujPytanie()
	{
		$operacje = array ('plus','minus', 'razy');
		$operacjeZnaki = array('plus' => '+', 'minus' => '-', 'razy' => 'x');

		$wybranaOperacja = $operacje[rand(0,2)];

		switch ($wybranaOperacja)
		{
			case 'plus':
				$pierwszaLiczba = rand(1, 9);
			break;

			case 'minus':
				$pierwszaLiczba = rand(10, 20);
			break;

			case 'razy':
				$pierwszaLiczba = rand(1, 5);
			break;
		}
		$drugaLiczba = rand(1, 9);

		switch ($wybranaOperacja)
		{
			case 'plus':
				$suma = $pierwszaLiczba + $drugaLiczba;
			break;

			case 'minus':
				$suma = $pierwszaLiczba - $drugaLiczba;
			break;

			case 'razy':
				$suma = $pierwszaLiczba * $drugaLiczba;
			break;
		}

		$trescPytania = $this->tlumaczenia['input_captcha_text_etykieta_pytanie'];
		$trescPytania .= (rand(0,1) == 1) ? $this->tlumaczenia['input_captcha_text_etykieta_'.$pierwszaLiczba] : (string)$pierwszaLiczba;
		$trescPytania .= ' ';
		$trescPytania .= (rand(0,1) == 1) ? $this->tlumaczenia['input_captcha_text_etykieta_'.$wybranaOperacja] : (string)$operacjeZnaki[$wybranaOperacja];
		$trescPytania .= ' ';
		$trescPytania .= (rand(0,1) == 1) ? $this->tlumaczenia['input_captcha_text_etykieta_'.$drugaLiczba] : (string)$drugaLiczba;

		return array(
			'pytanie' => $trescPytania,
			'odpowiedz' => $suma,
		);
	}

}

