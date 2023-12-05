<?php
namespace Generic\Modul\BlokGalerii;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;


/**
 * Blok odpowiadajacy za wyświetlanie dodatkowej treści opisowej na stronie.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokOpisowy\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokOpisowy\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$blok = Cms::inst()->temp('blok_opisowy_'.$this->blok->id);

		if (!is_array($blok))
		{
			$mapper = $this->dane()->BlokOpisowy();
			$blok = $mapper->zwracaTablice()->pobierzDlaBloku($this->blok->id);
		}
		if (is_array($blok))
		{
			$this->ustawGlobalne(array('tytul_modulu' => $blok['tytul']));
			$this->tresc .= $this->szablon->parsujBlok('index', array('tresc' => $blok['tresc']));
		}
		else
		{
			trigger_error('Nie można pobrać treści bloku o id: '.$this->blok->id, E_USER_ERROR);
			return;
		}
	}

}


