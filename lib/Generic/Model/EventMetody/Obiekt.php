<?php
namespace Generic\Model\EventMetody;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idEvent 
 * @property string $akcja 
 * @property string $opis 
 * @property mixed $dataWykonania 
 * @property mixed $daneWejsciowe 
 * @property mixed $daneWyjsciowe 
 * @property string $idWymagane 
 * @property string $konfiguracjaSzablon 
 * @property string $konfiguracja 
 * @property int $kod
 * @property string $szablon
 * @property bool $wykonany
 * @property string $errors
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\EventMetody\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\EventMetody\Obiekt
	 */
	protected $j;
	
	/**
	 * 
	 * @return \Generic\Model\Event\Obiekt();
	 */
	public function pobierzEvent()
	{
		
		if ( ! isset($this->_cache['event']) )
		{
			$maperEvent = $this->dane()->Event();
			$event = $maperEvent->pobierzPoId($this->idEvent);
			
			if($event instanceof \Generic\Model\Event\Obiekt)
				$this->_cache['event'] = $event;
			else
				$this->_cache['event'] = null;
			
		}
		return $this->_cache['event'];
	}
}