<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

/*
 * Skrypt czysci cache PHP.
 * Jako parametry podajemy typy cache, które chcemy usunać:
 * PHP - cache PHP
 * TPL - cache TPL
 * Wszystko - czyści wszystkie cache
 *
 * @author Konrad Rudowski
 * @package konsola
 */

if (in_array('PHP', $argv) || in_array('Wszystko', $argv))
{
	echo "Czyszczę cache PHP\n";
	$katalog = new Katalog(CACHE_KATALOG.'/php');
	if ($katalog->istnieje())
	{
		$katalog->usun();
	}
	$katalog = new Katalog(CACHE_KATALOG.'/php', true);
	$katalog->ustawDostep(0777);
	echo "Zakończyłem czyszczenie cache PHP\n";
}


if (in_array('TPL', $argv) || in_array('Wszystko', $argv))
{
	echo "Czyszczę cache TPL\n";
	$katalog = new Katalog(CACHE_KATALOG.'/tpl');
	if ($katalog->istnieje())
	{
		$katalog->usun();
	}
	$katalog = new Katalog(CACHE_KATALOG.'/tpl', true);
	$katalog->ustawDostep(0777);
	echo "Zakończyłem czyszczenie cache TPL\n";
}