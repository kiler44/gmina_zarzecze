<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

/**
 * Generator Obiektów danych.
 *
 * @author Dariusz Półtorak
 */

$data_tpl = '<?php

/**
 * show off @property, @property-read, @property-write
 *
{{BEGIN COMMENT}} * @property {{$TYP}} ${{$NAZWA}}
{{END}}
 */

class {{$NAZWA}} extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
{{BEGIN POLE}}		\'{{$NAZWA}}\',
{{END}}
	);
}
';

$mapper_tpl = '<?php

class {{$NAZWA}} extends Mapper_Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = \'{{DATA}}\';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = \'{{TABELA}}\';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
{{BEGIN POLE}}		\'{{$NAZWA_BAZA}}\' => \'{{$NAZWA}}\',
{{END}}
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array({{BEGIN KLUCZ}}\'{{$POLE_KLUCZ}}\', {{END}});



	// przetrzymuje typy pol tabeli w bazie
	protected $polaTabeliTypy = array(
{{BEGIN POLE_TYP}}		\'{{$NAZWA_BAZA}}\' => self::{{TYP}},
{{END}}
	);



	public function pobierzPoId($id)
	{
		$sql = \'SELECT * FROM \' . $this->tabela
			. \' WHERE id = \' . intval($id)
			. \' AND id_projektu = \' . ID_PROJEKTU
			. \' AND kod_jezyka = \\\'\' . KOD_JEZYKA .\'\\\'\';

		return $this->pobierzJeden($sql);
	}
{{BEGIN id_kategorii}}



	public function pobierzDlaKategorii($id, $opublikowane = true)
	{
		$sql = \'SELECT * FROM \' . $this->tabela
			. \' WHERE id_kategorii = \' . intval($id)
			. \' AND id_projektu = \' . ID_PROJEKTU
			. \' AND kod_jezyka = \\\'\' . KOD_JEZYKA .\'\\\'\';

		return $this->pobierzWiele($sql);
	}
{{END}}



	public function szukaj($kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = \'SELECT * FROM \' . $this->tabela
			. \' WHERE id_projektu = \' . ID_PROJEKTU
			. \' AND kod_jezyka = \\\'\' . KOD_JEZYKA .\'\\\'\';

{{BEGIN id_kategorii_szukaj}}		if (isset($kryteria[\'id_kategorii\']) && $kryteria[\'id_kategorii\'] != \'\')
		{
			$sql .= \' AND id_kategorii = \'.intval($kryteria[\'id_kategorii\']);
		}
{{END}}
{{BEGIN id_uzytkownika_szukaj}}		if (isset($kryteria[\'id_uzytkownika\']) && $kryteria[\'id_uzytkownika\'] != \'\')
		{
			$sql .= \' AND id_uzytkownika = \'.intval($kryteria[\'id_uzytkownika\']);
		}
{{END}}
{{BEGIN data_dodania_szukaj}}		if (isset($kryteria[\'data_dodania\']) && intval($kryteria[\'data_dodania\']) > 0)
		{
			$sql .= \' AND data_dodania > DATE_SUB(\\\'\'.date(\'Y-m-d\').\'\\\', INTERVAL \'.intval($kryteria[\'data_dodania\']).\' DAY)\';
		}
{{END}}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = \'SELECT COUNT(*) FROM \' . $this->tabela
			. \' WHERE id_projektu = \' . ID_PROJEKTU
			. \' AND kod_jezyka = \\\'\' . KOD_JEZYKA .\'\\\'\';

{{BEGIN id_kategorii_ilosc_szukaj}}		if (isset($kryteria[\'id_kategorii\']) && $kryteria[\'id_kategorii\'] != \'\')
		{
			$sql .= \' AND id_kategorii = \'.intval($kryteria[\'id_kategorii\']);
		}
{{END}}
{{BEGIN id_uzytkownika_ilosc_szukaj}}		if (isset($kryteria[\'id_uzytkownika\']) && $kryteria[\'id_uzytkownika\'] != \'\')
		{
			$sql .= \' AND id_uzytkownika = \'.intval($kryteria[\'id_uzytkownika\']);
		}
{{END}}
{{BEGIN data_dodania_ilosc_szukaj}}		if (isset($kryteria[\'data_dodania\']) && intval($kryteria[\'data_dodania\']) > 0)
		{
			$sql .= \' AND data_dodania > DATE_SUB(\\\'\'.date(\'Y-m-d\').\'\\\', INTERVAL \'.intval($kryteria[\'data_dodania\']).\' DAY)\';
		}
{{END}}

		return $this->pobierzWartosc($sql);
	}

}
';

// Pobranie argumentow
if (! isset($argv[1]) || trim($argv[1]) == '' ||
	! isset($argv[2]) || trim($argv[2]) == '' ||
	! isset($argv[3]) || trim($argv[3]) == '')
{
	die("BLAD! NIEPRAWIDLOWE PARAMETRY!
Uruchomic wg wzorca:

{$argv[0]} {nazwa_tabeli} {nazwa_obiektu_danych} {nazwa_mappera}

Przyklad:
	{$argv[0]} modul_aktualnosci Aktualnosc AktualnosciMapper

");
}

define('DANE_KATALOG', CMS_KATALOG.'/dane/');

require_once CMS_KATALOG.'/lib.inc.php';

// Sprawdzenie katalogu wynikowego
if ( ! (file_exists(DANE_KATALOG) && is_dir(DANE_KATALOG) && is_writable(DANE_KATALOG)) )
{
	die("Nie mozna zapisac danych wynikowych w katalogu ".DANE_KATALOG.". Sprawdz uprawnienia katalogu\n\n");
}

$tabela_mappera = trim($argv['1']);
$nazwa_obiektu_danych = trim($argv['2']);
$nazwa_mappera = trim($argv['3']);

$config = parse_ini_file(CMS_KATALOG.'/baza.ini');

// Polaczenie z baza danych
try
{
	$pdo = new PDO("{$config['db_driver']}:host={$config['db_host']};dbname=information_schema", $config['db_user'], $config['db_password']);
}
catch(Exception $e)
{
	die("Brak polaczenia z baza danych 'information_schema', tabela '$tabela_mappera'\n\n");
}

// Pobieramy dane z bazy danych
$stm = $pdo->prepare('SELECT * FROM columns WHERE table_schema = :baza AND table_name = :tabela');
$stm->execute(array(
	'baza' => $config['db_name'],
	'tabela' => $tabela_mappera,
));
$wynik = $stm->fetchAll();
if(count($wynik) == 0) {
	die("Nie znaleziono tabeli '$tabela_mappera' w bazie '{$config['db_name']}'.\n\n");
}

// Tworzymy tabele z potrzebnymi informacjami
$tabela = array();
foreach($wynik as $w) {
	$tabela[$w['COLUMN_NAME']] = array(
		'typ' => parsujTyp($w['DATA_TYPE']),
		'nazwa' => parsujNazwe($w['COLUMN_NAME']),
		'klucz' => ($w['COLUMN_KEY'] == 'PRI') ? true : false,
	);
}

// Przygotowujemy szablony
$obiekt = new Szablon();
$obiekt->ladujTresc($data_tpl);

$mapper = new Szablon();
$mapper->ladujTresc($mapper_tpl);

// Parsujemy szablon obiektu danych i mappera
foreach ($tabela as $pole => $info)
{
	$obiekt->ustawBlok('/COMMENT', array(
		'TYP' => strtolower($info['typ']),
		'NAZWA' => $info['nazwa'],
	));
	$obiekt->ustawBlok('/POLE', array(
		'NAZWA' => $info['nazwa'],
	));

	$mapper->ustawBlok('/POLE', array(
		'NAZWA_BAZA' => $pole,
		'NAZWA' => $info['nazwa'],
	));
	$mapper->ustawBlok('/POLE_TYP', array(
		'NAZWA_BAZA' => $pole,
		'TYP' => $info['typ'],
	));
	if ($info['klucz']) {
		$mapper->ustawBlok('/KLUCZ', array('POLE_KLUCZ' => $pole));
	}
	if ($pole == 'id_kategorii') {
		$mapper->ustawBlok('/id_kategorii', array());
		$mapper->ustawBlok('/id_kategorii_szukaj', array());
		$mapper->ustawBlok('/id_kategorii_ilosc_szukaj', array());
	}
	if ($pole == 'id_uzytkownika') {
		$mapper->ustawBlok('/id_uzytkownika_szukaj', array());
		$mapper->ustawBlok('/id_uzytkownika_ilosc_szukaj', array());
	}
	if ($pole == 'data_dodania') {
		$mapper->ustawBlok('/data_dodania_szukaj', array());
		$mapper->ustawBlok('/data_dodania_ilosc_szukaj', array());
	}
}

// Zapisujemy obiekt danych
echo "Generuje plik $nazwa_obiektu_danych.class.php\n";
echo "Obiekt danych $nazwa_obiektu_danych... ";

$wynik_obiekt = $obiekt->parsujBlok('/', array('NAZWA' => $nazwa_obiektu_danych));

if (@file_put_contents(DANE_KATALOG."{$nazwa_obiektu_danych}.class.php", $wynik_obiekt))
{
	echo "Zapisano plik obiektu danych\n\n";
}
else {
	echo "BLAD! Nie mozna zapisac pliku obiektu danych\n\n";
}


echo "Generuje plik {$nazwa_mappera}.class.php\n";
echo "Mapper {$nazwa_mappera}... ";

// Zapisujemy mapper
$wynik_mapper = $mapper->parsujBlok('/', array(
	'NAZWA' => $nazwa_mappera,
	'DATA' => $nazwa_obiektu_danych,
	'TABELA' => $tabela_mappera,
));

if (@file_put_contents(DANE_KATALOG."{$nazwa_mappera}.class.php", $wynik_mapper))
{
	echo "Zapisano plik mappera\n\n";
}
else
{
	echo "BLAD! Nie mozna zapisac pliku mappera\n\n";
}

include(CMS_KATALOG.'/konsola/creatorKontener.php');


function parsujTyp($typ)
{
	$typyBaza = array(
		'STRING' => array('char', 'varchar', 'tinytext', 'mediumtext', 'text',
						'longtext', 'date', 'datetime', 'timestamp', 'set', 'enum'),

		'BOOLEAN' => array('boolean'),

		'INTEGER' => array('tinyint', 'smallint', 'mediumint', 'int', 'bigint'),

		'FLOAT' => array('decimal', 'float', 'double', 'real'),
	);

	foreach ($typyBaza as $nazwaTypu => $typySQL)
	{
		if (in_array($typ, $typySQL)) return $nazwaTypu;
	}

	return 'NIEZNANY_TYP';
}



function parsujNazwe($nazwa)
{
	$nazwa = trim($nazwa, '_');
	$nazwa = explode('_', $nazwa);
	$nazwa = array_map('strtolower',$nazwa);
	$nazwa = array_map('ucfirst', $nazwa);
	$nazwa[0] = strtolower($nazwa[0]);
	$nazwa = implode('', $nazwa);
	return $nazwa;
}

?>
