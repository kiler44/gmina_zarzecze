<?php
namespace Generic\Modul\KategorieDrzewo;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;


/**
 * Blok administracyjny wyświetlający drzewo kategorii podstron.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\KategorieDrzewo\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\KategorieDrzewo\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->j->t['index.tytul_modulu']));

		$cms = Cms::inst();
		$u = $cms->profil();

		$mapper = $this->dane()->Kategoria();
		$kategorie = $mapper->pobierzWszystko();

		$drzewo = '';

		if (is_array($kategorie) && count($kategorie) > 0)
		{
			// sprawdzanie wyswietlania dla zablokanych uzytkownikow
			$wyswietlac = false;
			foreach ($kategorie as $kategoria)
			{
				if ($u->maUprawnieniaDo('Admin_'.$kategoria->id.'_wykonajIndex')) $wyswietlac = true;
			}
			if (! $wyswietlac) return;

			$poprzednia = null;
			$licznik_wierszy = 0;
			$ilosc_kategorii = count($kategorie);

			$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStart');

			foreach ($kategorie as $kategoria)
			{
				$klasa_wiersza = ($licznik_wierszy % 2) ? 'nieparzysty' : 'parzysty';
				$klasa_wiersza = ($kategoria->czyWidoczna) ? '' : ' katUkr';
				$licznik_wierszy ++;
				if ($poprzednia instanceof Kategoria\Obiekt)
				{
					if ($poprzednia->poziom < $kategoria->poziom)
					{
						if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('/drzewo/listaStart');
					}
					elseif ($poprzednia->poziom == $kategoria->poziom)
					{
						if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
					}
					elseif ($poprzednia->poziom > $kategoria->poziom)
					{
						$maks = (int)($poprzednia->poziom - $kategoria->poziom);
						$i = 0;
						while ($i < $maks)
						{
							$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
							$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
							$i++;
						}
						$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
					}
					switch ($kategoria->typ)
					{
						case 'glowna':

						case 'kategoria':
							$url = Router::urlAdmin($kategoria);
							break;

						case 'link_wewnetrzny':

						case 'link_zewnetrzny':

						default:
							$url = '';
							break;
					}

					// niekomplatne kategrie
					if ($kategoria->kodModulu == '') $url = '';

					// obsluga uprawnien
					$kodUprawnienia = 'Admin_'.$kategoria->id.'_wykonajIndex';
					if ( ! $cms->profil()->maUprawnieniaDo($kodUprawnienia)) $url = '';

					$poziom = $kategoria->poziom;

					$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStart', array(
						'poziom' => $poziom,
						'klasa' => $klasa_wiersza,
					));
					if ($url != '')
					{
						$drzewo .= $this->szablon->parsujBlok('/drzewo/elementTrescLink', array(
							'poziom' => $poziom,
							'klasa' => $klasa_wiersza,
							'url' => htmlspecialchars($url),
							'nazwa' => ($kategoria->nazwaPrzyjazna != '') ? $kategoria->nazwaPrzyjazna : $kategoria->nazwa,
							'nazwaPelna' => ($kategoria->rodzic->nazwaPrzyjazna != '' ? $kategoria->rodzic->nazwaPrzyjazna : $kategoria->rodzic->nazwa) . ' - ' . (($kategoria->nazwaPrzyjazna != '') ? $kategoria->nazwaPrzyjazna : $kategoria->nazwa),
						));
					}
					else
					{
						$drzewo .= $this->szablon->parsujBlok('/drzewo/elementTresc', array(
							'poziom' => $poziom,
							'klasa' => $klasa_wiersza,
							'nazwa' => $kategoria->nazwa,
							'nazwaPelna' => $kategoria->rodzic->nazwa . ' - ' . $kategoria->nazwa,
						));
					}
				}
				$poprzednia = clone $kategoria;
			}
			unset($kategorie);
			$maks = (int)($poprzednia->poziom - 1);
			$i = 0;
			while ($i <= $maks)
			{
				$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
				$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
				$i++;
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/index',array('drzewo' => $drzewo));
	}



	/**
	 *  Przeciazona metoda z klasy Modul. Zwraca true bo zawsze chcemy wyswietlac ten blok
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 *
	 * @return bool True.
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		return true;
	}

}
