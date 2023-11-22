<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;


/**
 * Wyświetlanie liczb w postaci słownej.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class LiczbaSlownie implements Tlumaczenia\Interfejs
{

	protected $tlumaczenia = array(
		'minus' => 'minus',
		'zero' => 'zero',
		'jednosci' => array('jeden', 'dwa', 'trzy', 'cztery', 'pięć', 'sześć', 'siedem', 'osiem', 'dziewięć'),
		'kilkanascie' => array('jedenaście', 'dwanaście', 'trzynaście', 'czternaście', 'piętnaście', 'szesnaście', 'siedemnaście', 'osiemnaście', 'dziewiętnaście'),
		'dziesiatki' => array('dziesięć', 'dwadzieścia', 'trzydzieści', 'czterdzieści', 'pięćdziesiąt', 'sześćdziesiąt', 'siedemdziesiąt', 'osiemdziesiąt', 'dziewięćdziesiąt'),
		'setki' => array('sto', 'dwieście', 'trzysta', 'czterysta', 'pięćset', 'sześćset', 'siedemset', 'osiemset', 'dziewięćset'),
		'tysiące' => array('tysiąc', 'tysiące', 'tysięcy'),
		'miliony' => array('milion', 'miliony', 'milionów'),
		'miliardy' => array('miliard', 'miliardy', 'miliardów'),
		'biliony' => array('bilion', 'biliony', 'bilionów'),
		'biliardy' => array('biliard', 'biliardy', 'biliardów'),
		'tryliony' => array('trylion', 'tryliony', 'trylionów'),
		'tryliardy' => array('tryliard', 'tryliardy', 'tryliardów'),
		'kwadryliony' => array('kwadrylion', 'kwadryliony', 'kwadrylionów'),
		'kwintyliony' => array('kwintylion', 'kwintyliony', 'kwintylionów'),
		'sekstyliony' => array('sekstylion', 'sekstyliony' ,'sekstylionów'),
		'septyliony' => array('septylion', 'septyliony', 'septylionów'),
		'oktyliony' => array('oktylion', 'oktyliony', 'oktylionów'),
		'nonyliony' => array('nonylion', 'nonyliony', 'nonylionów'),
		'decyliony' => array('decylion', 'decyliony', 'decylionów'),
	);



	protected function piszodmiane($segment, $int)
	{
		$odmiany = array(
			'',
			'tysiące',
			'miliony',
			'miliardy',
			'biliony',
			'biliardy',
			'tryliony',
			'tryliardy',
			'kwadryliony',
			'kwintyliony',
			'sekstyliony',
			'septyliony',
			'oktyliony',
			'nonyliony',
			'decyliony'
		);
		$odmiany = $this->tlumaczenia[$odmiany[$segment]];

		$slownie = $odmiany[2];
		if ($int == 1) $slownie = $odmiany[0];
		$jednosci = (int)substr($int,-1);
		$reszta = $int % 100;
		if (($jednosci > 1 && $jednosci < 5) &! ($reszta > 10 && $reszta < 20)) $slownie = $odmiany[1];
		return $slownie;
	}



	protected function piszliczbe($liczba)
	{
		$liczba = abs((int) $liczba);

		if ($liczba == 0) return $this->tlumaczenia['zero'];

		$jednosci = $liczba % 10;
		$dziesiatki = ($liczba % 100 - $jednosci) / 10;
		$setki = ($liczba - $dziesiatki*10 - $jednosci) / 100;

		$slownie = ' ';

		if ($setki > 0) $slownie .= $this->tlumaczenia['setki'][$setki-1].' ';

		if ($dziesiatki > 0)
			if ($dziesiatki == 1 && $jednosci > 0)
				$slownie .= $this->tlumaczenia['kilkanascie'][$jednosci-1].' ';
			else
				$slownie .= $this->tlumaczenia['dziesiatki'][$dziesiatki-1].' ';

		if ($jednosci > 0 && $dziesiatki != 1) $slownie .= $this->tlumaczenia['jednosci'][$jednosci-1].' ';

		return $slownie;
	}



	/**
	 * Zwraca liczbę zapisaną słownie
	 *
	 * @param integer $liczba liczba do przekonwertowania
	 *
	 * @return string
	 */
	public function slownie($liczba)
	{
		$in = preg_replace('/[^-\d]+/','',$liczba);
		$slownie = '';

		if ($in{0} == '-')
		{
			$in = substr($in, 1);
			$slownie = $this->tlumaczenia['minus'].' ';
		}

		if ($in == 0) $slownie = $this->tlumaczenia['zero'].' ';

		$txt = str_split(strrev($in), 3);

		for ($i = count($txt) - 1; $i >= 0; $i--)
		{
			$liczba = (int)strrev($txt[$i]);
			if ($liczba > 0)
				if ($i == 0)
					$slownie .= $this->piszliczbe($liczba).' ';
				else
					$slownie .= ($liczba > 1 ? $this->piszliczbe($liczba).' ' : '').$this->piszodmiane($i, $liczba).' ';
		}
		return trim($slownie);
	}



	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array Tablica z tlumaczeniami.
	 */
	public function pobierzTlumaczenia()
	{
		return $this->tlumaczenia;
	}



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return bool True jezeli sukces, False jezeli porazka.
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia))
		{
			$this->tlumaczenia = array_merge_recursive($this->tlumaczenia, $tlumaczenia);
			return true;
		}
		return false;
	}
}