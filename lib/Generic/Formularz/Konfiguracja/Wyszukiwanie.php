<?php
namespace Generic\Formularz\Konfiguracja;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{

	protected $typModulow;

	protected $wartoscTyp;

	protected $wartoscFraza;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieZwykle');

		$this->formularz->input(new Input\Czysc('czysc', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_czysc'],
		)));
		$this->formularz->input(new Input\Submit('szukaj', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_szukaj'],
		)));
		$this->formularz->input(new Input\Text('fraza', $this->tlumaczenia['etykieta_input_fraza'], array(
			'wartosc' => $this->wartoscFraza,
		)));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		if ($this->typModulow == 'zwykle')
		{
			$lista = $this->tlumaczenia['modul_typy'];
			unset($lista['administracyjny']);
			$this->formularz->input(new Input\Select('typ', $this->tlumaczenia['etykieta_input_typ'], array(
				'wartosc' => $this->wartoscTyp,
				'lista' => $lista,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			)));
		}

		if ($this->typModulow == 'administracyjne')
		{
			$domyslneWartosci = array(
				'typ' => 'administracyjny',
				'fraza' => ''
			);
		}
		elseif ($this->typModulow == 'zwykle')
		{
			$domyslneWartosci = array(
				'typ' => array('zwykly', 'jednorazowy', 'blok'),
				'fraza' => ''
			);
		}
		// obsluga przycisku czysc
		if (Zadanie::pobierz('czysc', 'trim') != '')
		{
			foreach ($domyslneWartosci as $pole => $wartosc)
			{
				if ($this->typModulow != 'zwykle' && $pole != 'typ') $this->formularz->$pole->ustawWartosc($wartosc, true);
				if ($this->typModulow == 'zwykle') $this->formularz->$pole->ustawWartosc(null, true);
				$kryteria[$pole] = $wartosc;
			}
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * return \Generic\Formularz\Konfiguracja\Wyszukiwanie
	 */
	public function ustawTypModulow($typ)
	{
		$this->typModulow = $typ;

		return $this;
	}


	/**
	 * return \Generic\Formularz\Konfiguracja\Wyszukiwanie
	 */
	public function ustawDomyslne($typ, $fraza)
	{
		$this->wartoscTyp = $typ;
		$this->wartoscFraza = $fraza;

		return $this;
	}




}