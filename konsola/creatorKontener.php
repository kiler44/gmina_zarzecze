<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;

/**
 * Generator Kontenera Mapperów. Należy uruchomić po każdym dodaniu nowego mappera.
 * Jest incude'owany na końcu skryptu creator.php.
 *
 * @author Konrad Rudowski
 */

$szablon_tpl = '<?php
namespace Generic\\Biblioteka\\Kontener;
use Generic\\Biblioteka\\Kontener;
use Generic\\Model;

/**
 * Kontener przetrzymujący i zwracający instancje mapperów.
 * Wygenerowano automatycznie {{$data_utworzenia}}.
 *
 * @author creatorKontener
 * @package biblioteki
 */

class Mappery extends Kontener
{
	/**
	 * Pobiera instancję obiektu podanej klasy. Ustawia domyślne zachowanie obiektu na zwracaObiekt.
	 * @param string $nazwaKlasy Nazwa kalsy której instancją ma być zwracany obiekt.
	 * @return object
	 */
	public function pobierz($nazwaKlasy)
	{
		$mapper = parent::pobierz($nazwaKlasy);

		$mapper->zwracaObiekt();

		return $mapper;
	}


{{BEGIN INSTANCJA_MAPPERA}}

	/**
	 * Zwraca instancję klasy Generic\\Model\\{{$nazwaMappera}}\\Mapper
	 * {{$opisKlasy}}
	 * @return \\Generic\\Model\\{{$nazwaMappera}}\\Mapper
	 */
	public function {{$nazwaMetody}}()
	{
		return $this->pobierz(\'Generic\\Model\\{{$nazwaMappera}}\\Mapper\');
	}
{{END}}

{{BEGIN INSTANCJA_MAPPERA_NOSQL}}

	/**
	 * Zwraca instancję klasy Generic\\ModelNosql\\{{$nazwaMappera}}
	 * {{$opisKlasy}}
	 * @return \\Generic\\ModelNosql\\{{$nazwaMappera}}
	 */
	public function {{$nazwaMetody}}()
	{
		return \\Generic\\Biblioteka\\Cms::inst()->Baza(\'{{$nazwaBazy}}\')->pobierzMongo()->getRepository(\'Generic\\ModelNosql\\{{$nazwaMappera}}\');
	}
{{END}}

}
';

define('KONTENER_KATALOG', CMS_KATALOG.'/lib/Generic/Biblioteka/Kontener/');
define('DANE_KATALOG2', CMS_KATALOG.'/lib/Generic/Model/');
define('DANE_KATALOG3', CMS_KATALOG.'/lib/Generic/ModelNosql/');

$katalogDane = new Katalog(DANE_KATALOG2);

$szablon = new Szablon();
$szablon->ladujTresc($szablon_tpl);

echo'Przeszukuję katalog '.DANE_KATALOG2."\n";

$mappery = $katalogDane->pobierzZawartosc();
ksort($mappery);
foreach ($mappery as $nazwaPliku => $czyKatalog)
{
	if ($czyKatalog == null || $nazwaPliku == '.svn')
	{
		continue;
	}

	$nazwaMappera = $nazwaPliku;
	$nazwaMetody =  $nazwaPliku;
	$szablon->ustawBlok('/INSTANCJA_MAPPERA', array(
		'nazwaMappera' => $nazwaMappera,
		'nazwaMetody' => $nazwaMetody,
		'opisKlasy' => pobierzOpisKlasy(DANE_KATALOG2 . $nazwaPliku . '/Mapper.php'),
	));
}

$katalogDaneNosql = new Katalog(DANE_KATALOG3);
echo'Przeszukuję katalog '.DANE_KATALOG3."\n";

$mapperyNosql = $katalogDaneNosql->pobierzZawartosc();
ksort($mapperyNosql);

$listaMapperowNosql = array();

foreach ($mapperyNosql as $nazwaPliku => $czyKatalog)
{
	if ($czyKatalog != null || $nazwaPliku == '.svn')
	{
		continue;
	}

	$nazwaPliku = str_replace(array('Repository.php', 'Query.php', '.php'), '', $nazwaPliku);

	$listaMapperowNosql[$nazwaPliku] = $nazwaPliku;
}

foreach ($listaMapperowNosql as $nazwaMappera)
{
	$nazwaKlasy = '\\Generic\\ModelNosql\\' . $nazwaMappera . 'Repository';

	$szablon->ustawBlok('/INSTANCJA_MAPPERA_NOSQL', array(
		'nazwaMappera' => $nazwaMappera,
		'nazwaMetody' => $nazwaMappera,
		'opisKlasy' => '',
		'nazwaBazy' => $nazwaKlasy::pobierzIdentyfikatorBazy(),
	));
}

$wynik_kontener = $szablon->parsujBlok('/', array('data_utworzenia' => date('Y-m-d H:i:s')));

echo'Sprawdzam czy istnieje katalog '.KONTENER_KATALOG."\n";

$katalogKontener = new Katalog(KONTENER_KATALOG, true);

if (file_put_contents(KONTENER_KATALOG.'Mappery.php', $wynik_kontener))
{
	echo "Zapisano plik kontenera\n";
}
else
{
	echo "BŁĄD! Nie mozna zapisać pliku kontenera\n";
}

function pobierzOpisKlasy($nazwaPliku)
{
    try{
        $plik = new Plik($nazwaPliku);
        $zawartosc = $plik->pobierzZawartosc();
    }catch (Exception $e){
        trigger_error('Plik '.$nazwaPliku.' Nie istnieje ', E_USER_NOTICE);
        return '';
    }

	$poczatek = strpos($zawartosc, '/**') + 3;
	$koniec = strpos($zawartosc, '*/');

	if ($poczatek < $koniec && $poczatek > 3)
	{
		return str_replace('*', "\t *",substr($zawartosc, $poczatek, $koniec - $poczatek));
	}
	else
	{
		return '';
	}
}