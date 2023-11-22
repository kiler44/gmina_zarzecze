<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Model\Uzytkownik;
use Generic\Model\Klient;
/**
 * Description of MetodaWysylaniaZalacznikowTrait
 *
 * @author Marci Mucha
 */
trait MetodaWysylaniaZalacznikowTrait {
    /**
     *
     * @var string
     * @example url/zalacznik/zalacznik_url
     */
    protected $metodaWysylaniaZalacznikow = 'url';

	protected $maileWysylajZalaczniki = [
		'faktura@bktas.no'
	];
	
	protected $idUzytkownikowWysylajZalaczniki = [
		
	];
			  
	private $idKlientowWysylajZalaczniki = [
		1
	];
	
	private $typKlientaWysylajZalaczniki = [
		
	];

	protected function pobierzMetodeWysylki()
	{
	    $this->politykaMetodWysylania();
		return $this->metodaWysylaniaZalacznikow;
	}
	
	private function politykaMetodWysylania()
	{
		foreach($this->obiektyOdbiorcow as $odbiorca)
		{
			if($odbiorca instanceof Klient\Obiekt && in_array($odbiorca->id, $this->idKlientowWysylajZalaczniki))
				$this->metodaWysylaniaZalacznikow = 'zalacznik_url';
		}
	}
	
}
