<?php
namespace Generic\Modul\Attachments;
use Generic\Biblioteka\Modul;

/**
 * Moduł przygotowania faktur przed wysłaniem do księgowości
 *
 * @author Łukasz Wrucha 
 * @package moduly
 */
class Http extends Modul\Http
{
	protected $uprawnienia = array(
		'wykonajIndex',
	);
	
	protected $akcjeAjax = array(
		
	);
	
	protected $zdarzenia = array(
		
	);

	/**
	 * @var \Generic\Konfiguracja\Modul\PrepareFaktura\Http
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\PrepareFaktura\Http
	 */
	protected $j;
	
	
	
	public function wykonajIndex()
	{
		
	}
}