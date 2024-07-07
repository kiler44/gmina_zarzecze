<?php
namespace Generic\Modul\StronaOpisowa;
use Generic\Biblioteka\Cms;
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
            //$urlPlikow = Cms::inst()->url('strona_opisowa', $this->obiekt->id);
            //$zalaczniki = $strona->pobierzZalaczniki();
            /**
             * @var Zalacznik\Obiekt $zalacznik
             */
            /*
            foreach($zalaczniki as $zalacznik)
            {
                dump($urlPlikow.$zalacznik->file);
            }
            */


            $strona_opisowa = array(
                'tresc' => $strona->tresc,
            );

            if ($strona->idGalerii > 0) {
                $mapper_zdjecia = $this->dane()->GaleriaZdjecie();
                $zdjecia = $mapper_zdjecia->pobierzOpublikowane($strona->idGalerii);

                if (count($zdjecia) > 0) {
                    $mapper_galeria = $this->dane()->Galeria();
                    $galeria = $mapper_galeria->pobierzPoId($aktualnosc->idGalerii);

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

			$this->ustawGlobalne(array(
				'tytul_modulu' => $strona->tytul,
			));

			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'tresc' => $strona_opisowa['tresc'],
                'galeria' => $strona_opisowa['galeria'],
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


