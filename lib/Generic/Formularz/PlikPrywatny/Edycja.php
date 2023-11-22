<?php
namespace Generic\Formularz\PlikPrywatny;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array
	 */
	protected $wszystkieRole;


	/**
	 * @var Array
	 */
	protected $wszyscyUzytkownicy;


	protected function generujFormularz()
	{
		$powiazaneRole = array();
		$pliki_role = Cms::inst()->dane()->PlikPrywatnyRolaPowiazanie()->zwracaTablice()->pobierzPoPliku($this->obiekt['id']);
		if(is_array($pliki_role))
		{
			foreach($pliki_role as $pr)
			{
				$powiazaneRole[] = $pr['id_roli'];
			}
		}

		$powiazaniUzytkownicy = array();
		$pliki_uzytkownik = Cms::inst()->dane()->PlikPrywatnyUzytkownikPowiazanie()->zwracaTablice()->pobierzPoPliku($this->obiekt['id']);
		if (is_array($pliki_uzytkownik))
		{
			foreach($pliki_uzytkownik as $pu)
			{
				$powiazaniUzytkownicy[] = $pu['id_uzytkownika'];
			}
		}

		$this->formularz = new Formularz('', 'uprawnienia');

		$this->formularz->input(new Input\Html('plik', $this->tlumaczenia['etykieta_input_plik'], array(
			'wartosc' => $this->obiekt['url'],
		), $this->tlumaczenia['opis_input_plik']));

		if (count($this->wszyscyUzytkownicy) > 0)
		{
			$this->formularz->otworzZakladke('uzytkownicy',$this->tlumaczenia['zakladka_uzytkownicy']);

			$this->formularz->input(new Input\AutocompleteLista('uzytkownicy', $this->tlumaczenia['etykieta_input_uzytkownicy'], array(
				'lista' => $this->wszyscyUzytkownicy,
				'wartosc' => $powiazaniUzytkownicy
			), $this->tlumaczenia['opis_input_uzytkownicy']));

			$this->formularz->zamknijZakladke('uzytkownicy');
		}
		if (count($this->wszystkieRole) > 0)
		{
			$this->formularz->otworzZakladke('role',$this->tlumaczenia['zakladka_role']);

			$this->formularz->input(new Input\MultiCheckbox('role', $this->tlumaczenia['etykieta_input_role'], array(
				'lista' => $this->wszystkieRole,
				'wartosc' => $powiazaneRole,
			), $this->tlumaczenia['opis_input_role']));

			$this->formularz->zamknijZakladke('role');
		}


		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\PlikPrywatny\Edycja
	 */
	public function ustawWszyscyUzytkownicy(Array $uzytkownicy)
	{
		$this->wszyscyUzytkownicy = $uzytkownicy;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\PlikPrywatny\Edycja
	 */
	public function ustawWszystkieRole(Array $role)
	{
		$this->wszystkieRole = $role;

		return $this;
	}
}