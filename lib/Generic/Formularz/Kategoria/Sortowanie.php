<?php
namespace Generic\Formularz\Kategoria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Sortowanie extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var string
	 */
	protected $drzewo;


	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'formularzSortowanie');

		$this->formularz->input(new Input\Hidden('przenoszona', ''));
		$this->formularz->input(new Input\Hidden('cel', ''));
		$this->formularz->input(new Input\Hidden('polozenie', ''));

		$this->formularz->stopka(new Input\Html('drzewo', '', array('wartosc' => $this->drzewo)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Kategoria\Sortowanie
	 */
	public function ustawDrzewo($drzewo)
	{
		$this->drzewo = $drzewo;

		return $this;
	}
}