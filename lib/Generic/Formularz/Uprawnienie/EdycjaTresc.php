<?php
namespace Generic\Formularz\Uprawnienie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;

class EdycjaTresc extends \Generic\Formularz\Abstrakcja
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
		$cms = Cms::inst();

		$this->formularz = new Formularz('', 'uprawnieniaTresci');

		foreach($this->uprawnienia as $usluga => $kategorie)
		{
			$this->formularz->otworzZakladke($usluga, $cms->lang['uslugi'][$usluga]);

			foreach ($kategorie as $id => $dane)
			{
				$kodModulu = $dane['kod_modulu'];
				$tresc = array(
					'poziom' => $dane['poziom'],
					'nazwa' => $dane['nazwa'].' ('.$dane['kod_modulu'].')',
				);
				$rel = $usluga.'_'.$kodModulu.'_'.$id;
				if(count($dane) > 4)
				{
					$tresc['zaznacz_wiele_link'] = array('rel' => $rel);
				}
				$nazwa_kategorii = $this->szablon->parsujBlok('kategoria', $tresc);

				if ($kodModulu == '') continue;
				$this->formularz->input(new Input\Html($usluga.'_'.$kodModulu.'_'.$id, '', array('wartosc' => $nazwa_kategorii)));
				unset($dane['poziom']);
				unset($dane['kod_modulu']);
				unset($dane['nazwa']);

				foreach ($dane as $akcja => $etykieta)
				{
					$kod = $usluga.'_'.$kodModulu.'_'.$id.'_'.$akcja;

					if ($etykieta == '') $etykieta = str_replace('wykonaj', '', $akcja);
					$wartosc = (array_key_exists($kod, $this->zapisaneUprawnienia)) ? 1 : 0;
					$this->formularz->input(new Input\Checkbox($kod, $etykieta, array(
						'wartosc' => $wartosc,
						'atrybuty' => array('class' => $rel),
						)));
				}
			}

			$this->formularz->zamknijZakladke($usluga);
		}

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_wstecz'],
			'atrybuty' => array(
				'onclick' => 'window.location = \'' . $this->urlPowrotny . '\';' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\EdycjaTresc
	 */
	public function ustawUprawnienia(Array $uprawnienia)
	{
		$this->uprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\EdycjaTresc
	 */
	public function ustawZapisaneUprawnienia(Array $uprawnienia)
	{
		$this->zapisaneUprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\EdycjaTresc
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}
}