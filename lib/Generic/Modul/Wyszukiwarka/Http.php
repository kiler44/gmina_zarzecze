<?php
namespace Generic\Modul\Wyszukiwarka;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Aktualnosc;
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
        $akcja = Zadanie::pobierz('url_parametr_0', 'strval');

        switch($akcja)
        {
            case 'wyszukiwarka':
                $this->wykonajAkcje('wyszukiwarka');
                break;
            default:
                $this->wykonajAkcje('wyszukiwarka');
                break;
        }
    }

	public function wykonajWyszukiwarka()
	{

        $fraza = $this->pobierzParametr('fraza', null, true, ['strval']);
        $gdzieSzukac = $this->pobierzParametr('gdzie', null, true, ['intval']);

        if($fraza != '')
        {
            $this->szablon->ustawBlok('index/naglowek', ['fraza' => $fraza,]);

            $aktualnosciKryteria['fraza'] = trim($fraza);
            $aktualnosciKryteria['publikuj'] = 1;

            $wyszukiwarkaSql = new Wyszukiwarka\Sql();
            $wyszukiwarka = new Wyszukiwarka\Wyszukiwarka($wyszukiwarkaSql);

            if($gdzieSzukac > 0)
            {
                $kategoriaMapper = $this->dane()->Kategoria();
                $aktualnosciKryteria['id_kategorii'] = $gdzieSzukac;
                $kat = $kategoriaMapper->pobierzPoId($gdzieSzukac);
                $info =  str_replace('{KATEGORIA}', $kat->nazwa, $this->j->t['wyniki_kategoria']);

                $sortowanie = explode('.', $this->k->k['listaWynikow.sortowanie']);
                $sorter = new Aktualnosc\Sorter($sortowanie[0], $sortowanie[1]);
                $tabela = new Tabela\Aktualnosc($sorter);
                $tabela->ustawKryteria($aktualnosciKryteria);
            }
            else
            {
                $tabela = new Tabela\Baza();
                $tabela->ustawKryteria(['fraza' => $fraza, 'publikuj' => 1]);
                $info =  $this->j->t['lista_wynikow'];
            }

            $wyszukiwarka->ustawTabele($tabela);

            $nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
            $naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['listaWynikow.wierszy_na_stronie'], false, array('intval','abs'));

            $ilosc = $tabela->pobierzIlosc();

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['listaWynikow.pager']);
            $pager->ustawTlumaczenia($this->j->t['listaWynikow.pager']);
            $pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);

            $tabela->ustawPager($pager);

            $listaWynikow = $wyszukiwarka->pobierzWyniki();

            /**
             * @var Wyszukiwarka\Wynik $wpis
             */
            if(count($listaWynikow) > 0)
            {

                foreach ($listaWynikow as $wpis)
                {
                    $this->szablon->ustawBlok('index/wynik', [
                        'tytul' => $wpis->tytul,
                        'data' => $wpis->data,
                        'tresc' => str_cut($wpis->tresc, 250, true),
                        'link' => $wpis->link,
                        'kategoria' => $wpis->kategoria,
                        'url_zdjecia' => $wpis->zdjecie
                    ]);
                }
            }
            else
                $info = str_replace('{FRAZA}', $fraza, $this->j->t['brak_wynikow']);


            $this->szablon->ustawBlok('index/pagerSekcja', [
                'pager' => $pager->html(Router::urlHttp($this->kategoria, array('', '{NR_STRONY}', '{NA_STRONIE}')))
            ]);
        }
        else
            $this->komunikat($this->j->t['index.brak_frazy'], 'info');

        $this->tresc .= $this->szablon->parsujBlok('index', ['info' => $info]);
	} 
}
