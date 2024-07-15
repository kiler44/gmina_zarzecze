<?php
namespace Generic\Modul\StronaOpisowa;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\MenedzerPlikow;
use Generic\Biblioteka\Modul;
use Generic\Model\StronaOpisowa;
use Generic\Model\Zalacznik;


/**
 * Moduł odpowiedzialny za wyświetlanie strony opisowej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\StronaOpisowa\Http
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\StronaOpisowa\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$mapper = $this->dane()->StronaOpisowa();

		$strona = $mapper->pobierzDlaKategorii($this->kategoria->id);
		if ($strona instanceof StronaOpisowa\Obiekt)
		{
            $strona_opisowa = array(
                'tresc' => $strona->tresc,
                'galeria' => null,
                'zalaczniki' => null,
            );

            if ($strona->idGalerii > 0) {
                $mapper_zdjecia = $this->dane()->GaleriaZdjecie();
                $zdjecia = $mapper_zdjecia->pobierzOpublikowane($strona->idGalerii);

                if (count($zdjecia) > 0) {
                    $mapper_galeria = $this->dane()->Galeria();
                    $galeria = $mapper_galeria->pobierzPoId($strona->idGalerii);

                    $galeria_dane = array(
                        'tytul_galerii' => $galeria->nazwa,
                        'autor_zdjec' => ($galeria->autor != '') ? $galeria->autor : $this->j->t['aktualnosc.autor_zdjec_nieznany'],
                    );


                    $katalogZdjec = Cms::inst()->url('galeria', $strona->idGalerii);
                    $prefix = (empty($this->k->k['dolaczonaGaleria.prefix_miniaturki'])) ? null : $this->k->k['dolaczonaGaleria.prefix_miniaturki'] . '-';

                    foreach ($zdjecia as $zdjecie) {
                        $foto['tytul'] = $zdjecie->tytul;
                        $foto['opis'] = $zdjecie->opis;
                        $foto['miniaturka'] = $katalogZdjec . '/' . $prefix . $zdjecie->nazwaPliku;
                        $foto['zdjecie_link'] = $katalogZdjec . '/' . $zdjecie->nazwaPliku;
                        $foto['lightbox'] = (int)(bool)$this->k->k['dolaczonaGaleria.uzyj_lightbox'];

                        $this->szablon->ustawBlok('galeria/miniaturka', $foto);
                    }
                    $strona_opisowa['galeria'] = $this->szablon->parsujBlok('galeria', $galeria_dane);
                }
            }


            $zalaczniki = $strona->pobierzZalaczniki();
            /**
             * @var Zalacznik\Obiekt $zalacznik
             */

            if (count($zalaczniki) > 0) {
                $urlPlikow = Cms::inst()->url('strona_opisowa', $strona->id);

                foreach ($zalaczniki as $zalacznik) {
                    $plik['nazwa'] = $zalacznik->file;
                    $plik['opis'] = $zalacznik->opis;
                    $plik['typ'] = $zalacznik->type;
                    $plik['rozszerzenie'] = strtolower(file_ext(basename($zalacznik->file)));
                    $plik['link'] = $urlPlikow.'/'.urldecode($zalacznik->file);
                    $plik['rozmiar'] = bajtyNa($zalacznik->rozmiar, 0);


                    $this->szablon->ustawBlok('zalaczniki/element', $plik);
                }
                $strona_opisowa['zalaczniki'] = $this->szablon->parsujBlok('zalaczniki');

            }

			$this->ustawGlobalne(array(
				'tytul_modulu' => $strona->tytul,
			));

			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'tresc' => $strona_opisowa['tresc'],
                'galeria' => $strona_opisowa['galeria'],
                'zalaczniki' => $strona_opisowa['zalaczniki'],
			));
		}
		else
		{
			$this->ustawGlobalne(array(
				'tytul_modulu' => $this->kategoria->nazwa,
			));
			$this->komunikat($this->j->t['index.blad_brak_strony'],'info');
		}
	}

}


