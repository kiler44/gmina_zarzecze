<?php
namespace Generic\Modul\BlokWyszukiwarki;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Okruszki;
use Generic\Biblioteka\Router;
use Generic\Model\Kategoria;


/**
 * Wyswietlanie sciezki do danej kategorii.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokWyszukiwarki\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokWyszukiwarki\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$mapper = $this->dane()->Kategoria();
		$opcje = $mapper->pobierzGalaz($this->k->k['id_kategorii_select_gdzie_szukaj']);

		$kategoriaWynikow = $mapper->pobierzDlaModulu('Wyszukiwarka');
		if(isset($kategoriaWynikow[0]) && $kategoriaWynikow[0] instanceof Kategoria\Obiekt)
        {
            $urlAkcjaWyszukiwarki = Router::urlHttp($kategoriaWynikow[0]);

            if (count($opcje) > 0)
            {
                /**
                 * @var Kategoria\Obiekt $opcja
                 */
                foreach ($opcje as $opcja)
                    $this->szablon->ustawBlok('/index/opcja', array('wartosc' => $opcja->id, 'etykieta' => $opcja->nazwa));

                $this->tresc .= $this->szablon->parsujBlok('/index', [
                    'akcjaWyszukiwarki' => $urlAkcjaWyszukiwarki,
                    'placeholder_szukaj' => $this->j->t['placeholder_szukaj'],
                    'placeholder_gdzie_szukac' => $this->j->t['placeholder_gdzie_szukac'],
                    'szukaj_button' => $this->j->t['szukaj_button'],
                    'czytaj_wiecej_input' => $this->j->t['czytaj_wiecej_input'],
                ]);
            }
            else
            {
                $this->komunikat($this->j->t['index.blad_brak_kategorii'], 'info');
            }
        }
		else
            $this->komunikat('Brak modulu z wynikami wyszukiwania', 'info');

	}

}


