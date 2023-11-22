<?php
namespace Generic\Formularz\Tlumaczenie;
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
		$this->formularz = new Formularz('', 'wyszukiwanie');

		$this->formularz->input(new Input\Czysc('czysc'));
		$this->formularz->input(new Input\Submit('szukaj'));
		$this->formularz->input(new Input\Text('fraza', array(
				'wartosc' => $this->wartoscFraza
			)));

		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		if ($this->typModulow == 'zwykle')
		{
			$lista = $this->tlumaczenia['modul_typy'];
			unset($lista['administracyjny']);
			$this->formularz->input(new Input\Select('typ', array(
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
				$this->formularz->$pole->ustawWartosc($wartosc, true);
				if ($this->typModulow == 'zwykle') $this->formularz->$pole->ustawWartosc(null, true);
				$this->czyscParametr($pole);
			}
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * return \Generic\Formularz\Tlumaczenie\Wyszukiwanie
	 */
	public function ustawTypModulow($typ)
	{
		$this->typModulow = $typ;

		return $this;
	}


	/**
	 * return \Generic\Formularz\Tlumaczenie\Wyszukiwanie
	 */
	public function ustawDomyslne($typ, $fraza)
	{
		$this->wartoscTyp = $typ;
		$this->wartoscFraza = $fraza;

		return $this;
	}
}