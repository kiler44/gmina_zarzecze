<?php
use Generic\Biblioteka\Cms;

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

$katalog_danych = 'trekk_2015'; // Katalog gdzie ma zapisać tabele w celu obrobki

$scrapuj_dane = false; // Czy ma sciagać dane do katalogu false jesli juz wczesniej sciagniete

$limit_tabel = 0;

$limit_wierszy = 0;

$rok = 2014;

$znajdz = array('<td class="blackSmall">', '</td>', ' ');
$zamien = array('', '', '');

$pobieraj_dane = false;

$tabela_lp = 1;

$kolumna = 1;
$kwota_od = 0;
$kwota_do = 0;
$podatek = 0;

$mapper = new \Generic\Model\TabelaPodatkowa\Mapper();

if ($scrapuj_dane)
{
	$tabele = array('7100','7101','7102','7103','7104','7105','7106','7107','7108','7109','7110','7111','7112','7113','7114','7115','7116','7117','7118','7119','7120','7121','7122','7123','7124','7125','7126','7127','7128','7129','7130','7131','7132','7133','7200','7201','7202','7203','7204','7205','7206','7207','7208','7209','7210','7211','7212','7213','7214','7215','7216','7217','7218','7219','7220','7221','7222','7223','7224','7225','7226','7227','7228','7229','7230','7231','7232','7233','7150','7160','7170','7250','7260','7270','7300','7350','7400','7450','7500','7550','7600','7650','7700','7800','6300','6350','6400','6450','6500','6550','6600','6650','6700','6800','0100','0101','0200','0201');


	$url = 'https://skort.skatteetaten.no/skd/trekk/trekk';
	$data = array(
		'aar' =>	1,
		'hele' => ' Hele tabellen',
		'maalform' => 'B',
		'modus' => 'senere',
		'opprinnelse' => 'skatteetaten.no',
		'sideId' => 'sideIdSoek',
		'tabelltype' => 0,
		'trekkgrunnlag' => 0,
		'trekkperiode' => 1,
	);

	foreach ($tabele as $tabela_numer)
	{
		$data['tabellnummer'] = $tabela_numer;
		// use key 'http' even if you send the request to https://...
		$options = array(
			 'http' => array(
				  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				  'method'  => 'POST',
				  'content' => http_build_query($data),
			 ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result)
		{
			$wynik = file_put_contents($katalog_danych.'/'.$tabela_numer.'.txt', $result);
			if ($wynik)
			{
				echo "Zapisano tabele \"$tabela_numer\" do pliku: $katalog_danych/$tabela_numer.txt ===========================================\n";
			}
			else
			{
				echo "!!! ======= Blad przy zapisie tabeli numer: \"$tabela_numer\" ===========================================\n";
			}
		}
		else
		{
			echo "!!! ======= Blad przy pobieraniu tabeli numer: \"$tabela_numer\" ===========================================\n";
		}
	}
}

set_error_handler(function($errno, $errstr, $errfile, $errline){
	return true;	
});
if (!is_dir($katalog_danych.'/tmp'))
{
	mkdir($katalog_danych.'/tmp');
}
foreach (glob($katalog_danych.'/*.txt') as $plik)
{
	$dom = new \DOMDocument();
	$dom->preserveWhiteSpace = false;
	//$dom->
	/* Load the HTML */
	libxml_use_internal_errors(false);
	@$dom->loadHTMLFile($plik);
	$dom->normalizeDocument();
	//$dom->
	/* Create a new XPath object */
	$xpath = new \DomXPath($dom);
	
	/* Query all <td> nodes containing specified class name */
	$nodes = $xpath->query("/html/body/table/tr[2]/td[2]/table/tr/td[2]/table/tr[4]/td/table");
	
	$innerHtml = '';
	foreach ($nodes as $node)
	{
		$innerHtml .= get_inner_html($node);
	}
	file_put_contents($katalog_danych.'/tmp/'.basename($plik), $innerHtml);
	/* Set HTTP response header to plain text for debugging output */
	//header("Content-type: text/plain");
	/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
	//dump($nodes);
	
	
	/*
	$wiersz_lp = 1;
	
	if ($limit_tabel > 0 && $tabela_lp > $limit_tabel)
	{
		echo '!!! Przekroczony limit tabel !!! Koniec pracy skryptu';
		die();
	}
		
	$rodzaj = 'kwota';
	$nr_tabeli = str_replace(array('.txt'), array(''), $plik);
	echo "Importuje wpisy dla tabeli nr: ". $nr_tabeli . " ===========================================\n";
	
	if (isset($wiersze))
		unset($wiersze);
	
	;
	foreach (file($plik) as $wiersz)
	{
		if (! $pobieraj_dane && strpos($wiersz, ' align="RIGHT">') !== false)
		{
			$pobieraj_dane = true;
			continue;
		}
		if ($pobieraj_dane && strpos($wiersz, '"blackSmall"') !== false && strpos($wiersz, '&nbsp;') === false)
		{
			if ($limit_wierszy > 0 && $wiersz_lp > $limit_wierszy)
			{
				break 2;
			}
			
			if ($wiersz_lp == 1)
			{
				if ($kolumna == 1)
				{
					$kwota_od = trim(str_replace($znajdz, $zamien, $wiersz));
					if (!is_numeric($kwota_od))
					{
						$kwota_od = 0;
						continue;
					}
					$kolumna = 2;
				}
				else
				{
					$podatek = trim(str_replace($znajdz, $zamien, $wiersz));
					$kolumna = 1;
				}
			}
			else
			{
				if ($kolumna == 1)
				{
					$kwota_do = trim(str_replace($znajdz, $zamien, $wiersz));
					if (!is_numeric($kwota_od))
					{
						$kwota_od = 0;
						continue;
					}
					else
					{
						$wpis = new \Generic\Model\TabelaPodatkowa\Obiekt();
						$wpis->nrTabeli = $nr_tabeli;
						$wpis->rok = date('Y');
						$wpis->idProjektu = 1;
						$wpis->kwotaOd = $kwota_od;
						$wpis->kwotaDo = $kwota_do;
						$wpis->podatek = $podatek;
						$wpis->rodzaj = 'kwotowy';
						
						if ($wpis->zapisz($mapper))
						{
							echo '== Dodaje do bazy wiersz zakresu: '.$kwota_od.' - '.$kwota_do.' ['.$podatek.']'." ==\n";
						}
						else
						{
							echo '== !!! NIE dodalem do bazy wiersza zakresu: '.$kwota_od.' - '.$kwota_do.' ['.$podatek.']'." !!! ==\n";
						}
							
						$kwota_od = $kwota_do;
					}
					$kolumna = 2;
				}
				else
				{
					$podatek = trim(str_replace($znajdz, $zamien, $wiersz));
					
					if (strpos($podatek, '%') !== false)
					{
						$rodzaj = 'procentowy';
						$kwota_do = 2147483647;
						
						$wpis = new \Generic\Model\TabelaPodatkowa\Obiekt();
						$wpis->nrTabeli = $nr_tabeli;
						$wpis->rok = date('Y');
						$wpis->idProjektu = 1;
						$wpis->kwotaOd = $kwota_od;
						$wpis->kwotaDo = $kwota_do;
						$wpis->podatek = $podatek;
						$wpis->rodzaj = $rodzaj;
						
						if ($wpis->zapisz($mapper))
						{
							echo '== Dodaje do bazy wiersz zakresu: '.$kwota_od.' - nieskonczonosc ['.$podatek.']'." ==\n";
						}
						else
						{
							echo '== !!! NIE dodalem do bazy wiersza zakresu: '.$kwota_od.' - '.$kwota_do.' ['.$podatek.']'." !!! ==\n";
						}
						$kolumna = 1;
						continue;
					}
					
					$kolumna = 1;
					$pobieraj_dane = false;
				}
				unset($wpis);
			}
			
			$wiersz_lp++;
		}
		unset($wiersz);
	}
	$tabela_lp++;
	 * 
	 */
}

function get_inner_html( $node ) {
    $innerHTML= '';
    $children = $node->childNodes;
    foreach ($children as $child) {
        $innerHTML .= str_replace('&#13;', '', $child->ownerDocument->saveXML( $child ));
    }

    return $innerHTML;
} 