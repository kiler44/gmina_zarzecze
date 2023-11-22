<?php
namespace Generic\Biblioteka\Cache\Serwisu;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;


/**
 * Obsluga cache plikow tpl
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class PlikiTpl
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
		$this->katalogCache = new Katalog(CACHE_KATALOG.'/tpl/', true);
	}



	public function tworzCache($url)
	{
		$hash = $this->tworzHash($url);

		$plik_cache_tpl = $this->katalogCache.'/'.$hash.'.php';

		if ($hash != '' && ! is_file($plik_cache_tpl))
		{
			Plik::zapiszTrescPlikow($plik_cache_tpl);
		}
	}



	public function odczytajCache($url)
	{
		$hash = $this->tworzHash($url);

		$plik_cache_tpl = $this->katalogCache.'/'.$hash.'.php';

		if ($hash != '' && is_file($plik_cache_tpl))
		{
			Plik::ladujTrescPlikow($plik_cache_tpl);
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
