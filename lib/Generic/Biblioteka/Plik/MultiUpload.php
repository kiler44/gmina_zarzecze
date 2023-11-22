<?php
declare(strict_types=1);
namespace Generic\Biblioteka\Plik;
use Generic\Biblioteka\{
	Katalog,
	Zadanie,
	Plik
};
/**
 * Description of MultiUpload
 *
 * @author Marcin Mucha
 */
class MultiUpload {
	
	/**
	 * @var Katalog
	 */
	private $katalog;
	/**
	 *
	 * @var type string (Http/Ajax)
	 */
	private $sposobPrzesylania;

    /**
     * @var array
     */
	private $result;


	public function __construct(string $token) 
	{
		$this->katalog = new Katalog(TEMP_KATALOG . '/public/trash/' . $token, true);
		$this->sposobPrzesylania = isset($_FILES['qqfile']) ? 'Http' : 'Ajax';
	}
	/**
	 * Funkcja zapisuje zdjęcie przeslane z inputa multiupload
	 *
	 * @param int $id - id zdjęcia
	 * @param string $idPrefix - prefix pojawiajacy sie przed identyfikatorem zdjecia
	 *
	 * @return Plik
	 */
	public function zapiszPlik($id, string $idPrefix = 'zdjecie') : Plik
	{
	    $info = $this->zaladujPlikDanych();
        $this->result['id'] = $id;

        if ($this->sposobPrzesylania == 'Http')
            $plik = $this->zapisz($_FILES['qqfile']['name'], $_FILES['qqfile']['tmp_name']);
        else
            $plik = $this->zapisz(Zadanie::pobierz('qqfile', 'trim'));


        if ($this->result['success'])
        {
            $zapisanoBajtow = $this->zapiszPlikDanych($info);
            $this->result['success'] = ($zapisanoBajtow == 0) ? false : true;

        }
			
		return $plik;
	}
	
	/**
	 * Funkcja zapisuje zdjęcie przeslane z inputa multiupload
	 *
	 * @param int $id - id zdjęcia
	 * @param array $rozmiaryMiniatur - lista z romizarami mniniaturek do wygenerowania
	 * @param string $idPrefix - prefix pojawiajacy sie przed identyfikatorem zdjecia
	 *
	 * @return Plik
	 */
	public function zapiszZdjecie(int $id, array $rozmiaryMiniatur, string $idPrefix = 'zdjecie') : Plik
	{
			$info = $this->zaladujPlikDanych();
            $this->result['id'] = $id;

			if ($this->sposobPrzesylania == 'Http')
				$zdjecie = $this->zapisz($_FILES['qqfile']['name'], $_FILES['qqfile']['tmp_name'], true);
			else
				$zdjecie = $this->zapisz(Zadanie::pobierz('qqfile', 'trim'), null, true);

			if ($this->result['success'])
			{
				foreach ($rozmiaryMiniatur as $prefix => $kod)
				{
					$prefix = ($prefix != '') ? $prefix.'-' : '';
					//if ($prefix == '') $usun = false;
					$zdjecie->tworzMiniaturke($this->katalog . '/' . $prefix . $this->result['kodPliku'], $kod);
				}

				$zapisanoBajtow = $this->zapiszPlikDanych($info);

				$this->result['success'] = ($zapisanoBajtow == 0) ? false : true;

			}
			 

			return $zdjecie;
	}
	
	private function zaladujPlikDanych() : array
	{
		$info = array();
		$plikDanych = $this->katalog . '/info.php';

		if (is_file($plikDanych))
			$info = @include($plikDanych);
		
		return $info;
	}
	
	private function zapiszPlikDanych(array $info) : int
	{
		$info[$this->result['id'] ] = array(
			'id' => $this->result['id'] ,
			'kod' => $this->result['kodPliku'],
			'nazwa' => $this->result['nazwa'],
			'rozmiar' => filesize($this->katalog . '/' . $this->result['kodPliku']),
		);

		$tresc = "<?php return " . var_export($info, true) . ";";
		$zapisanoBajtow = file_put_contents($this->katalog . '/info.php', $tresc);
		$zapisanoBajtow = ($zapisanoBajtow === false) ? 0 : $zapisanoBajtow;
		
		return $zapisanoBajtow;
	}
	
	public function pobierzWynikUploadu(): array
	{
		return $this->result;
	}

    private function zapisz(string $nazwaPliku, ?string $nazwaPlikuTmp = null, bool $zdjecie = false) : Plik
	{
		$kodPliku = Plik::unifikujNazwe($nazwaPliku);
		$kodPliku = wygenerujKodPliku2($this->katalog, $kodPliku);

		if($zdjecie)
        {
            if ($nazwaPlikuTmp)
            {
                $plik = new Zdjecie($_FILES['qqfile']['tmp_name']);
                $wynik = $plik->przeniesDo($this->katalog . '/' . $kodPliku);
            }
            else
            {
                $wynik = file_put_contents($this->katalog . '/' . $kodPliku, file_get_contents("php://input"));
                $plik = new Zdjecie($this->katalog . '/' . $kodPliku);
            }
        }
		else
        {
            if ($nazwaPlikuTmp)
            {
                $plik = new Plik($_FILES['qqfile']['tmp_name']);
                $wynik = $plik->przeniesDo($this->katalog . '/' . $kodPliku);
            }
            else
            {
                $wynik = file_put_contents($this->katalog . '/' . $kodPliku, file_get_contents("php://input"));
                $plik = new Plik($this->katalog . '/' . $kodPliku);
            }
        }

		$this->result['kodPliku'] = $kodPliku;
		$this->result['kod'] = $kodPliku;
		$this->result['nazwa'] = $nazwaPliku;
		$this->result['success'] = $wynik;
		
		return $plik;
	}
	
	/**
	 * Funkcja przenosi zdjecia po zapisaniu z folderu tymczasowego zdjec do rzeczywistego folderu ze zdjeciami danego ogloszenia / wizytowki
	 *
	 * @param array $zdjeciaInfo - tablica z obecną listą zdjęć
	 * @param array $pliki - tablica  zplikami do przeniesienia
	 * @param string $katalogDocelowy - katalog docelowy dla zapisu zdjęć
	 * @param bool $zmienSeparator - 0 separator _ 1 separator ()
	 * @return array - lista zdjęć po przeniesieniu
	 */
	public function przeniesPliki(array $zdjeciaInfo, array $pliki, string $katalogDocelowy, bool $zmienSeparator = false) : array
	{

		foreach ($pliki as $klucz => $zdjecie)
		{
			if (isset($zdjecie['kod']))
			{
				if($zmienSeparator)
					$kodZdjecia = wygenerujKodPliku2($katalogDocelowy, $zdjecie['kod']);
				else
					$kodZdjecia = wygenerujKodPliku($katalogDocelowy, $zdjecie['kod']);

				$plik = new Plik($this->katalog . '/' . $zdjecie['kod']);
				$plik->przeniesDo($katalogDocelowy . '/' . $kodZdjecia);
				$zdjecie['kod'] = $kodZdjecia;
				$zdjeciaInfo[$klucz] = $zdjecie;
				$zdjeciaInfo[$klucz]['kolejnosc'] = isset($zdjecie['kolejnosc']) ? $zdjecie['kolejnosc'] : 0;
				
				if (isset($zdjecie['opis']))
					$zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];

			}
			else
			{
				/**
				 * Zapisanie opisu do zdjecia i kolejnosci danego zdjecia
				 */
				$zdjeciaInfo[$klucz]['kolejnosc'] = isset($zdjecie['kolejnosc']) ? $zdjecie['kolejnosc'] : 0;
				if (isset($zdjecie['opis']))
				{
					$zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];
				}
			}
		}

		return $zdjeciaInfo;
	}
	
	/**
	 * Funkcja przenosi zdjecia po zapisaniu z folderu tymczasowego zdjec do rzeczywistego folderu ze zdjeciami danego ogloszenia / wizytowki
	 *
	 * @param array $pliki - tablica  zplikami do przeniesienia
	 * @param string $katalogDocelowy - katalog docelowy dla zapisu zdjęć
	 * @param array $rozmiaryMiniatur - lista z romizarami mniniaturek do wygenerowania
	 * @param string $prefixKodu - prefiks nazwy zdjęcia (zunifikowana nazwa ogłoszenia lub wizytowki)
	 *
	 * @return array - lista zdjęć po przeniesieniu
	 */
	public function przeniesZdjecia(array $pliki, string $katalogDocelowy, array $rozmiaryMiniatur, $prefixKodu = '' ) : array
	{
        $zdjeciaInfo = $this->zaladujPlikDanych();

        foreach ($zdjeciaInfo as $klucz => $wartosc)
        {
            if ( (! isset($pliki[$klucz])) && isset($pliki[$klucz + 1]))
            {
                $pliki[$klucz] = $pliki[$klucz + 1];
                unset($pliki[$klucz + 1]);
            }
        }

        foreach ($pliki as $klucz => $zdjecie)
        {
            /**
             * Sprawdzanie czy mamy kompletne info o zdjecie czy tylko opis do obrazka
             * Jesli mamy kompletne info zdjecia to wykonujemy pierwsza czesc instrukcji warunkowej
             * W przeciwnym razie wykonujemy druga czesc ktora aktualizuje tylko opis
             */
            if (isset($zdjecie['kod']))
            {
                foreach ($rozmiaryMiniatur as $prefix => $kod)
                {
                    $prefix = ($prefix != '') ? $prefix . '-' : '';
                    $plik = new Plik($this->katalog . '/' . $prefix . $zdjecie['kod']);
                    $plik->przeniesDo($katalogDocelowy . '/' . $prefix . $prefixKodu . $zdjecie['kod']);
                }
                $zdjecie['kod'] = $prefixKodu . $zdjecie['kod'];
                $zdjeciaInfo[$klucz] = $zdjecie;
            }
            else
            {
                /**
                 * Zapisanie opisu do zdjecia i kolejnosci danego zdjecia
                 */
                $zdjeciaInfo[$klucz]['kolejnosc'] = $zdjecie['kolejnosc'];
                $zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];
                $zdjeciaInfo[$klucz]['zdjecie_id'] = $zdjecie['zdjecie_id'];
            }
        }

        return $zdjeciaInfo;
	}


    /**
     * Kasuje zdjęcia z tempa
     *
     * @param array $ids - lista identyfikatorow zdjec do usuniecia
     * @param array $rozmiaryMiniatur
     * @return array
     */
    function usunZdjeciaTemp(array $ids, array $rozmiaryMiniatur) : array
    {
        $info = $this->zaladujPlikDanych();

        foreach($ids as $idZdjecia)
        {
            if (isset($info[$idZdjecia]))
            {
                foreach ($rozmiaryMiniatur as $prefix => $kod)
                {
                    $prefix = ($prefix != '') ? $prefix.'-' : '';
                   // if ($prefix == '') $usun = false;
                    $zdjecie = new Plik($this->katalog . '/' . $prefix . $info[$idZdjecia]['kod'], $kod);
                    $zdjecie->usun();
                }
                unset($info[$idZdjecia]);
            }
        }

        $zapisanoBajtow = $this->zaladujPlikDanych();

        $result['success'] = ($zapisanoBajtow == 0) ? false : true;

        return $result;
    }

    /**
     * Usuwa pliki z tempa
     *
     * @param array $ids - lista identyfikatorow zdjec do usuniecia
     *
     * @return array
     */
    function usunPlikiTemp(array $ids) : array
    {

        $info = $this->zaladujPlikDanych();

        foreach($ids as $idZdjecia)
        {
            if (isset($info[$idZdjecia]))
            {
                $zdjecie = new Plik($this->katalog . '/' . $info[$idZdjecia]['kod'], true);
                $zdjecie->usun();
                unset($info[$idZdjecia]);
            }
        }

        $zapisanoBajtow = $this->zapiszPlikDanych($info);

        $result['success'] = ($zapisanoBajtow == 0) ? false : true;

        return $result;
    }
}
