<?php
namespace Generic\Biblioteka;

/**
 * Klasa obsluguje logowanie zdarzen występujacych w sytemie w bazie NoSQL.
 * Zbiera raportuje i częściowo analizuje dane logów.
 *
 * @author Konrad Rudowski
 */

class LogZdarzen
{
	/**
	 * Przechowuje instancję klasy Singleton
	 *
	 * @var \Generic\Biblioteka\LogZdarzen
	 */
	private static $_instancja = false;


	private function __construct()
	{
		LogZdarzen::$_instancja = $this;
	}


	/**
	 * Zwraca instancje Loga zdarzeń
	 *
	 * @return \Generic\Biblioteka\LogZdarzen
	 */
	static public function inst()
	{
		if (self::$_instancja === false)
		{
			self::$_instancja = new LogZdarzen();
		}
		return self::$_instancja;
	}

	//zapisujemy zdarzenie
	//szukamy zwiazanych z nim procesow
	//jesli to zdarzenie konczace proces rejestrujemy wpis procesu
	//jedno zdarzenie moze nalezec do wielu procesow


	//albo

	//zapisujemy start procesu (zdarzenie)
	//zapisujemy koniec procesu (zdarzenie) analizujac procesy wstecz (wpis proces)
	//jedno zdarzenie nie moze nalezec do wielu procesow

	public function zapiszZdarzenie()
	{

	}


	public function zapiszPoczatekProcesu() // tutaj jest pomysl żeby wstrzykiwać obiekt procesu i z niego uzyskiwac dane do zapisu.  On sam zawierałby algorytm analizujacy logi dla danego procesu.
	{//logujemy zdarzenie z odpowiednimi danymi

	}


	public function zapiszKoniecProcesu() // tutaj jest pomysl żeby wstrzykiwać obiekt procesu i z niego uzyskiwac dane do zapisu.  On sam zawierałby algorytm analizujacy logi dla danego procesu.
	{//logujemy zdarzenie z odpowiednimi danymi
		//analizujemy loga wstecz i zapisujemy rekord dotyczący procesu
	}

}
