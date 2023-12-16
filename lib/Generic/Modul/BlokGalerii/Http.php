<?php
namespace Generic\Modul\BlokGalerii;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Model\Galeria;
use Generic\Biblioteka\Pager;


/**
 * Blok odpowiadajacy za wyświetlanie dodatkowej treści opisowej na stronie.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokGalerii\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokGalerii\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
        $mapper = $this->dane()->Galeria();
        $maperKategoria = $this->dane()->Kategoria();
        $galeriaKategoria = $maperKategoria->pobierzDlaModulu('Galeria');
        $dzieci = $maperKategoria->zwracaTablice(['id', 'nazwa', 'czy_widoczna'])->pobierzGalaz($galeriaKategoria[0]->id);

        if(count($dzieci) > 1)
        {
            $idKategorii = array_keys(listaZTablicy($dzieci, 'id', 'nazwa'));

            $ilosc = $mapper->iloscWszystkoOpublikowane(['id_kategorii' => $idKategorii]);
            $sorter = new Galeria\Sorter('data_dodania');
            $pager = new Pager\Html($ilosc, $this->k->k['max_ilosc_galerii'], 1);
            $listaGalerii = $mapper->pobierzWszystkoOpublikowane(['id_kategorii' => $idKategorii], $pager, $sorter);

            $najnowszeKategorieZGaleria = listaZObiektow($listaGalerii, 'idKategorii', 'idKategorii');

            $this->szablon->ustawBlok('index/kategorieGalerii', [
                'kategoria' => '',
                'nazwa' => 'Wszystkie',
                'aktywna' => true,
            ]);

            /**
             * @var Kategoria\Obiekt $kategoria
             */
            foreach ($dzieci as $kategoria)
            {
                if(!$kategoria['czy_widoczna']) continue;
                if(!in_array($kategoria['id'], $najnowszeKategorieZGaleria)) continue;

                $this->szablon->ustawBlok('index/kategorieGalerii', [
                    'kategoria' => strtolower($kategoria['nazwa']),
                    'nazwa' => $kategoria['nazwa'],
                    'link' => Router::urlHttp($kategoria['id']),
                    'aktywna' => false,
                ]);
            }
        }
        else
           $this->komunikat($this->j->t['brak_kategorii_galerii'],'info');

        if($ilosc > 0)
        {
            $i = 0;
            /**
             * @var Galeria\Obiekt $galeria
             */
            foreach ($listaGalerii  as $galeria)
            {
                if ($galeria->publikuj == 0) continue;

                $zdjecia_mapper = $this->dane()->GaleriaZdjecie();
                $ilosc_zdjec = $zdjecia_mapper->iloscOpublikowane($galeria->id);

                $kategoria = $galeria->pobierzKategorie();

                $tresc['nazwa'] = $galeria->nazwa;
                //$tresc['opis'] = $galeria->opis;
                //$tresc['autor'] = ($galeria->autor == '') ? $this->j->t['listaGalerii.brak_autora'] : $galeria->autor;
                //$tresc['data_dodania'] = $galeria->dataDodania->format($this->k->k['listaGalerii.format_daty']);
                //$tresc['ilosc_zdjec'] = $ilosc_zdjec;
                $tresc['link'] = Router::urlHttp($kategoria, array('galeria', $galeria->id));
                $tresc['etykieta_link_wiecej'] = $this->j->t['etykieta_link_wiecej'];
                $tresc['nie_wyswietlaj'] = $i >= $this->k->k['max_ilosc_wyswietlaj'];
                $i++;

                if ($galeria->zdjecieGlowne != '')
                {
                    $prefix = (empty($this->k->k['listaGalerii.prefix_miniaturki'])) ? null : $this->k->k['listaGalerii.prefix_miniaturki'].'-';
                    $tresc['zdjecie'] = Cms::inst()->url('galeria', $galeria->id).'/'.$prefix.$galeria->zdjecieGlowne;
                    $tresc['zdjecie_alt'] = $galeria->nazwa;
                    $tresc['kategoria'] = strtolower($kategoria->nazwa);

                    $this->szablon->ustawBlok('index/galeriaKategoria', $tresc);
                }
                else
                {
                    $zdjecie_alt = $this->j->t['listaGalerii.etykieta_brak_zdjecia_glownego'];
                    //$this->szablon->ustawBlok('listaGalerii/galeria_wylistowanie/brak_zdjecia_glownego', $tresc);
                }
                unset($galeria);

            }
        }
        else
            $this->komunikat($this->j->t['brak_galerii'],'info');

        if($ilosc >= $this->k->k['max_ilosc_wyswietlaj'])
            $this->szablon->ustawBlok('index/wiecej', ['czytaj_wiecej' => $this->j->t['czytaj_wiecej'],]);

        $this->tresc .= $this->szablon->parsujBlok('index', array(
            'galeria_naglowek' => $this->j->t['galeria_naglowek'],
            'galeria_naglowek_dwa' => $this->j->t['galeria_naglowek_dwa'],
        ));

	}

}


