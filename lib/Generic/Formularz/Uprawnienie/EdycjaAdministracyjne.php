<?php
namespace Generic\Formularz\Uprawnienie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class EdycjaAdministracyjne extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array
	 */
	protected $uprawnienia = array();

	
	/**
	 * @var Array
	 */
	protected $zapisaneUprawnienia = array();


	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;


	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'uprawnieniaAdministracyjne');
		foreach($this->uprawnienia as $modul => $dane)
		{
			$zaznacz_wiele = $this->szablon->parsujBlok('/zaznacz_wiele_link', array(
				'rel' => $modul,
			));
			$this->formularz->otworzRegion($modul, $dane['nazwa'].$zaznacz_wiele);
			unset($dane['nazwa']);
			foreach ($dane as $akcja => $etykieta)
			{
				$nazwa = $modul.'_'.$akcja;
				if ($etykieta == '') $etykieta = str_replace('wykonaj', '', $akcja);
				$wartosc = (array_key_exists($nazwa, $this->zapisaneUprawnienia)) ? 1 : 0;
				$this->formularz->input(new Input\Checkbox($nazwa, $etykieta, array(
					'wartosc' => $wartosc,
					'atrybuty' => array('class' => $modul),
				)));
				$this->formularz->$nazwa->dodajFiltr('intval');
			}
			$this->formularz->zamknijRegion($modul);
		}

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawUprawnienia(Array $uprawnienia)
	{
		$this->uprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawZapisaneUprawnienia(Array $uprawnienia)
	{
		$this->zapisaneUprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}
}