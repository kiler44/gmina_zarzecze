<?php
namespace Generic\Biblioteka\Polityka\Produkt;
use Generic\Biblioteka\Polityka;

/**
 * Polityka pusta, NullObject
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class BrakPolityki extends Polityka\Produkt
{
	protected $wymaganeParametry = array();


	public function wykonaj()
	{
		return null;
	}

}
