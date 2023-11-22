<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$domena = null;
$kod_projektu = null;

if (isset($argv[1]) && $argv[1] != '')
{
	$domena = $argv[1];
}
if (isset($argv[2]) && $argv[2] != '')
{
	$kod_projektu = strtolower(trim($argv[2]));
}

if (!preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $domena))
{
	die("Nieprawidlowa domena\n");
}
if ($kod_projektu == '')
{
	$kod_projektu = 'projekt_domyslny';
}


$temp = parse_url(strtolower($domena));
$domena = (isset($temp['host']) && !empty($temp['host'])) ? $temp['host'] : $temp['path'];
if (substr($domena, 0, 4) == 'www.')
{
	$domena = substr($domena, 4);
}
unset($temp);

define('CMS_KATALOG', dirname(dirname(__FILE__)).'/html');
require_once CMS_KATALOG.'/system/lib.inc.php';

$cms = Cms::inst();
$cms->konfiguracjaPlik();
$cms->bledy = new Bledy();
$cms->bledy->dodajMechanizm(new Bledy_Logowanie_Konsola(E_ALL));
$cms->bledy->rejestruj();
$cms->ladujBazeDanych();

$projekt = new Projekt();
$projekt->kod = $kod_projektu;
$projekt->nazwa = 'Projekt domyślny';
$projekt->domena = $domena;
$projekt->szablon = 'szablon_domyslny';
$projekt->domyslnyJezyk = 'pl';

$projektyMapper =$cms->dane()->Projekty();

if (!$projekt->zapisz($projektyMapper))
{
	die("Nie mozna utworzyc projektu podstawowego\n");
}

$jezykiMapper = $cms->dane()->JezykiProjektu();

$jezyk = new JezykProjektu();
$jezyk->idProjektu = $projekt->id;
$jezyk->kod = 'pl';
$jezyk->nazwa = 'Polski';
$jezyk->zapisz($jezykiMapper);

$katalogSzablon = new Katalog(CMS_KATALOG.'/szablony/'.$projekt->kod, true);
$katalogSzablon = new Katalog(CMS_KATALOG.'/szablony/'.$projekt->kod.'/'.$projekt->szablon, true);
$katalogTemp = new Katalog(CMS_KATALOG.'/temp/'.$projekt->kod, true);
$katalogTemp = new Katalog(CMS_KATALOG.'/temp/'.$projekt->kod.'/public', true);

$vhostCfg = new Szablon(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/vhost.tpl');
$tresc = $vhostCfg->parsujBlok('vhost', array(
	'kod' => $projekt->kod,
	'nazwa' => $projekt->nazwa,
	'domena' => $projekt->domena,
	'szablon' => $projekt->szablon,
	'katalog' => CMS_KATALOG,
	's' => DIRECTORY_SEPARATOR,
));

$plikVhost = CMS_KATALOG.'/temp/'.$projekt->kod.'/http-www.conf';

file_put_contents($plikVhost, $tresc);

?>