<?php
namespace Generic\Modul\StronaOpisowa;
use Generic\Biblioteka\Modul;
use Generic\Model\StronaOpisowa;


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
			$this->ustawGlobalne(array(
				'tytul_modulu' => $strona->tytul,
			));
			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'tresc' => $strona->tresc,
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


