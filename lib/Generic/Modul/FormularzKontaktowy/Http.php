<?php
namespace Generic\Modul\FormularzKontaktowy;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Model\FormularzKontaktowyWiadomosc;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Router;


/**
 * Modul odpowiadajacy za wyświetlanie formularza kontaktowego z tematami.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\FormularzKontaktowy\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\FormularzKontaktowy\Http
	 */
	protected $j;


	protected $lista_pol = array(
		'imie' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 50)),
		'nazwisko' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 50)),
		'firmaNazwa' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 128)),
		'nadawca' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 128)),
		'stronaWWW' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 128)),
		'skype' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 128)),
		'telefon' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 15)),
		'komorka' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 15)),
		'fax' => array('klasa'=> 'Input_Text', 'atrybuty' => array('maxlength' => 15)),
		'tresc' => array('klasa'=> 'Input_TextArea', 'atrybuty' => array('maxlength' => 2000)),
		'daneOsobowe' => array('klasa'=> 'Input_CheckboxOpis', 'atrybuty' => array()),
	);


	protected $szablonFormularza;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajFormularz',
	);

	protected $zdarzenia = array(
		'wyslanie_maila',
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->szablonFormularza = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']);

		$this->wykonajAkcje('formularz');
	}



	public function wykonajFormularz()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->kategoria->nazwa,
			'tytul_modulu' => $this->kategoria->tytulStrony,// $this->j->t['index.tytul_modulu'],
		));

		$mapper = $this->dane()->FormularzKontaktowyTemat();
		$tematy = array();
		if($this->k->k['formularz.wiele_tematow'])
		{
			$tematy = $mapper->pobierzDlaKategorii($this->kategoria->id, null, null);
		}
		else
		{
			$tematy[] = $mapper->pobierzPoId(1);
		}
        $obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\Http();
		$obiektFormularza->ustawTematy($tematy)
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawKonfiguracje(array(
				'wiele_tematow' => $this->k->k['formularz.wiele_tematow'],
				'dane_osobowe_tresc' => $this->k->k['formularz.dane_osobowe_tresc'],
                'czy_button_wstecz' =>$this->k->k['formularz.czy_button_wstecz']
			))
			->ustawListaPol($this->lista_pol);

		if ($obiektFormularza->wypelniony())
		{
			$zapisz = Zadanie::pobierz('zapisz', 'trim');
			if ($zapisz !== null)
			{
				if ($obiektFormularza->danePoprawne())
				{
					$dane = $obiektFormularza->pobierzWartosci();
					$this->zapiszWiadomosc($dane);
				}
				else
				{
					$this->komunikat($this->j->t['formularz.warning_formularz_niewypelniony'], 'warning', 'modul', 'expose');
				}
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'tekst_przed_formularzem' => $this->k->k['formularz.tekst_przed_formularzem'],
			'formularz' => $obiektFormularza->html($this->szablonFormularza, true),
			'tekst_za_formularzem' => $this->k->k['formularz.tekst_za_formularzem'],
		));
	}



	private function zapiszWiadomosc($dane)
	{
		$cms = Cms::inst();

		$obiektDanych = new FormularzKontaktowyWiadomosc\Obiekt();
		$obiektDanych->idProjektu = ID_PROJEKTU;
		$obiektDanych->kodJezyka = KOD_JEZYKA;
		$obiektDanych->idKategorii = ID_KATEGORII;
		$obiektDanych->dataWyslania = date("Y-m-d H:i:s");
		$obiektDanych->idUzytkownika = ($cms->profil() instanceof Uzytkownik\Obiekt) ? $cms->profil()->id : null;

		if(!in_array('idTematu', $dane))
		{
			$obiektDanych->idTematu = 1;
		}

		$tresc = '';
		$tresc_html = '';
		foreach ($dane as $pole => $wartosc)
		{
            if ($pole == 'nadawca') {
                $dane['email'] = $wartosc;
                $obiektDanych->email = $wartosc;
            }
			if ($pole == 'daneOsobowe' || $pole == '_spacer_') continue;
			$obiektDanych->$pole = $wartosc;

			if ($pole == 'idTematu') continue;

			$tresc .= $pole.': '.$wartosc."\n";
			$tresc_html .= $pole.': '.$wartosc.'<br/>';
		}

		$temat_formularza = $this->dane()->FormularzKontaktowyTemat()->pobierzPoId($obiektDanych->idTematu);

		if ($obiektDanych->zapisz($this->dane()->FormularzKontaktowyWiadomosc()))
		{
			$odbiorcy = unserialize($temat_formularza->email);
			if (count($odbiorcy))
			{
				$poczta = new Pomocnik\Poczta();
				$poczta->wczytajUstawienia(array(
					'przygotujWiadomosc' => false,
					'emailOdbiorcy' => $odbiorcy,
					'emailKopie' => unserialize($temat_formularza->emailDw),
					'emailTytul' => $temat_formularza->temat,
					'emailTrescHtml' => $tresc_html,
					'emailTrescTxt' => $tresc,
				));
				$status = $poczta->wyslij();

				$this->zdarzenie('wyslanie_maila', array(
					'status' => ($status) ? true : false,
					'opis' => ($status) ? $this->j->t['formularz.info_zapisano_waidomosc'] : $this->j->t['formularz.error_zapisano_waidomosc'],
				));
			}
			$this->komunikat($this->j->t['formularz.info_zapisano_waidomosc'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['formularz.error_zapisano_waidomosc'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlHttp($this->kategoria, array('index')));
	}
}
