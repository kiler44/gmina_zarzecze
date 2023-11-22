<?php
namespace Generic\Modul\BlokKontoUzytkownika;
use Generic\Biblioteka\Modul;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;


/**
 * Blok odpowiedzialny za wyświetlanie formularza logowania lub podsumowania konta uzytkownika.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokKontoUzytkownika\Http
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokKontoUzytkownika\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->j->t['index.tytul_strony']));

		$kategorieMapper = $this->dane()->Kategoria();
		$kategorie = $kategorieMapper->pobierzDlaModulu('KontoUzytkownika');

		if (isset($kategorie[0]) && $kategorie[0] instanceof Kategoria\Obiekt)
		{
			$kategoria = $kategorie[0];
			unset($kategorie);
		}
		else
		{
			trigger_error('Brak modulu KontoUzytkownika w kategoriach serwisu.', E_USER_WARNING);
			return;
		}
		$dane = array();
		$dane['link_logowanie'] = Router::urlHttp($kategoria, array('zaloguj'));
		$dane['link_wylogowanie'] = Router::urlHttp($kategoria, array('wyloguj'));
		$dane['link_przypomnienie'] = Router::urlHttp($kategoria, array('przypomnij_haslo'));
		$dane['link_konto_uzytkownika'] = Router::urlHttp($kategoria);
		$dane['link_rejestracja'] = '';

		$dane['link_logowanie_seo'] = strToHex($dane['link_logowanie']);
		$dane['link_wylogowanie_seo'] = strToHex($dane['link_wylogowanie']);
		$dane['link_przypomnienie_seo'] = strToHex($dane['link_przypomnienie']);
		$dane['link_konto_uzytkownika_seo'] = strToHex($dane['link_konto_uzytkownika']);


		$kategorie = $kategorieMapper->pobierzDlaModulu('RejestracjaNowa');

		if (isset($kategorie[0]) && $kategorie[0] instanceof Kategoria\Obiekt)
		{
			$dane['link_rejestracja'] = Router::urlHttp($kategorie[0], array('firma'));
			$dane['link_rejestracja_seo'] = strToHex($dane['link_rejestracja']);
		}

		$cms = Cms::inst();
		if ($cms->profil() instanceof Uzytkownik\Obiekt)
		{
			$trescBloku = $this->k->k['index.tresc_zalogowany'];

			if ($trescBloku != '')
			{
				if ($cms->profil('pracownikBok') instanceof Uzytkownik\Obiekt)
				{
					$this->szablon->ustawBlok('zalogowany/pracownik_bok', array('dane_pracownik' => $cms->profil('pracownikBok')->nazwaOrazLogin));
				}
				$tresc['tresc'] = strtr($trescBloku, array(
					'{link_konto_uzytkownika}' => $dane['link_konto_uzytkownika'],
					'{nazwa_uzytkownika}' => $cms->profil()->nazwaOrazLogin,
					'{link_wylogowanie}' => $dane['link_wylogowanie'],
				));
				$this->tresc .= $this->szablon->parsujBlok('zalogowany', $tresc);
			}
		}
		else
		{
			if ($this->k->k['index.wyswietlac_formularz'] == 1)
			{
				$this->wyswietlFormularz($dane);
			}
			else
			{
				$trescBloku = $this->k->k['index.tresc_zamiast_formularza'];

				foreach ($dane as $klucz => $wartosc)
				{
					$trescBloku = str_replace('{'.$klucz.'}', $wartosc, $trescBloku);
				}
				$this->tresc .= $trescBloku;
			}
		}
	}



	protected function wyswietlFormularz($dane)
	{
		$cms = Cms::inst();

		if (!isset($cms->sesja->proby_logowania)) $cms->sesja->proby_logowania = 0;
		if (!isset($cms->sesja->proby_logowania_blokada_do)) $cms->sesja->proby_logowania_blokada_do = 0;

		if (isset($cms->sesja->proby_logowania_blokada_do)
			&& $cms->sesja->proby_logowania_blokada_do > date('U'))
		{
			$this->komunikat($this->j->t['index.blad_przekroczono_limit'], 'error');
		}
		else
		{
			$formularzObiekt = new \Generic\Formularz\Uzytkownik\Logowanie();
			$formularzObiekt->ustawLinkLogowanie($dane['link_logowanie'])
				->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('index'));

			$dane['formularz'] = $formularzObiekt->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']), true);
			$this->tresc .= $this->szablon->parsujBlok('formularzLogowania', $dane);
		}
	}
}
