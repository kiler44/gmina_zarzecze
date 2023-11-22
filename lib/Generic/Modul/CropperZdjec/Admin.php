<?php
namespace Generic\Modul\CropperZdjec;
use Generic\Biblioteka\Modul;


/**
 * Modul przycina zdjęcia i wyświetla odpowiedni formularz
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\CropperZdjec\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\CropperZdjec\Admin
	 */
	protected $j;


	protected $zdarzenia = array(
	);

	protected $uprawnienia = array(
		'wykonajIndex',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$this->komunikat($this->j->t['index.info_brak_mozliwosci_zarzadzania_modulem'], 'info');
	}
}
