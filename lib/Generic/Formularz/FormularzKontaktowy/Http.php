<?php
namespace Generic\Formularz\FormularzKontaktowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;

class Http extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var array
	 */
	protected $tematy;

	/**
	 * @var array
	 */
	protected $listaPol;

	
	protected function generujFormularz()
	{
		$wybrany_temat = Zadanie::pobierz('idTematu','intval','abs');

		if ($wybrany_temat < 1) $wybrany_temat = 1;

		$this->formularz = new Formularz('', 'regForm');
		if (count($this->tematy) > 0)
		{
			foreach($this->tematy as $temat)
			{
				$lista[$temat->id] = $temat->temat;

				$ostatnia_konfiguracja = unserialize($temat->konfiguracja);
				$ostatnie_id_tematu = $temat->id;

				if($temat->id == $wybrany_temat)
				{
					$konfiguracja = unserialize($temat->konfiguracja);
				}
			}

			if (count($this->tematy) > 1 && $this->konfiguracja['wiele_tematow'])
			{
				$this->formularz->input(new Input\Select('idTematu', $this->tlumaczenia['etykieta_input_tematy'], array(
					'lista' => $lista,
					'atrybuty' => array(
						'onchange' => 'this.form.submit();',
					),
					'wartosc' => '',
				)));
			}
			else
			{
				$konfiguracja = $ostatnia_konfiguracja;
				$this->formularz->input(new Input\Hidden('idTematu', $ostatnie_id_tematu));
			}
		}

		foreach($this->listaPol as $nazwa => $ustawieniePola)
		{
			if (isset($konfiguracja[$nazwa]))
			{
				$ustawienia = array(
					'wymagany' => ($konfiguracja[$nazwa] == 2) ? true : false,
					'atrybuty' => $ustawieniePola['atrybuty'],
				);

				if ($nazwa == 'daneOsobowe') $ustawienia['opis'] = $this->konfiguracja['dane_osobowe_tresc'];

				$klasa = '\\Generic\\Biblioteka\\' . str_replace('_', '\\', $ustawieniePola['klasa']);

				$this->formularz->input(new $klasa($nazwa, $this->tlumaczenia['etykieta_input_'.$nazwa], $ustawienia));
				$this->formularz->$nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

				if ($konfiguracja[$nazwa] == 2)
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\NiePuste());
				}
				if ($nazwa == 'nadawca')
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\Email());
				}
				if ($nazwa == 'stronaWWW')
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\Url());
				}
				if ($nazwa == 'telefon' || $nazwa == 'komorka' || $nazwa == 'fax')
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\Telefon());
				}
				if ($nazwa == 'gg')
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\LiczbaCalkowita());
				}
			}
		}
		$this->formularz->stopka(new Input\Submit('zapisz', '&nbsp;', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz'],
			'atrybuty' => array('class' => 'buttonSet buttonRed'),
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '&nbsp;', array(
			'wartosc' => $this->tlumaczenia['etykieta_reset'],
			'typ' => 'reset',
			'atrybuty' => array('class' => 'buttonSet buttonLight'),
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\FormularzKontaktowy\Wyszukiwanie
	 */
	public function ustawTematy(Array $tematy)
	{
		$this->tematy = $tematy;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\FormularzKontaktowy\Podglad
	 */
	public function ustawListaPol(Array $listaPol)
	{
		$this->listaPol = $listaPol;

		return $this;
	}
}