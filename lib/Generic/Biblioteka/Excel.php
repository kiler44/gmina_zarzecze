<?php
namespace Generic\Biblioteka;


/**
 * Klasa obsluguje generowanie plikow xls.
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

require_once "Spreadsheet/Excel/Writer.php";

class Excel
{
	
	static function UtworzSzablon($name = null)
	{
		return new \Spreadsheet_Excel_Writer($name);
	}
}