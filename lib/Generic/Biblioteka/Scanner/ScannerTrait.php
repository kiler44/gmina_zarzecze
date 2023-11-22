<?php
declare(strict_types=1);
namespace Generic\Biblioteka\Scanner;
use Avasil\ClamAv;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\CmsWyjatek;
use Generic\Biblioteka\Plik;
use Generic\Model\Uzytkownik;

/**
 * Description of ScannerTrait
 *
 * @author marci
 */

trait ScannerTrait {
	
	
	//private $conf = ['driver' => 'clamd_remote', 'host' => '10.2.0.15', 'port' => '3100'];
	//private $config = ['driver' => 'clamd_local', 'socket' => '/usr/local/var/run/clamav/clamd.sock'];

	/**
	 * ClamAv\Result
	**/
	private $wynik;
	
	/**
	 * @param string $path
	 * @return bool
	 **/
	protected function skan(string $path):bool
	{
		$this->ustawKonfiguracje();

		$clamd = new ClamAv\Scanner($this->conf);
		
		if (file_exists($path)) 
		{
            $wynik = $clamd->scan($path);
		} 
		else 
		{
            $wynik = $clamd->scanBuffer($path);
		}
		
		$this->wynik = $wynik;
	    $this->zapiszLog($path, $wynik->isClean());
		return $wynik->isClean();
	 
	}
	/**
	 * @after skanuj
	 **/
	public function pobierzWirusy():array
	{
		if($this->wynik instanceof ClamAv\Result)
			return $this->wynik->getInfected();
		else
			return array();
	}

	private function ustawKonfiguracje()
    {
        $cms = Cms::inst();
        if( in_array($cms->config['clamav']['driver'], ['clamd_local', 'clamd_remote']) )
        {
            $this->conf['host'] = $cms->config['clamav']['ip'] ;
            $this->conf['port'] = $cms->config['clamav']['port'] ;
        }
        else
            $this->conf['executable'] = $cms->config['clamav']['sciezka'];

        $this->conf['driver'] = $cms->config['clamav']['driver'];

       // $this->conf = ['driver' => 'clamd_remote', 'host' => '127.0.0.1', 'port' => '3310'];
    }

    private function zapiszLog(string $sciezka, bool $wynik)
    {
        $user = Cms::inst()->profil();
        $wirus = array();
        ($user instanceof Uzytkownik\Obiekt) ? : ($user = 'system');
        $wynikStr = ($wynik) ?  'brak wirusow' : 'znaleziono wirusa';
        if($wynik) $wirus = $this->pobierzWirusy();

        $logScan = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-clamav.log', true);
        $logWiersz = date('Y-m-d H:i:s').' Uzytkownik '.$user.' Sciezka : '.$sciezka.' Wynik: '.$wynikStr. ' Wirus : '.(implode(',', array_values($wirus))).' \n ';

        $logScan->ustawZawartosc($logWiersz, true);
    }

}
