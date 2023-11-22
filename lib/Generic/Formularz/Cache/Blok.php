<?php
namespace Generic\Formularz\Cache;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Router;

class Blok extends \Generic\Formularz\Abstrakcja
{

	protected $plik;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'formularzDodawanieBloku');

		$this->formularz->input(new Input\Html('nazwa'))
			->ustawWartosc($this->obiekt->nazwa);

		$widoki = Cms::inst()->dane()->Widok()->zwracaTablice(array('nazwa'))->pobierzZawierajaceBlok($this->obiekt->id);

		$this->formularz->input(new Input\Html('widoki', array(
			'wartosc' => implode(', ', listaZTablicy($widoki, null, 'nazwa'))
		)));

		if ($this->obiekt->modul->cache == true)
		{
			$this->formularz->input(new Input\Checkbox('cache'))
				->ustawWartosc($this->obiekt->cache);

			$this->formularz->input(new Input\Select('cacheCzas', array(
				'lista' => $this->tlumaczenia['cache_czas_wartosci'],
			)))
				->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['cache_czas_wartosci'])))
				->ustawWartosc($this->obiekt->cacheCzas);

			if ($this->plik->istnieje())
			{
				$this->formularz->input(new Input\Checkbox('cacheCzysc'));
			}
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . Router::urlAdmin('CacheZarzadzanie', 'cacheBloki') . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	public function ustawPlik(Plik $plik)
	{
		$this->plik = $plik;

		return $this;
	}
}