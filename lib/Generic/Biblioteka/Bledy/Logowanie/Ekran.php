<?php
namespace Generic\Biblioteka\Bledy\Logowanie;
use Generic\Biblioteka\Bledy;


/**
 * Logowanie bledow do pliku dziennika.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Ekran extends Bledy\Logowanie
{

	/**
	 * Przechwycone bledy.
	 * @var array
	 */
	private $bledy = array();



	/**
	 * Konstruktor, ustawia poziom przechwytywanych bledow i zmienia konfiguracje php.
	 *
	 * @param integer $poziom poziom przechwytywanych bledow.
	 */
	function __construct($poziom)
	{
		//ini_set('display_errors', false);
		//ini_set('display_startup_errors', false);
		parent::__construct($poziom);
	}



	/**
	 * Destruktor, wyswietla komunikaty bledow na ekranie.
	 */
	function __destruct()
	{
		if (count($this->bledy) > 0)
		{
			echo '<a href="#blokBledowPhp" ondblclick="this.style.visibility = \'hidden\'; return false;" style="padding: 30px 60px 30px 110px; text-decoration: blink; ; color: #D91111; border-radius: 8px; background: url(/_system/img/alarma.gif) no-repeat -100px 10px white; font: bold 14pt Arial; z-index: 1000; position: fixed; top: 20px; right: 3px; box-shadow: 1px 1px 15px #D91111 inset; text-shadow: 1px 1px 0 #970006;">Znaleziono błędy</a>';
			echo '<hr><div id="blokBledowPhp" style="width: 100%; color: #000; background-color: #eee; font: normal 10pt Arial;"><pre style="overflow: auto;">';
			echo '<script type="text/javascript"> function sciezkaBledu(divID) { var box = document.getElementById(divID).style; box.display = (box.display == "block") ? "none" : "block"; }</script><br />'."\n";
			foreach($this->bledy as $numer => $blad)
			{
				echo $blad['tresc'];
				echo ($blad['sciezka'] != '') ? '  <b onclick="sciezkaBledu(\'sciezkaZwrotnaBledu'.$numer.'\');return false;" style="cursor: pointer"><< Wiecej >></b><br/><div id="sciezkaZwrotnaBledu'.$numer.'" style="display: none;">'.$blad['sciezka'].'</div>' : '';
				echo "\n\n";
			}
			echo '</pre></div>';
		}
		//ini_restore('display_errors');
		//ini_restore('display_startup_errors');
	}



	/**
	 * Obsluguje przechwycony blad.
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 */
	protected function przechwycBlad($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty)
	{
		$this->bledy[] = array(
			'tresc' => $this->formatujTresc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu),
			'sciezka' => $this->formatujSciezke($dodatkoweArgumenty)
		);
	}

}
