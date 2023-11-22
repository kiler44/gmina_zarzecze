<?php
namespace Generic\Biblioteka\Kontener;
use Generic\Biblioteka\Kontener;
use Generic\Model;

/**
 * Kontener przetrzymujący i zwracający instancje mapperów.
 * Wygenerowano automatycznie 2020-03-11 15:06:12.
 *
 * @author creatorKontener
 * @package biblioteki
 */

class Mappery extends Kontener
{
	/**
	 * Pobiera instancję obiektu podanej klasy. Ustawia domyślne zachowanie obiektu na zwracaObiekt.
	 * @param string $nazwaKlasy Nazwa kalsy której instancją ma być zwracany obiekt.
	 * @return object
	 */
	public function pobierz($nazwaKlasy)
	{
		$mapper = parent::pobierz($nazwaKlasy);

		$mapper->zwracaObiekt();

		return $mapper;
	}



	/**
	 * Zwraca instancję klasy Generic\Model\Aktualnosc\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących aktualności.
 	 * @author Krzysztof Lesiczka, Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\Aktualnosc\Mapper
	 */
	public function Aktualnosc()
	{
		return $this->pobierz('Generic\Model\Aktualnosc\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Blok\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących bloki towarzyszące.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Blok\Mapper
	 */
	public function Blok()
	{
		return $this->pobierz('Generic\Model\Blok\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\BlokMenu\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących bloki menu.
 	 * @author Krzysztof Lesiczka, Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\BlokMenu\Mapper
	 */
	public function BlokMenu()
	{
		return $this->pobierz('Generic\Model\BlokMenu\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\BlokOpisowy\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących bloki opisowe.
 	 * @author Krzysztof Lesiczka, Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\BlokOpisowy\Mapper
	 */
	public function BlokOpisowy()
	{
		return $this->pobierz('Generic\Model\BlokOpisowy\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\CacheLinki\Mapper
	 * 
	 * @return \Generic\Model\CacheLinki\Mapper
	 */
	public function CacheLinki()
	{
		return $this->pobierz('Generic\Model\CacheLinki\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\CennikMiejscowosci\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy elementów menu aplikacji.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\CennikMiejscowosci\Mapper
	 */
	public function CennikMiejscowosci()
	{
		return $this->pobierz('Generic\Model\CennikMiejscowosci\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\DostepnyModul\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z pliku dla obiektów odwzorowujących moduły cms-a.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\DostepnyModul\Mapper
	 */
	public function DostepnyModul()
	{
		return $this->pobierz('Generic\Model\DostepnyModul\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Drzewo\Mapper
	 * 
	 * @return \Generic\Model\Drzewo\Mapper
	 */
	public function Drzewo()
	{
		return $this->pobierz('Generic\Model\Drzewo\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\EmailFormatka\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących formatki emaili.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\EmailFormatka\Mapper
	 */
	public function EmailFormatka()
	{
		return $this->pobierz('Generic\Model\EmailFormatka\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\EmailSzablon\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących szablony emaili.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\EmailSzablon\Mapper
	 */
	public function EmailSzablon()
	{
		return $this->pobierz('Generic\Model\EmailSzablon\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\EmailWpisKolejki\Mapper
	 * 
	 * @return \Generic\Model\EmailWpisKolejki\Mapper
	 */
	public function EmailWpisKolejki()
	{
		return $this->pobierz('Generic\Model\EmailWpisKolejki\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Event\Mapper
	 * 
	 * Maper tabeli w bazie: modul_event

	 * @return \Generic\Model\Event\Mapper
	 */
	public function Event()
	{
		return $this->pobierz('Generic\Model\Event\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\EventMetody\Mapper
	 * 
	 * Maper tabeli w bazie: modul_event_metody

	 * @return \Generic\Model\EventMetody\Mapper
	 */
	public function EventMetody()
	{
		return $this->pobierz('Generic\Model\EventMetody\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Faktura\Mapper
	 * 
	 * Maper tabeli w bazie: modul_faktura

	 * @return \Generic\Model\Faktura\Mapper
	 */
	public function Faktura()
	{
		return $this->pobierz('Generic\Model\Faktura\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\FakturaPozycje\Mapper
	 * 
	 * Maper tabeli w bazie: modul_faktura_pozycje

	 * @return \Generic\Model\FakturaPozycje\Mapper
	 */
	public function FakturaPozycje()
	{
		return $this->pobierz('Generic\Model\FakturaPozycje\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\FormularzKontaktowyTemat\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących tematy formularza kontaktowego.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\FormularzKontaktowyTemat\Mapper
	 */
	public function FormularzKontaktowyTemat()
	{
		return $this->pobierz('Generic\Model\FormularzKontaktowyTemat\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\FormularzKontaktowyWiadomosc\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiadomości z formularza kontaktowego.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\FormularzKontaktowyWiadomosc\Mapper
	 */
	public function FormularzKontaktowyWiadomosc()
	{
		return $this->pobierz('Generic\Model\FormularzKontaktowyWiadomosc\Mapper');
	}

    /**
    * Zwraca instancję klasy Generic\Model\FormularzKontaktowyWiadomosc\Mapper
    *
    * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiadomości z formularza kontaktowego.
    * @author Łukasz Wrucha
    * @package dane

    * @return \Generic\Model\Galeria\Mapper
    */
    public function Galeria()
    {
        return $this->pobierz('Generic\Model\Galeria\Mapper');
    }

    public function GaleriaZdjecie()
    {
        return $this->pobierz('Generic\Model\GaleriaZdjecie\Mapper');
    }

	/**
	 * Zwraca instancję klasy Generic\Model\InformacjeApartamenty\Mapper
	 * 
	 * Maper tabeli w bazie: modul_informacje_apartamenty

	 * @return \Generic\Model\InformacjeApartamenty\Mapper
	 */
	public function InformacjeApartamenty()
	{
		return $this->pobierz('Generic\Model\InformacjeApartamenty\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\JezykProjektu\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących języki projektu.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\JezykProjektu\Mapper
	 */
	public function JezykProjektu()
	{
		return $this->pobierz('Generic\Model\JezykProjektu\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Kalendarz\Mapper
	 * 
	 * Maper tabeli w bazie: modul_kalendarz

	 * @return \Generic\Model\Kalendarz\Mapper
	 */
	public function Kalendarz()
	{
		return $this->pobierz('Generic\Model\Kalendarz\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Kamienie\Mapper
	 * 
 	 * @author Marcin Mucha
 
	 * @return \Generic\Model\Kamienie\Mapper
	 */
	public function Kamienie()
	{
		return $this->pobierz('Generic\Model\Kamienie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\KanalRss\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wpisy kanałów rss.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\KanalRss\Mapper
	 */
	public function KanalRss()
	{
		return $this->pobierz('Generic\Model\KanalRss\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Kategoria\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących kategorie podstron.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Kategoria\Mapper
	 */
	public function Kategoria()
	{
		return $this->pobierz('Generic\Model\Kategoria\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\KategorieMagazyn\Mapper
	 * 
	 * Maper tabeli w bazie: modul_kategorie_magazyn

	 * @return \Generic\Model\KategorieMagazyn\Mapper
	 */
	public function KategorieMagazyn()
	{
		return $this->pobierz('Generic\Model\KategorieMagazyn\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Klient\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących klientów.
 	 * @author Marcin Mucha
 	 * @package dane
 
	 * @return \Generic\Model\Klient\Mapper
	 */
	public function Klient()
	{
		return $this->pobierz('Generic\Model\Klient\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Log\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiersze logów.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Log\Mapper
	 */
	public function Log()
	{
		return $this->pobierz('Generic\Model\Log\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\MagazynPrzyja\Mapper
	 * 
	 * Maper tabeli w bazie: modul_magazyn_przyja

	 * @return \Generic\Model\MagazynPrzyja\Mapper
	 */
	public function MagazynPrzyja()
	{
		return $this->pobierz('Generic\Model\MagazynPrzyja\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\MagazynPrzyjeteProdukty\Mapper
	 * 
	 * Maper tabeli w bazie: modul_magazyn_przyjete_produkty

	 * @return \Generic\Model\MagazynPrzyjeteProdukty\Mapper
	 */
	public function MagazynPrzyjeteProdukty()
	{
		return $this->pobierz('Generic\Model\MagazynPrzyjeteProdukty\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\MagazynWydane\Mapper
	 * 
	 * Maper tabeli w bazie: modul_magazyn_wydane

	 * @return \Generic\Model\MagazynWydane\Mapper
	 */
	public function MagazynWydane()
	{
		return $this->pobierz('Generic\Model\MagazynWydane\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\MagazynWydaneProdukty\Mapper
	 * 
	 * Maper tabeli w bazie: modul_magazyn_wydane_produkty

	 * @return \Generic\Model\MagazynWydaneProdukty\Mapper
	 */
	public function MagazynWydaneProdukty()
	{
		return $this->pobierz('Generic\Model\MagazynWydaneProdukty\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Mailing\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących dokumenty.
 	 * @author Konrad Rudowski
 	 * @package dane
 
	 * @return \Generic\Model\Mailing\Mapper
	 */
	public function Mailing()
	{
		return $this->pobierz('Generic\Model\Mailing\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Notes\Mapper
	 * 
	 * Maper tabeli w bazie: modul_notes

	 * @return \Generic\Model\Notes\Mapper
	 */
	public function Notes()
	{
		return $this->pobierz('Generic\Model\Notes\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Obserwator\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z pliku dla obiektów obserwatora.
 	 * @author Krzysztof Żak
 	 * @package dane
 
	 * @return \Generic\Model\Obserwator\Mapper
	 */
	public function Obserwator()
	{
		return $this->pobierz('Generic\Model\Obserwator\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Platnosc\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących płatności.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\Platnosc\Mapper
	 */
	public function Platnosc()
	{
		return $this->pobierz('Generic\Model\Platnosc\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PlatnoscHistoria\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiersze historii dla płatności.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\PlatnoscHistoria\Mapper
	 */
	public function PlatnoscHistoria()
	{
		return $this->pobierz('Generic\Model\PlatnoscHistoria\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PlikPrywatny\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących pliki prywatne.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\PlikPrywatny\Mapper
	 */
	public function PlikPrywatny()
	{
		return $this->pobierz('Generic\Model\PlikPrywatny\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PlikPrywatnyRolaPowiazanie\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania plików prywatnych z rolami.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\PlikPrywatnyRolaPowiazanie\Mapper
	 */
	public function PlikPrywatnyRolaPowiazanie()
	{
		return $this->pobierz('Generic\Model\PlikPrywatnyRolaPowiazanie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PlikPrywatnyUzytkownikPowiazanie\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania plików prywatnych z użytkownikami.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\PlikPrywatnyUzytkownikPowiazanie\Mapper
	 */
	public function PlikPrywatnyUzytkownikPowiazanie()
	{
		return $this->pobierz('Generic\Model\PlikPrywatnyUzytkownikPowiazanie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Polaczenia\Mapper
	 * 
	 * Maper tabeli w bazie: modul_polaczenia

	 * @return \Generic\Model\Polaczenia\Mapper
	 */
	public function Polaczenia()
	{
		return $this->pobierz('Generic\Model\Polaczenia\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Powiazanie\Mapper
	 * 
	 * @return \Generic\Model\Powiazanie\Mapper
	 */
	public function Powiazanie()
	{
		return $this->pobierz('Generic\Model\Powiazanie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PowiazanieTyp\Mapper
	 * 
	 * @return \Generic\Model\PowiazanieTyp\Mapper
	 */
	public function PowiazanieTyp()
	{
		return $this->pobierz('Generic\Model\PowiazanieTyp\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PowiazanieTypy\Mapper
	 * 
	 * @return \Generic\Model\PowiazanieTypy\Mapper
	 */
	public function PowiazanieTypy()
	{
		return $this->pobierz('Generic\Model\PowiazanieTypy\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\PozycjaMenuAplikacji\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy elementów menu aplikacji.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\PozycjaMenuAplikacji\Mapper
	 */
	public function PozycjaMenuAplikacji()
	{
		return $this->pobierz('Generic\Model\PozycjaMenuAplikacji\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Produkt\Mapper
	 * 
	 * Maper tabeli w bazie: modul_produkty

	 * @return \Generic\Model\Produkt\Mapper
	 */
	public function Produkt()
	{
		return $this->pobierz('Generic\Model\Produkt\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ProduktyMagazyn\Mapper
	 * 
	 * Maper tabeli w bazie: modul_produkty_magazyn

	 * @return \Generic\Model\ProduktyMagazyn\Mapper
	 */
	public function ProduktyMagazyn()
	{
		return $this->pobierz('Generic\Model\ProduktyMagazyn\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ProduktyZakupione\Mapper
	 * 
	 * Maper tabeli w bazie: modul_produkty_zakupione

	 * @return \Generic\Model\ProduktyZakupione\Mapper
	 */
	public function ProduktyZakupione()
	{
		return $this->pobierz('Generic\Model\ProduktyZakupione\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Projekt\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących projekty.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Projekt\Mapper
	 */
	public function Projekt()
	{
		return $this->pobierz('Generic\Model\Projekt\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RaportEdytowalny\Mapper
	 * 
	 * Maper tabeli w bazie: modul_raporty_edytowalne

	 * @return \Generic\Model\RaportEdytowalny\Mapper
	 */
	public function RaportEdytowalny()
	{
		return $this->pobierz('Generic\Model\RaportEdytowalny\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RaportyExcelDane\Mapper
	 * 
	 * Maper tabeli w bazie: modul_raporty_excel_dane

	 * @return \Generic\Model\RaportyExcelDane\Mapper
	 */
	public function RaportyExcelDane()
	{
		return $this->pobierz('Generic\Model\RaportyExcelDane\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RaportyNadgodziny\Mapper
	 * 
	 * Maper tabeli w bazie: modul_raporty_nadgodziny

	 * @return \Generic\Model\RaportyNadgodziny\Mapper
	 */
	public function RaportyNadgodziny()
	{
		return $this->pobierz('Generic\Model\RaportyNadgodziny\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RegulaRoutingu\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z pliku dla obiektów regul routingu.
 	 * @author Konrad Rudowski
 	 * @package dane
 
	 * @return \Generic\Model\RegulaRoutingu\Mapper
	 */
	public function RegulaRoutingu()
	{
		return $this->pobierz('Generic\Model\RegulaRoutingu\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Reports\Mapper
	 * 
	 * Maper tabeli w bazie: modul_reports

	 * @return \Generic\Model\Reports\Mapper
	 */
	public function Reports()
	{
		return $this->pobierz('Generic\Model\Reports\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Rola\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących role użytkowników.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Rola\Mapper
	 */
	public function Rola()
	{
		return $this->pobierz('Generic\Model\Rola\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RolaUprawnienie\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących połączenia ról uprawnieniami.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\RolaUprawnienie\Mapper
	 */
	public function RolaUprawnienie()
	{
		return $this->pobierz('Generic\Model\RolaUprawnienie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RolaUprawnienieAdministracyjne\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących połączenia ról uprawnieniami administracyjnymi.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\RolaUprawnienieAdministracyjne\Mapper
	 */
	public function RolaUprawnienieAdministracyjne()
	{
		return $this->pobierz('Generic\Model\RolaUprawnienieAdministracyjne\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RolaUprawnienieObiektu\Mapper
	 * 
	 * Maper tabeli w bazie: RolaUprawnienieObiektu

	 * @return \Generic\Model\RolaUprawnienieObiektu\Mapper
	 */
	public function RolaUprawnienieObiektu()
	{
		return $this->pobierz('Generic\Model\RolaUprawnienieObiektu\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\RoleUprawnieniaEvents\Mapper
	 * 
	 * Maper tabeli w bazie: cms_role_uprawnienia_events

	 * @return \Generic\Model\RoleUprawnieniaEvents\Mapper
	 */
	public function RoleUprawnieniaEvents()
	{
		return $this->pobierz('Generic\Model\RoleUprawnieniaEvents\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Sms\Mapper
	 * 
	 * Maper tabeli w bazie: modul_sms

	 * @return \Generic\Model\Sms\Mapper
	 */
	public function Sms()
	{
		return $this->pobierz('Generic\Model\Sms\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\StawkaUzytkownika\Mapper
	 * 
	 * Maper tabeli w bazie: modul_stawka_uzytkownika

	 * @return \Generic\Model\StawkaUzytkownika\Mapper
	 */
	public function StawkaUzytkownika()
	{
		return $this->pobierz('Generic\Model\StawkaUzytkownika\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\StronaOpisowa\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących strony opisowe.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\StronaOpisowa\Mapper
	 */
	public function StronaOpisowa()
	{
		return $this->pobierz('Generic\Model\StronaOpisowa\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TabelaPodatkowa\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tabela_podatkowa

	 * @return \Generic\Model\TabelaPodatkowa\Mapper
	 */
	public function TabelaPodatkowa()
	{
		return $this->pobierz('Generic\Model\TabelaPodatkowa\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Team\Mapper
	 * 
	 * Maper tabeli w bazie: modul_team

	 * @return \Generic\Model\Team\Mapper
	 */
	public function Team()
	{
		return $this->pobierz('Generic\Model\Team\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenDzial\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_dzial

	 * @return \Generic\Model\TidsbankenDzial\Mapper
	 */
	public function TidsbankenDzial()
	{
		return $this->pobierz('Generic\Model\TidsbankenDzial\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenGodzinyUzytkownika\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_godziny_uzytkownika

	 * @return \Generic\Model\TidsbankenGodzinyUzytkownika\Mapper
	 */
	public function TidsbankenGodzinyUzytkownika()
	{
		return $this->pobierz('Generic\Model\TidsbankenGodzinyUzytkownika\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenHours\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_hours

	 * @return \Generic\Model\TidsbankenHours\Mapper
	 */
	public function TidsbankenHours()
	{
		return $this->pobierz('Generic\Model\TidsbankenHours\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenKolekcja\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_kolekcja

	 * @return \Generic\Model\TidsbankenKolekcja\Mapper
	 */
	public function TidsbankenKolekcja()
	{
		return $this->pobierz('Generic\Model\TidsbankenKolekcja\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenProdukty\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_produkty

	 * @return \Generic\Model\TidsbankenProdukty\Mapper
	 */
	public function TidsbankenProdukty()
	{
		return $this->pobierz('Generic\Model\TidsbankenProdukty\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TidsbankenUzytkownikKolekcja\Mapper
	 * 
	 * Maper tabeli w bazie: modul_tidsbanken_uzytkownik_kolekcja

	 * @return \Generic\Model\TidsbankenUzytkownikKolekcja\Mapper
	 */
	public function TidsbankenUzytkownikKolekcja()
	{
		return $this->pobierz('Generic\Model\TidsbankenUzytkownikKolekcja\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Timelist\Mapper
	 * 
	 * Maper tabeli w bazie: modul_timelist

	 * @return \Generic\Model\Timelist\Mapper
	 */
	public function Timelist()
	{
		return $this->pobierz('Generic\Model\Timelist\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\TimelistWolne\Mapper
	 * 
	 * Maper tabeli w bazie: modul_timelist_wolne

	 * @return \Generic\Model\TimelistWolne\Mapper
	 */
	public function TimelistWolne()
	{
		return $this->pobierz('Generic\Model\TimelistWolne\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\UdostepnianyPlik\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących pliki udostępniane.
 	 * @author Krzysztof Lesiczka, Dariusz Półtorak
 	 * @package dane
 
	 * @return \Generic\Model\UdostepnianyPlik\Mapper
	 */
	public function UdostepnianyPlik()
	{
		return $this->pobierz('Generic\Model\UdostepnianyPlik\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\UkladStrony\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z plików dla obiektów odwzorowujących układów stron(z regionami).
 	 * @author Krzysztof Lesiczka, Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\UkladStrony\Mapper
	 */
	public function UkladStrony()
	{
		return $this->pobierz('Generic\Model\UkladStrony\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Uprawnienie\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących uprawnienia do podstron.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\Uprawnienie\Mapper
	 */
	public function Uprawnienie()
	{
		return $this->pobierz('Generic\Model\Uprawnienie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\UprawnienieAdministracyjne\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących uprawnienia do modułów administracyjnych.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\UprawnienieAdministracyjne\Mapper
	 */
	public function UprawnienieAdministracyjne()
	{
		return $this->pobierz('Generic\Model\UprawnienieAdministracyjne\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\UprawnienieObiektu\Mapper
	 * 
	 * Maper tabeli w bazie: UprawnienieObiektu

	 * @return \Generic\Model\UprawnienieObiektu\Mapper
	 */
	public function UprawnienieObiektu()
	{
		return $this->pobierz('Generic\Model\UprawnienieObiektu\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Uzytkownik\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących użytkowników.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\Uzytkownik\Mapper
	 */
	public function Uzytkownik()
	{
		return $this->pobierz('Generic\Model\Uzytkownik\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\UzytkownikRola\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania ról z użytkownikami.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\UzytkownikRola\Mapper
	 */
	public function UzytkownikRola()
	{
		return $this->pobierz('Generic\Model\UzytkownikRola\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Widok\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących widoki z układem treści.
 	 * @author Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\Widok\Mapper
	 */
	public function Widok()
	{
		return $this->pobierz('Generic\Model\Widok\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\WidokPowiazania\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania widoku z użytkownikiem/grupą/akcją.
 	 * @author Marek Bar
 	 * @package dane
 
	 * @return \Generic\Model\WidokPowiazania\Mapper
	 */
	public function WidokPowiazania()
	{
		return $this->pobierz('Generic\Model\WidokPowiazania\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\WierszKonfiguracji\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiersze konfiguracji.
 	 * @author Krzysztof Lesiczka, Łukasz Wrucha
 	 * @package dane
 
	 * @return \Generic\Model\WierszKonfiguracji\Mapper
	 */
	public function WierszKonfiguracji()
	{
		return $this->pobierz('Generic\Model\WierszKonfiguracji\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\WierszTlumaczen\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiersze tłumaczeń.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\WierszTlumaczen\Mapper
	 */
	public function WierszTlumaczen()
	{
		return $this->pobierz('Generic\Model\WierszTlumaczen\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZadanieCykliczne\Mapper
	 * 
 	 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących zadania cykliczne.
 	 * @author Krzysztof Lesiczka
 	 * @package dane
 
	 * @return \Generic\Model\ZadanieCykliczne\Mapper
	 */
	public function ZadanieCykliczne()
	{
		return $this->pobierz('Generic\Model\ZadanieCykliczne\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Zalacznik\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zalaczniki

	 * @return \Generic\Model\Zalacznik\Mapper
	 */
	public function Zalacznik()
	{
		return $this->pobierz('Generic\Model\Zalacznik\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZamowieniaBm\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienia_bm

	 * @return \Generic\Model\ZamowieniaBm\Mapper
	 */
	public function ZamowieniaBm()
	{
		return $this->pobierz('Generic\Model\ZamowieniaBm\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZamowieniaTemp\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienia_temp

	 * @return \Generic\Model\ZamowieniaTemp\Mapper
	 */
	public function ZamowieniaTemp()
	{
		return $this->pobierz('Generic\Model\ZamowieniaTemp\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\Zamowienie\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienia

	 * @return \Generic\Model\Zamowienie\Mapper
	 */
	public function Zamowienie()
	{
		return $this->pobierz('Generic\Model\Zamowienie\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZamowieniePdf\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienie_pdf

	 * @return \Generic\Model\ZamowieniePdf\Mapper
	 */
	public function ZamowieniePdf()
	{
		return $this->pobierz('Generic\Model\ZamowieniePdf\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZamowienieRaport\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienia

	 * @return \Generic\Model\ZamowienieRaport\Mapper
	 */
	public function ZamowienieRaport()
	{
		return $this->pobierz('Generic\Model\ZamowienieRaport\Mapper');
	}

	/**
	 * Zwraca instancję klasy Generic\Model\ZamowienieTyp\Mapper
	 * 
	 * Maper tabeli w bazie: modul_zamowienia_typy

	 * @return \Generic\Model\ZamowienieTyp\Mapper
	 */
	public function ZamowienieTyp()
	{
		return $this->pobierz('Generic\Model\ZamowienieTyp\Mapper');
	}


	/**
	 * Zwraca instancję klasy Generic\ModelNosql\LogProcesow
	 * 
	 * @return \Generic\ModelNosql\LogProcesow
	 */
	public function LogProcesow()
	{
		return \Generic\Biblioteka\Cms::inst()->Baza('mongo')->pobierzMongo()->getRepository('Generic\ModelNosql\LogProcesow');
	}

	/**
	 * Zwraca instancję klasy Generic\ModelNosql\LogZdarzen
	 * 
	 * @return \Generic\ModelNosql\LogZdarzen
	 */
	public function LogZdarzen()
	{
		return \Generic\Biblioteka\Cms::inst()->Baza('mongo')->pobierzMongo()->getRepository('Generic\ModelNosql\LogZdarzen');
	}

	/**
	 * Zwraca instancję klasy Generic\ModelNosql\UzytkownikWersja
	 * 
	 * @return \Generic\ModelNosql\UzytkownikWersja
	 */
	public function UzytkownikWersja()
	{
		return \Generic\Biblioteka\Cms::inst()->Baza('mongo')->pobierzMongo()->getRepository('Generic\ModelNosql\UzytkownikWersja');
	}

}
