<?php
namespace Generic\Modul\WidokPoczatkowy;
use Generic\Biblioteka\Modul;
/**
 * Moduł odpowiedzialny za wyswietlenie strony startowej
 *
 * @author Łukasz Wrucha
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



        $this->tresc .= $this->szablon->parsujBlok('index');
	} 
}
