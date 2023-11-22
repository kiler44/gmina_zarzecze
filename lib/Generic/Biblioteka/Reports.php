<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Model\Reports as RaportyObiekt;
use Generic\Model\Zalacznik;
use Exception;


/**
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class Reports
{
	protected $dane = array();
	private $_idRaportuDoUsuniecia;
	public static $konfiguracjaLinkow = array();
	
	public function __construct()
	{
		
	}
	
	public function ustawDane(Array $dane)
	{
		$this->dane = $dane;
	}
	
	/**
	 * 
	 * @param type $zalacznik
	 * @param string $katalog
	 * @throws Exception
	 */
	public function dodajZalacznik($katalog, $zalacznik)
	{
		if(is_file($katalog.$zalacznik))
		{
			$this->dane['zalacznik'] = $zalacznik;
			$this->dane['katalog'] = $katalog;
		}
		else
		{
			throw new Exception('Załącznik nie istnieje', E_WARNING);
		}
		
	}
	
	private function sprawdzIdObiektow()
	{
		$raportMapper = new RaportyObiekt\Mapper();
		$kryteria = ['status' => 'active', 'kategoria' => $this->dane['kategoria'], 'wyklucz_id' => $this->_idRaportuDoUsuniecia];
		$pobraneRaporty = $raportMapper->szukaj($kryteria);
		
		$istniejaWspolne = false;
		foreach($pobraneRaporty as $raport)
		{
			$idObiektowRaportu = explode(',', $raport->idObiektow);
			$idObiektowDoSprawdzenia = explode(',', $this->dane['idObiektow']);
			$wspolneId = array_intersect($idObiektowRaportu, $idObiektowDoSprawdzenia);

			$iloscWspolnychId = count($wspolneId);
			if($iloscWspolnychId > 0)
				$istniejaWspolne = true;
		}
		
		return $istniejaWspolne;
	}
	
	/**
	 * @param type $obiekty - tablica obiektów których raport dotyczy, jezeli raport dotyczy jednego obiektu można podać go jako pojedynczy obiekt
	 * 
	 */
	public function ustawIdObiektow($obiekty)
	{
		
		$listaIdObiektow  = array();
		
		if(is_array($obiekty))
		{
			$obiektJeden = $obiekty[0];
			if(is_object($obiektJeden))
			{
				foreach($obiekty as $obiekt)
				{
					$listaIdObiektow[] = $obiekt->id;
				}
			}
			sort($listaIdObiektow);
		}
		else
		{
			$listaObiektId = $obiekty->id;
			$obiektJeden = $obiekty;
			
		}
		$this->pobierzTypObjektu($obiektJeden);
		$this->dane['idObiektow'] = implode(',', $listaIdObiektow);
	}
	
	/**
	 * 
	 * @param type $dataOd
	 * @param type $dataDo
	 * @throws Exception - występuje jeżeli dataOd jest mniejsza od dataDo
	 * 
	 */
	public function ustawZakresDat($dataOd, $dataDo)
	{
		$data_od = strtotime($dataOd);
		$data_do = strtotime($dataDo);
		if ( !($data_od <= $data_do ) )
		{
			throw new Exception('Wprowadzono nieprawidłowy zakres dat', E_WARNING);
		}
		$this->dane['dataOd'] = date('Y-m-d H:i:s', strtotime($dataOd));
		$this->dane['dataDo'] = date('Y-m-d H:i:s', strtotime($dataDo));
	}
	
	/**
	 * 
	 * @param type $idTypuZamowien
	 * @throws Exception - występuje jeżeli $idTypuZamowien jest mniejszy od 1
	 * 
	 */
	public function ustawIdType($idTypuZamowien)
	{
		$idType = intval($idTypuZamowien);
		if ($idType < 1)
		{
			throw new Exception('Podano niepoprawne id typu do ustawienia', E_WARNING);
		}
		$this->dane['typZamowien'] = $idType;
	}
	
	/**
	 * 
	 * @param double $netto
	 * @param double $brutto
	 * @throws Exception - występuje jeżeli $netto lub $brutto < 1
	 * 
	 */
	public function ustawPrices($netto, $brutto)
	{
		if ($netto < 1)
		{
			throw new Exception('Podano nieprawidlowa kwote netto', E_WARNING);
		}
		if ($brutto < 1)
		{
			throw new Exception('Podano nieprawidlowa kwote brutto', E_WARNING);
		}
		$this->dane['nettoPrice'] = $netto;
		$this->dane['bruttoPrice'] = $brutto;
	}
	
	/**
	 * 
	 * @param object $obiekt - przekazujemy obiekt do rozpoznania jakiego typ jest obiekt
	 * @return string - zwraca typ obiektu
	 */
	protected function pobierzTypObjektu($obiekt)
	{
		$chunks = explode('\\', get_class($obiekt));
		$this->dane['obiekt'] = $chunks[count($chunks)-2];
		
		return $this->dane['obiekt'];
	}
	
	/**
	 * 
	 * @param type $nazwaKategorii - nazwa kategorii, nazwa musi zgadzać się z kategoriami w konfiguracji modulu Reports
	 * @throws Exception - występuje jeżeli nazwa nie jest dopisana do konfiguracji
	 */
	public function ustawKategorie($nazwaKategorii)
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		
		$listaKategorii = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('kategorie_raportow', 'Reports_Admin');
		
		if(in_array($nazwaKategorii, $listaKategorii))
		{
			$this->dane['kategoria'] = $nazwaKategorii;
		}
		else 
		{
			throw new Exception('Kategoria do której próbujesz przypisać raport nie istnieje. Sprawdź konfiguracje modułu Raports', E_WARNING);
		}
		
	}
	
	/**
	 * ustawia autora raportu na podstawie zalogowanego użytkownika
	 *
	 */
	private function ustawAutora()
	{
		$cms = Cms::inst();
		$zalogowanaOsoba = $cms->profil();
		$this->dane['autor'] = $zalogowanaOsoba->id;
	}
	
	private function przeniesZalacznik($idReports)
	{
		$plik = new Plik($this->dane['katalog'].$this->dane['zalacznik']);

		$katalogDocelowy = new Katalog(Cms::inst()->katalog('reports', $idReports), true);
		$plik->przeniesDo($katalogDocelowy.'/'.$this->dane['zalacznik']);
		
	}
	
	private function zapiszZalacznik($idReports)
	{
		if(isset($this->dane['zalacznik']) && $this->dane['zalacznik'] != '')
		{
			$this->przeniesZalacznik($idReports);

			$zalacznikMapper = new Zalacznik\Mapper();
			$zalacznik = new Zalacznik\Obiekt();
			$zalacznik->idProjektu = ID_PROJEKTU;
			$zalacznik->idObject = $idReports;
			$zalacznik->object = "Reports";
			$zalacznik->idAuthor = Cms::inst()->profil()->id;
			
			$zalacznik->file = $this->dane['zalacznik'];
			$zalacznik->zapisz($zalacznikMapper);
		}
	}

	/**
	 * 
	 * @throws Exception
	 * @return boolean true - jeżeli zapis przebigł pomyslnie, false - jeżeli w raporcie istnieją powielone id Obiektow
	 */
	public function zapiszDoBazy()
	{
		if (is_array($this->dane) && count($this->dane) > 0)
		{
			$raportMapper = new RaportyObiekt\Mapper();
			$raport = new RaportyObiekt\Obiekt();
			$raport->idProjektu = ID_PROJEKTU;
			$this->ustawAutora();
			
			foreach($this->dane as $klucz => $wartosc)
			{
				if($klucz == 'zalacznik' || $klucz == 'katalog')
					continue;

				$raport->$klucz = $wartosc;
				
			}
			
			if($this->sprawdzIdObiektow())
			{
				return false;
			}
			
			if(!$raport->zapisz($raportMapper))
			{
				throw new Exception('Błąd zapisu raportu', E_ERROR);
			}
			else
			{
				$this->zapiszZalacznik($raport->id);
				if($this->_idRaportuDoUsuniecia > 0)
				{
					$this->usunRaportZapisz($this->_idRaportuDoUsuniecia);
				}
			}
		}
		else
		{
			throw new Exception('Nie ustawiono danych do wprowadzanie', E_ERROR);
		}
		return true;
	}
	
	/**
	 * ustawia id edytowane raportu do usunięcia, raport zostanie usunięty dopiero po poprawnym zapisie nowego raportu
	 * @param int $idRaportu
	 * @return boolean
	 */
	public function usunRaport($idRaportu)
	{
		$this->_idRaportuDoUsuniecia = $idRaportu;
	}
	
	private function usunRaportZapisz($idRaportu)
	{
		$raportMapper = new RaportyObiekt\Mapper();
		$raport = $raportMapper->pobierzPoId($idRaportu);
		
		if($raport instanceof RaportyObiekt\Obiekt)
		{
			$raport->status = 'delete';
			if($raport->zapisz($raportMapper))
			{
				return true;
			}
			return false;
		}
		return false;
	}
	
	/**
	 * 
	 * @param type $idRaportu
	 * @return boolean
	 */
	public static function pobierzLinkEdycji($idRaportu)
	{
		$cms = Cms::inst();
		$mapperRaport = $cms->dane()->Reports();
		$raport = $mapperRaport->pobierzPoId($idRaportu);
		
		if($raport instanceof RaportyObiekt\Obiekt)
		{
			if (count(self::$konfiguracjaLinkow) == 0)
			{
				$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
				self::$konfiguracjaLinkow = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('kategorie_edycja', 'Reports_Admin');
			}
			$linkTablica = explode(':', self::$konfiguracjaLinkow[$raport->kategoria]);
		
			$kodModulu = $linkTablica[0];
			unset($linkTablica[0]);
			$akcja = $linkTablica[1];
			unset($linkTablica[1]);

			$mapperKategoria = $cms->dane()->Kategoria();
			$kategoria = $mapperKategoria->pobierzPoKodModulu($kodModulu);

			$parametryLinku = array();
			foreach($linkTablica as $parametr)
			{
				if($parametr === 'idType')
				{
					$parametryLinku['idType'] = $raport->typZamowien;
					continue;
				}
				if($parametr === 'dataOd' || $parametr === 'dataDo')
				{
					$raport->$parametr = date('Y-m-d H:i:s', strtotime($raport->$parametr));
				}
				$parametryLinku[$parametr] = $raport->$parametr;
			}

			return Router::urlAdmin($kategoria, $akcja, $parametryLinku);
		}
		else
		{
			return false;
		}
		
		
	}
}