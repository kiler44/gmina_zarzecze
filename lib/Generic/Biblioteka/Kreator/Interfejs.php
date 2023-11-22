<?php
namespace Generic\Biblioteka\Kreator;

/**
 * Interfejs kreatorów plików z kodem PHP na podstawie tabeli z bazy danych.
 * @author Marek Bar
 * 
 */
interface Interfejs
{
	/**
	 * @return bool Określa czy plik został wygenerowany.
	 */
	function generuj($nazwaTabeli, $nazwaUzytkownika);
	
	/**
	 * @return string - tekst podsumowania gotowy do wyświetlenia
	 */
	function pokazPodsumowanie();
	
	
}
