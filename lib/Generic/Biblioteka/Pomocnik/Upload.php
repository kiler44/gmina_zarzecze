<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;


/**
 * Obsluguje operacje upload na plikach.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Upload
{

	/**
	 * Metoda wspomagajaca upload plikow z formularza
	 *
	 * @param array $uploadPlik Tablica odwzorowujaca plik w tablicy uploadu $_FILES
	 * @param Katalog $katalogDocelowy Katalog docelowy do ktorego ma zostac wgrany plik
	 * @param array $miniatury Tablica zawierajaca prefixy i kody tworzonych miniatur
	 * @param array $ustawienia Tablica zawierajaca dodatkowe ustawienia dla przenoszonych zdjec
	 * Dostepne ustawienia:
	 * 'nowa_nazwa' => '',			- tekst ktory bedzie nowa nazwa pliku
	 * 'unifikuj_nazwe' => true,	- dostosowanie nazwy pliku do wymogow www
	 * 'dlugosc_nazwy' => 50,		- maksymalna dlugosc nazwy pliku
	 * 'tylko_miniatury' => false,	- czy po utworzeniu miniatur usunac oryginal
	 *
	 * @return string
	 */
	public static function wgrajPlik(Array $uploadPlik, $katalogDocelowy, Array $miniatury = array(), Array $ustawienia = array())
	{
		$ustawieniaDomyslne = array(
			'nowa_nazwa' => '',
			'unifikuj_nazwe' => true,
			'dlugosc_nazwy' => 50,
			'tylko_miniatury' => false,
		);
		$ustawienia = array_replace($ustawieniaDomyslne, $ustawienia);

		if ( !(is_array($uploadPlik) && isset($uploadPlik['error']) && $uploadPlik['error'] === UPLOAD_ERR_OK))
		{
			return false;
		}

		$katalogDocelowy = new Katalog($katalogDocelowy, true);
		if ( ! $katalogDocelowy->doZapisu())
		{
			trigger_error('Brak mozliwości zapisu w katalogu docelowym '.$katalogDocelowy, E_USER_WARNING);
			return false;
		}

		$plikDocelowy = pathinfo($uploadPlik['name']);

		$ustawienia['nowa_nazwa'] = trim($ustawienia['nowa_nazwa']);
		if (strlen($ustawienia['nowa_nazwa']) > 0)
		{
			$plikDocelowy['filename'] = $ustawienia['nowa_nazwa'];
		}
		if ((int)$ustawienia['dlugosc_nazwy'] > 1)
		{
			$plikDocelowy['filename'] = str_cut($plikDocelowy['filename'], (int)$ustawienia['dlugosc_nazwy']);
		}

		$plikDocelowy = $plikDocelowy['filename'].((isset($plikDocelowy['extension'])) ? '.'.$plikDocelowy['extension'] : '');

		if ($ustawienia['unifikuj_nazwe'])
		{
			$plikDocelowy = Plik::unifikujNazwe($plikDocelowy);
		}

		if (false === move_uploaded_file($uploadPlik['tmp_name'], $katalogDocelowy.'/'.$plikDocelowy))
		{
			trigger_error('Nie mozna przeniesc pliku '.$uploadPlik['tmp_name'].' do katalogu '.$katalogDocelowy.'/'.$plikDocelowy, E_USER_WARNING);
			return false;
		}

		$zdjecie = new Plik\Zdjecie($katalogDocelowy.'/'.$plikDocelowy);
		$miniaturkaZastepujeOryginal = false;
		$utworzonoMiniatur = 0;
		foreach ($miniatury as $prefix => $opisMiniatury)
		{
			if ($prefix != '')
			{
				$prefix = $prefix.'-';
			}
			else
			{
				$miniaturkaZastepujeOryginal = true;
				$prefix = '';
			}
			$nazwaMiniatury = $katalogDocelowy.'/'.$prefix.$plikDocelowy;

			$miniatura = $zdjecie->tworzMiniaturke($nazwaMiniatury, $opisMiniatury);

			if ($miniatura instanceof Plik\Zdjecie)
			{
				$utworzonoMiniatur++;
			}
			else
			{
				if ($miniaturkaZastepujeOryginal) $miniaturkaZastepujeOryginal = false;
				trigger_error('Nie mozna utworzyc pliku miniatury '.$nazwaMiniatury, E_USER_WARNING);
			}
		}

		if ($ustawienia['tylko_miniatury'] && $utworzonoMiniatur > 0 && ! $miniaturkaZastepujeOryginal)
		{
			if ( ! $zdjecie->usun())
			{
				trigger_error('Nie mozna usunac orginalnego pliku '.$zdjecie, E_USER_WARNING);
			}
		}
		return $plikDocelowy;
	}

}

?>
