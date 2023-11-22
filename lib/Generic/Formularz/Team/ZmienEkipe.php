<?php
namespace Generic\Formularz\Team;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

class ZmienEkipe extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'zmienEkipe', '', '' ,true, true);

		$this->formularz->input(new Input\Select('ekipa'))->wymagany = true;
		
		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));
		
		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}