<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Cms;


/**
 * Klasa obserwatora logujaca zdarzenie do bazy
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class DoBazyNosql extends Zdarzenia\Obserwator
{

	private $zdarzenia = array();


	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{

		$log = Cms::inst()->dane()->LogZdarzen()->pobierzNowyObiekt();

		$log->timestamp = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$log->idPracownika = Cms::inst()->profil() ? Cms::inst()->profil()->id : null;

		$danePomocnicze = $zdarzenie->pobierzDane();
		$typyDanychPomocniczych = $zdarzenie->pobierzDaneWymagane();

		if ($zdarzenie->pobierzEtykietaObiektuGlownego() != '')
		{
			$log->idObiektuGlownego = $danePomocnicze[$zdarzenie->pobierzEtykietaObiektuGlownego()]->id;
			$log->typObiektuGlownego = $typyDanychPomocniczych[$zdarzenie->pobierzEtykietaObiektuGlownego()];
		}

		$daneDodatkowe = array();

		foreach ($danePomocnicze as $klucz => $wartosc)
		{
			if (isset($typyDanychPomocniczych[$klucz]))
			{
				$daneDodatkowe[$typyDanychPomocniczych[$klucz]] = ($wartosc instanceof \Generic\Biblioteka\ObiektDanych)? $wartosc->id : $wartosc;
			}
			else
			{
				$daneDodatkowe[$klucz] = $wartosc;
			}
		}

		$log->danePomocnicze = $daneDodatkowe;
		$log->nazwa = get_class($zdarzenie);
		$log->tokenProcesu = $zdarzenie->pobierzTokenProcesu();


		$this->zdarzenia[] = $log;
	}



	public function __destruct()
	{
		if ( ! empty($this->zdarzenia))
		{
			foreach($this->zdarzenia as $klucz => $log)
			{
				$log->zapisz();
			}
		}
	}

}
