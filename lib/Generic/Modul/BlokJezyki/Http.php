<?php
namespace Generic\Modul\BlokJezyki;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;


/**
 * Blok z wyborem jezykow.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokJezyki\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokJezyki\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$cms = Cms::inst();

		$this->wstawDoSzablonuBlokTlumaczen('index');

		if ($this->k->k['index.pokaz_wybrany'])
		{
			$this->szablon->ustawBlok('/index/wybrany', array(
				'wybrany_jezyk' => KOD_JEZYKA,
				'nazwa_wybrany_jezyk' => $cms->lang['kraje'][KOD_JEZYKA],
			));
		}

		if (count($cms->projekt->jezykiKody) > 1)
		{
			$this->szablon->ustawBlok('/index/zmien', array());

			$url = 'http://'.WWW_PREF.$cms->projekt->domena;

			if (count($this->k->k['index.kolejnosc_wyswietlania']) > 0)
			{
				foreach ($this->k->k['index.kolejnosc_wyswietlania'] as $kodJezyka => $etykieta)
				{
					if ($kodJezyka == KOD_JEZYKA) continue;
					if (in_array($kodJezyka, $cms->projekt->jezykiKody))
					{
						$this->szablon->ustawBlok('/index/zmien/link', array(
							'url' => $url.'/'.$kodJezyka.'/',
							'kod' => $kodJezyka,
							'etykieta' => ($etykieta != '') ? $etykieta : $cms->lang['kraje'][$kodJezyka],
						));
					}
				}
			}
			else
			{
				foreach ($cms->projekt->jezykiKody as $kodJezyka)
				{
					if ($kodJezyka == KOD_JEZYKA) continue;
					$this->szablon->ustawBlok('/index/zmien/link', array(
						'url' => $url.'/'.$kodJezyka.'/',
						'kod' => $kodJezyka,
						'etykieta' => $cms->lang['kraje'][$kodJezyka],
					));
				}
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('index');
	}

}