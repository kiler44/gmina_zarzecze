<?php
namespace Generic\Tlumaczenie;
use Generic\Biblioteka\Tlumaczenia\Odmiana;
use Generic\Biblioteka\Tlumaczenia;

abstract class Tlumaczenie implements Tlumaczenia\Interfejs
{
	/**
	 * Tablica dostępnych tlumaczeń
	 *
	 * @var array
	 */
	public $t = array();


	/**
	 * Tablica tlumaczeń domyślnych
	 *
	 * @var array
	 */
	protected $tlumaczeniaDomyslne = array();


	/**
	 * Tablica określająca typy pól tłumaczeń
	 * Dopuszczalne typy: array, list, text, varchar[domyslne]
	 *
	 * @var array
	 */
	protected $typyPolTlumaczen = array();


	public function __construct()
	{
		$this->t = $this->tlumaczeniaDomyslne;
	}

	/**
	 * Zwraca wartość tłumaczenia w odpowiedniej odmianie.
	 *
	 * @param string $tlumaczenie - nazwa klucza tłumaczeń
	 * @param mixed $liczebnik - liczba lub nazwa zmiennej dla odmiany tłumaczenia
	 *
	 * @return string
	 */
	public function odmiana($tlumaczenie, $liczebnik)
	{
		return Odmiana::odmien($this->t[$tlumaczenie], $liczebnik);
	}


	/**
	 * Zwraca blok tlumaczen rozbijajac je na segmenty.
	 *
	 * @param string $nazwaBloku Nazwa bloku.
	 *
	 * @return array
	 */
	public function pobierzBlokTlumaczen($nazwaBloku)
	{
		$tlumaczenia = array();
		$nazwaBloku = $nazwaBloku.'.';
		foreach ($this->t as $k => $v)
		{
			if (strpos($k, $nazwaBloku) === 0)
			{
				// nowa wersja budowania tablicy
				$k = array_reverse(explode('.', str_replace($nazwaBloku, '', $k)));
				$arr = array(array_shift($k) => $v);
				while ($subk = array_shift($k))
				{
					$arr = array($subk => $arr);
				}
				$tlumaczenia = array_merge_recursive($tlumaczenia, $arr);
			}
		}
		return $tlumaczenia;
	}

	/**
	 * Zwraca typ pola tłumaczeń, jeśli pole nie istnieje zwraca null.
	 *
	 * @return string
	 */
	public function pobierzTypPola($klucz)
	{
		if ( ! isset($this->tlumaczeniaDomyslne[$klucz]))
		{
			trigger_error('Klucz ' . $klucz . ' nie istnieje w tlumaczeniu ' . get_class($this));
			return null;
		}

		if (isset($this->typyPolTlumaczen[$klucz]) && $this->typyPolTlumaczen[$klucz] != '')
		{
			if (in_array($this->typyPolTlumaczen[$klucz], $this->dozwoloneTypyPol()))
			{
				return $this->typyPolTlumaczen[$klucz];
			}
			else
			{
				trigger_error('Niedowzwolony typ pola w tlumaczeniu ' . get_class($this));
				return 'varchar';
			}
		}
		else
		{
			return 'varchar';
		}
	}



	final protected function dozwoloneTypyPol()
	{
		return array('array', 'list', 'text', 'varchar');
	}

	/**
	 * Zwraca tablice ze zdefiniowanymi typami pól tłumaczen
	 *
	 * @return array
	 */
	public function pobierzTypyTlumaczen()
	{
		return $this->typyPolTlumaczen;
	}


	/**
	 * Implementacja interfejsu Tlumaczenia_Interfejs
	 */

	/**
	 * Zwraca tablice z tlumaczeniami dla modulu.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->t;
	}

	/**
	 * Zwraca tablice z tlumaczeniami domyslnymi dla modulu.
	 *
	 * @return array
	 */
	public function pobierzTlumaczeniaDomyslne()
	{
		return $this->tlumaczeniaDomyslne;
	}


	/**
	 * Ustawia nowe tlumaczeniami dla modulu.
	 *
	 * @param array $tlumaczenia Tablica z tlumaczeniami dla modulu.
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		$this->t = array_merge($this->tlumaczeniaDomyslne, $tlumaczenia);
	}


	/**
	 * Zwraca tablice z pelnymi tlumaczeniami dla modulu.
	 *
	 * @return array
	 */
	public function pobierzTlumaczeniaPelne()
	{
		return $this->t;
	}
}