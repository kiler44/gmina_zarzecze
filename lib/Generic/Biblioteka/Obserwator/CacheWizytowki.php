<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;


/**
 * Klasa obserwatora usuwająca cache wizytówki: dane wizytówki jaki i oferty
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class CacheWizytowki extends Zdarzenia\Obserwator
{


	protected $typyObslugiwanychZdarzen = array(
		'Zdarzenia_Zdarzenie_ZmianyWizytowki',
		'Zdarzenia_Zdarzenie_ZmianyOgloszen',
	);



	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		$dane = $zdarzenie->pobierzDane();

		$subdomena = (isset($dane['subdomena'])) ? $dane['subdomena'] : '';

			// wizytówka nie posiada subdomeny - jest w trakcie edycji przez wklepywacza
		if ($subdomena == '') return;

		$cache = new Cache\Serwisu\Subdomena($subdomena);
		$cache->czyscCache();

		$urlWizytowka = Router\Http::inst()->url('WizytowkaPodglad', 'glowna', array('subdomena' => $subdomena));

		self::aktualizujPlikOdswierzaniaCache('wizytowki', array($urlWizytowka));

		if ($zdarzenie instanceof Zdarzenia\Zdarzenie\ZmianyOgloszen
			&& isset ($dane['id_ogloszenia']) && $dane['id_ogloszenia'] > 0)
		{
			$cms = Cms::inst();

			$staryTytul = $cms->temp('tytul_ogloszenia_przed_zmiana');

			$urlOferta = Router\Http::inst()->url('Oferty', 'oferta', array(
				'id_oferty' => $dane['id_ogloszenia'],
				'url_oferty' => tekstNaUrl(($staryTytul != '') ? $staryTytul : $dane['tytul_ogloszenia']),
			));
			$url = parse_url($urlOferta);

			$linkiMapper = Cms::inst()->dane()->CacheLinki();

			$linkiCache = $linkiMapper->zwracaTablice('url')->szukaj(array(
				'linki' => array($urlWizytowka, $urlOferta),
				'linki_lub_url' => $url['path'],
			));
			$linkiCache = listaZTablicy($linkiCache, null, 'url');

			$cachePodstrony = new Cache\Serwisu\Podstrony();
			$cachePodstrony->czyscLinkiPojedynczo = false;

			$cacheBloki = new Cache\Serwisu\Bloki();
			$cacheBloki->czyscLinkiPojedynczo = false;

			$usuniete = $urleDoWpisania = array();
			$prefix = $url['scheme'].'://'.$url['host'];

			foreach ($linkiCache as $url)
			{
				if (strpos($url, '#blok#') !== false)
				{
					$cacheBloki->usunCache(str_replace('#blok#', '', $url));
					$usuniete[] = $url;
				}
				elseif (strpos($url, '#') !== false)
				{
					continue;
				}
				elseif ($cachePodstrony->usunCache($url))
				{
					$usuniete[] = $url;
				}
			}
			$linkiMapper->usunWielePoUrl($usuniete);

			$doWpisania = array();
			foreach ($usuniete as $url)
			{
				if (strpos($url, '#') !== false) continue;
				$doWpisania[] = trim($prefix.$url);
			}

			self::aktualizujPlikOdswierzaniaCache('podstrony', $doWpisania);
		}
	}



	/**
	 * Uzupelnia plik sluzacy do odswierzania cache o podane adresy url
	 * @param string $typ Typ pliku ktory ma zostac zaktualizowany, dostepne typy: 'podstrony', 'wizytowki'
	 * @param array $noweUrle Lista urli do wpisania
	 * @return bool
	 */
	public static function aktualizujPlikOdswierzaniaCache($typ ,Array $noweUrle)
	{
		if ($typ == 'podstrony')
		{
			$listaPodstrony = CACHE_KATALOG.'/podstrony.txt';
		}
		elseif ($typ == 'wizytowki')
		{
			$listaPodstrony = CACHE_KATALOG.'/wizytowki.txt';
		}
		else
		{
			trigger_error('Nieprawidlowy typ zapisywanego pliku: '. $typ, E_USER_WARNING);
			return false;
		}

		$wpisaneUrl = is_file($listaPodstrony) ? array_map('trim', file($listaPodstrony)) : array();
		$noweUrle = array_unique($noweUrle);
		$urleDoWpisania = array();
		foreach ($noweUrle as $url)
		{
			if ( ! in_array($url, $wpisaneUrl))
			{
				$urleDoWpisania[] = $url;
			}
		}
		if (count($urleDoWpisania) > 0)
		{
			return file_put_contents($listaPodstrony, implode("\n", $urleDoWpisania)."\n", FILE_APPEND);
		}
		return true;
	}

}
