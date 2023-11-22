<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Cms;


/**
 * Klasa abstrakcyjna dla walidatorow.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

abstract class Walidator
{

	/**
	 * Tablica przetrzymujaca tresc bledow zwracanych podczas walidacji.
	 *
	 * @var array
	 */
	protected $trescBledow = array();


	/**
	 * Czy ustawiono komuniaty bledow recznie.
	 *
	 * @var boolean
	 */
	protected $ustawionoBledy = false;


	/**
	 * Tresc bledu w wyniku nieudanej walidacji.
	 *
	 * @var string
	 */
	private $blad = null;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Biblioteka\Walidatory
	 */
	protected $j;
	
	
	function __construct()
	{
		if (!defined(KOD_JEZYKA_ITERFEJSU))
		{
			define(KOD_JEZYKA_ITERFEJSU, KOD_JEZYKA);
		}
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Biblioteka\\Walidatory';
		$this->j = utworzObiektRaz($namespaceJezyka);
		$this->ustawTlumaczenia($this->j->t);
	}
	
	/**
	 * Ustawia tresc bledu w wewnetrznej zmiennej.
	 *
	 * @param string $kodBledu kod bledu.
	 */
	protected function ustawBlad($kodBledu)
	{
		if ( ! $this->ustawionoBledy && isset(Cms::inst()->lang['walidatory'][$kodBledu]) && Cms::inst()->lang['walidatory'][$kodBledu] != '')
		{
			$this->blad = Cms::inst()->lang['walidatory'][$kodBledu];
		}
		else
		{
			$this->blad = $this->trescBledow[$kodBledu];
		}
	}



	/**
	 * Zwraca tresc bledu zapisanego w wewnetrznej zmiennej.
	 *
	 * @return string
	 */
	public function pobierzBlad()
	{
		return (string)$this->blad;
	}



	/**
	 * Sprawdza wartosc podana w argumencie. Jezeli wystapi blad to ustawia
	 * tresc do wewnetrznej zmiennej i zwaraca false.
	 * Tresc metody w klasach rozszerzajacych.
	 *
	 * @param $wartosc wartosc do sprawdzenia.
	 *
	 * @return boolean
	 */
	public abstract function sprawdz($wartosc);



	/**
	 * Zwraca tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->trescBledow;
	}



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return boolean
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->trescBledow = array_merge($this->trescBledow, $tlumaczenia))
		{
			$this->ustawionoBledy = true;
			return true;
		}
		return false;
	}

}
