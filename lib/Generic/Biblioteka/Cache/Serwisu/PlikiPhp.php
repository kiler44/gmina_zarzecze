<?php
namespace Generic\Biblioteka\Cache\Serwisu;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;


/**
 * Obsluga cache plikow php
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class PlikiPhp
{


	/**
	 * @var string
	 */
	protected $subdomena;

	/**
	 * @var Kategoria
	 */
	protected $kategoria;

	/**
	 * @var string
	 */
	protected $akcja;

	/**
	 * @var Katalog
	 */
	protected $katalogCache;



	public function __construct(Router\Http $router)
	{
		$this->subdomena = $router->pobierzParametr('subdomena');
		$this->kategoria = $router->pobierzParametr('kategoria');
		$this->akcja = $router->pobierzParametr('akcja');;
		$this->katalogCache = new Katalog(CACHE_KATALOG.'/php/', true);
	}



	public function tworzCache($url)
	{
		$hash = $this->tworzHash($url);

		$plik_cache_php = $this->katalogCache.'/'.$hash.'.php';

		if ($hash != '' && ! is_file($plik_cache_php))
		{
			$lista = listaPlikow('','',true);
			$lista = array_unique($lista, SORT_STRING);
			asort($lista);
			pakuj_pliki($lista, $plik_cache_php);
		}
	}



	public function odczytajCache($url)
	{
		// tutaj musimy wyczyscic cache startowy
		$plik_boot_cache_php = $this->katalogCache.'/boot.php';

		$lista = listaPlikow('','',true);
		if ( ! is_file($plik_boot_cache_php))
		{
			$lista = array_unique($lista, SORT_STRING);
			asort($lista); // bez posortowania listy wywali sie skrypt przy odczycie
			pakuj_pliki($lista, $plik_boot_cache_php);
		}

		$hash = $this->tworzHash($url);

		$plik_cache_php = $this->katalogCache.'/'.$hash.'.php';

		if ($hash != '' && is_file($plik_cache_php))
		{
			include_once $plik_cache_php;
		}
	}



	public function czyscCache()
	{
		$sciezka = (string)$this->katalogCache;
		if ( ! $this->katalogCache->usun()) return false;
		$this->katalogCache = new Katalog($sciezka, true);
		return $this->katalogCache->istnieje();
	}



	protected function tworzHash($url)
	{
		if ($this->akcja != 'index')
			return ($this->subdomena ? 'subdomena_' : '').$this->kategoria->kodModulu.'_'.$this->kategoria->id.'_'.$this->akcja;
		else
			return utworz_hash_adresu(($this->subdomena ? 'subdomena_' : '').$url);
	}

}
