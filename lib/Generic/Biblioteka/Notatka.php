<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Model\Notes;
/**
 * Obsluga notatek w systemie
 *
 * @author Marcin Mucha
 * @package biblioteki
 */
class Notatka
{
	
	/**
	 * Objekt notatki
	 * 
	 * @var notes
	 */
	protected $_objektNotatka;
	
	/**
	 *
	 * @var array
	 */
	protected $_kryteriaSzukania = array();
	
	/**
	 * Objekt do ktorego przypisana jest notatka.
	 * 
	 * @var object
	 */
	protected $_objekt ;
	
	/**
	 * Id objektu do ktorego przypisana jest notatka
	 * 
	 * @var int
	 */
	protected $_idObjekt;
	
	/**
	 * Typ objektu do którego przypisywana jest notatka
	 * 
	 * @var string
	 */
	protected $_typObjekt;


	/**
	 * Tekst notatki
	 * 
	 * @var string
	 */
	
	protected $_notatka;
	
	
	/**
	 * Konstruktor.
	 *
	 * @param string $objekt - objekt na którym operuje notatka.
	 * 
	 */
	function __construct($objekt) {
		
		$this->ustawObjekt($objekt);
		$this->ustawIdObjektu($objekt->id);
		$this->ustawTypObjektu();
		$this->_objektNotatka = new Notes\Obiekt();
		
	}
	
	protected function ustawObjekt($wartosc)
	{
		if(is_object($wartosc))
		{
			$this->_objekt = $wartosc;
		}
		else
		{
			trigger_error('Błąd. Podana wartość nie jest objektem .', E_USER_WARNING);
			return false;
		}
	}
	
	protected function ustawIdObjektu($wartosc)
	{
		if(is_int($wartosc) && $wartosc > 0 )
		{
			$this->_idObjekt = $wartosc;
		}
		else
		{
			trigger_error('Błąd. Podano błędną wartość dla pola idObjektu .', E_USER_WARNING);
			return false;
		}
	}
	
	protected function ustawTypObjektu()
	{
		$chunks = explode('\\', get_class($this->_objekt));
		$this->_typObjekt = $chunks[count($chunks)-2];
	}
	
	/**
	 * zwraca tablice notatek dla danego objektu
	 *
	 * @param string $notatka - notatka.
	 * 
	 */
	function pobierzNotatki()
	{
		$cms = Cms::inst();
		$mapper = $cms->dane()->Notes();
		$kryteria['object'] = $this->_objektNotatka->object;
		$kryteria['idObject'] = $this->_objektNotatka->idObject;
		$kryteriaSzukania = array_merge($kryteria, $this->_kryteriaSzukania);
		$pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteriaSzukania);
		
		return $pobraneWiersze;
	}
	
	function ustawDodatkoweKryteriaSzukania($kryteria = array())
	{
		if(is_array($kryteria) && count($kryteria) > 0)
		{
			$this->_kryteriaSzukania = $kryteria;
		}
	}
	
	/**
	 * ustawia autora notatki na podstawie zalogowanego użytkownika
	 *
	 */
	function ustawAutora()
	{
		$cms = Cms::inst();
		$zalogowanaOsoba = $cms->profil();
		$this->_objektNotatka->author = $zalogowanaOsoba->id;
	}
	
	/**
	 * zapisuje notatke dla danego objektu
	 *
	 * @param string $notatka - notatka.
	 * 
	 */
	function zapiszNotatke($notatka)
	{
		$cms = Cms::inst();
		$mapper = $cms->dane()->Notes();
		$this->ustawAutora();
		$this->_objektNotatka->idProjektu = ID_PROJEKTU;
		$this->_objektNotatka->object = $this->_typObjekt;
		$this->_objektNotatka->idObject = $this->_idObjekt;
		$this->_objektNotatka->description = $notatka;
		
		if($this->_objektNotatka->zapisz($mapper))
		{
			return $this->_objektNotatka;
		}
		else
		{
			trigger_error('Błąd. Zapis notatki zakończony niepowodzeniem. ', E_USER_WARNING);
			return false;
		}
		
	}
	
	 
}
?>
