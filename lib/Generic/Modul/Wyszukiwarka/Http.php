<?php
namespace Generic\Modul\Wyszukiwarka;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;
use Generic\Model\Aktualnosc;
use Generic\Model\StronaOpisowa;
use \Generic\Biblioteka\Wyszukiwarka\Tabela;
use Generic\Biblioteka\Wyszukiwarka;

/**
 * Moduł odpowiedzialny za wyswietlenie wyników wyszukiwania
 *
 * @author Marcin Mucha
 * @package moduly
 */

class Http extends Modul\Http
{

	protected $uprawnienia = array(
		'wykonajIndex',
		
	);


	/**
	 * @var \Generic\Konfiguracja\Modul\WidokPoczatkowy\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\WidokPoczatkowy\Http
	 */
	protected $j;


	
	public function wykonajIndex()
	{

        $fraza = $this->pobierzParametr('fraza', null, true, ['strval']);
        $gdzieSzukac = $this->pobierzParametr('gdzie', null, true, ['intval']);

        if($fraza != '')
        {
            $this->szablon->ustawBlok('index/naglowek', ['fraza' => $fraza,]);

            $aktualnosciKryteria['fraza'] = $fraza;
            $aktualnosciKryteria['publikuj'] = 1;

            if($gdzieSzukac > 0)
                $aktualnosciKryteria['id_kategorii'] = $gdzieSzukac;
            else
            {
                $wyszukiwarkaSql = new Wyszukiwarka\Sql();
                $wyszukiwarka = new Wyszukiwarka\Wyszukiwarka($wyszukiwarkaSql);
                $stronaOpisowa = new Tabela\StronaOpisowa();
                $stronaOpisowa->ustawKryteria(['fraza' => $fraza]);

                $wyszukiwarka->ustawTabele($stronaOpisowa);
                $iloscStrony = $wyszukiwarka->pobierzIlosc();
                $strony = $wyszukiwarka->pobierzWyniki();
                /**
                 * @var Wyszukiwarka\Wynik $strona
                 */
                if($iloscStrony > 0)
                {
                    foreach ($strony as $strona)
                        $this->szablon->ustawBlok('index/wynik',
                            [
                                'tytul' => $strona->tytul,
                                'data' => $strona->data,
                                'tresc' => str_cut($strona->tresc, 250, true),
                                'link' => $strona->link,
                                'kategoria' => $strona->kategoria
                            ]
                        );
                }
            }

            $wyszukiwarkaSql = new Wyszukiwarka\Sql();
            $wyszukiwarka = new Wyszukiwarka\Wyszukiwarka($wyszukiwarkaSql);

            $sortowanie = explode('.', $this->k->k['listaWynikow.sortowanie']);
            $sorter = new Aktualnosc\Sorter($sortowanie[0], $sortowanie[1]);

            $nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
            $naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['listaWynikow.wierszy_na_stronie'], false, array('intval','abs'));

            $aktualnosci = new Tabela\Aktualnosc($sorter);
            $aktualnosci->ustawKryteria($aktualnosciKryteria);

            $wyszukiwarka->ustawTabele($aktualnosci);

            $iloscAktualnosci = $wyszukiwarka->pobierzIlosc();

            $pager = new Pager\Html($iloscAktualnosci, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['listaWynikow.pager']);
            $pager->ustawTlumaczenia($this->j->t['listaWynikow.pager']);
            $pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);
            $aktualnosci->ustawPager($pager);

            $aktualnosciLista = $wyszukiwarka->pobierzWyniki();

            /*
            $maperAktualnosci = new Aktualnosc\Mapper();
            $kategoriaMapper = Cms::inst()->dane()->Kategoria();
            $iloscAktualnosci = $maperAktualnosci->iloscSzukaj(['fraza' => $fraza, ]);

            $nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
            $naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['listaWynikow.wierszy_na_stronie'], false, array('intval','abs'));

            $pager = new Pager\Html($iloscAktualnosci, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['listaWynikow.pager']);
            $pager->ustawTlumaczenia($this->j->t['listaWynikow.pager']);
            $pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);

            $sortowanie = explode('.', $this->k->k['listaWynikow.sortowanie']);

            $sorter = new Aktualnosc\Sorter($sortowanie[0], $sortowanie[1]);

            $aktualnosci = $maperAktualnosci->szukaj($aktualnosciKryteria, $pager, $sorter);
            $kategorieAktualnosci = [];
            */
            /**
             * @var Aktualnosc\Obiekt $aktualnosc
             */
            if($iloscAktualnosci > 0)
            {
                foreach ($aktualnosciLista as $aktualnosc)
                {

                    $this->szablon->ustawBlok('index/wynik', [
                        'tytul' => $aktualnosc->tytul,
                        'data' => $aktualnosc->data,
                        'tresc' => str_cut($aktualnosc->tresc, 250, true),
                        'link' => $aktualnosc->link,
                        'kategoria' => $aktualnosc->kategoria
                    ]);
                }
            }

            $this->szablon->ustawBlok('index/pagerSekcja', [
                'pager' => $pager->html(Router::urlHttp($this->kategoria, array('', '{NR_STRONY}', '{NA_STRONIE}')))
            ]);

            if($iloscStrony == 0 && $iloscAktualnosci == 0)
                $info = str_replace($this->j->t['brak_wynikow'], '{FRAZA}', $fraza);

        }
        else
            $this->komunikat($this->j->t['index.brak_frazy'], 'info');

        $this->tresc .= $this->szablon->parsujBlok('index', ['info' => $info]);
	} 
}
