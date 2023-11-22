<?php

namespace Generic\Biblioteka\Kreator\KreatorBaza;

use Generic\Biblioteka\Kreator;

/**
 * Pozwala wygenerować kog PHP klasy Obiekt.
 */
class Obiekt extends Kreator\KreatorBaza
{

	/**
	 * Zawiera opisy property
	 * @var array nazwa - opis property
	 */
	private $opisyPol = array();

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->polacz();
		$this->nazwaGenerowanegoPliku = 'Obiekt.php';
		$this->nazwaPlikuSzablonu = 'szablon_obiekt.tpl';
	}



	/**
	 * Generuje kod PHP klasy Obiekt dla podanej tabeli.
	 * @param string $nazwaTabeli
	 * @return boolean
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		if (!$this->inicjuj($nazwaTabeli))
		{
			return false;
		}

		$komentarze = $this->odczytajKomentarzeObiektu();
		$noweKomentarze = array();
		foreach ($this->opisKolumnTabeli as $opisKolumny)
		{
			$typ = $this->poprawTypDlaPHPDoc($opisKolumny['typ']);
         $nazwa = $this->konwertujNaWielblada($opisKolumny['nazwa'], false);
			$this->szablon->ustawBlok('/KOMENTARZ', array(
				'TYP' => $typ,
				'NAZWA' => $nazwa,
				'KOMENTARZ' => isset($this->opisyPol[$nazwa]) ? $this->opisyPol[$nazwa] : '',
			));
			$noweKomentarze[$nazwa] = $typ;
		}

		$niepewneKlucze = array_map('trim', array_diff_key(array_keys($komentarze), array_keys($noweKomentarze)));

		foreach ($komentarze as $nazwa => $typ)
		{
			$nazwa = trim($nazwa);
			if (in_array($nazwa, $niepewneKlucze))
			{
				$this->szablon->ustawBlok('/KOMENTARZ', array(
					'TYP' => $typ,
					'NAZWA' => $nazwa,
					'KOMENTARZ' => $this->opisyPol[$nazwa] . '//TODO: - tego pola nie ma w bazie',
				));
			}
		}

		$wygenerowanyKodObiektu = $this->szablon->parsujBlok('/', array(
			'NAZWA' => $this->nazwaObiektuModelu,
				));
		return $this->zapiszKodDoPliku($nazwaUzytkownika, $this->katalogModel, $this->nazwaGenerowanegoPliku, $wygenerowanyKodObiektu);
	}



	public function pokazPodsumowanie()
	{
		return $this->pobierzLog();
	}



	/**
	 *
	 * @return array - nazwa pola - typ pola
	 */
	private function odczytajKomentarzeObiektu()
	{
		$sciezkaDoObiektu = $this->katalogModel . '/' . $this->nazwaObiektuModelu . '/' . $this->nazwaGenerowanegoPliku;
		if (!file_exists($sciezkaDoObiektu))
		{
			return array();
		}

		$tokeny = token_get_all(file_get_contents($sciezkaDoObiektu));

		$komentarze = array();
		foreach ($tokeny as $token)
		{
			if ($token[0] == T_DOC_COMMENT)
			{
				$komentarze[] = $token[1];
			}
		}

		$komentarzKlasy = $komentarze[0];
		$znakiDoUsuniecia = array('@property,', '@property-read,', '@property-write', ',', ' *', '*', '/', '"', 'show', 'off', '$', '-', '  ',);
		foreach ($znakiDoUsuniecia as $znak)
		{
			$komentarzKlasy = str_replace($znak, '', $komentarzKlasy);
		}
		$komentarze = explode('@', $komentarzKlasy);
		$komentarzePol = array();
		foreach ($komentarze as $komentarz)
		{
			if (stristr($komentarz, 'property') != false)
			{
				$komentarz = str_replace('property', '', $komentarz);
				list($smiec1, $typ, $nazwa) = explode(' ', $komentarz);
				$skladnikiKomentarza = explode(' ', $komentarz);
				$opis = '';
				if (count($skladnikiKomentarza) > 3)
				{
					for ($i = 3; $i < count($skladnikiKomentarza); $i++)
					{
						$opis .= $skladnikiKomentarza[$i] . ' ';
					}
				}
				$this->opisyPol[trim($nazwa)] = trim($opis);
				$komentarzePol[$nazwa] = $typ;
			}
		}
		return $komentarzePol;
	}



}