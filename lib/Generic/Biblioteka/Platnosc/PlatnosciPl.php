<?php
namespace Generic\Biblioteka\Platnosc;
use Generic\Model\Platnosc;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca system platnosci Platnosci.pl
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class PlatnosciPl
{

	/**
	 * Tablica konfiguracji początkowej
	 *
	 * @var array
	 */
	protected $konfiguracja = array(
		'id_punktu_sklepu' => '',
		'klucz_punktu_sklepu' => '',
		'klucz_nadawczy' => '',
		'klucz_odbiorczy' => '',
	);


	/**
	 * Tablica tłumaczeń początkowych
	 *
	 * @var array
	 */
	protected $tlumaczenia = array(
		'pola_wysylane' => array(
			'amount' => 'Kwota w groszach',
			'city' => 'Miasto',
			'client_ip' => 'Adres IP klienta',
			'country' => 'Kod kraju klienta',
			'desc2' => 'Dowolna informacja',
			'desc' => 'Krótki opis',
			'email' => 'Adres email',
			'first_name' => 'Imię',
			'js' => 'Obsługa JavaScript',
			'language' => 'Kod języka ',
			'last_name' => 'Nazwisko',
			'order_id' => 'Numer zamówienia',
			'payback_login' => 'Login PAYBACK',
			'pay_type' => 'Typ płatności',
			'phone' => 'Numer telefonu',
			'pos_auth_key' => 'Klucz punkt sklepu',
			'pos_id' => 'Punkt sklepu',
			'post_code' => 'Kod pocztowy',
			'session_id' => 'Identyfikator płatności',
			'sig' => 'Suma kontrolna',
			'street_an' => 'Numer mieszkania',
			'street_hn' => 'Numer domu',
			'street' => 'Ulica',
			'trsDesc' => 'Dodatkowy opis transakcji',
			'ts' => 'Znacznik czasowy',
		),
		'pola_odbierane' => array(
			'status' => 'Status przetworzenia komunikatu',
			'trans_id' => 'Identyfikator transakcji w Platnosci.pl',
			'trans_pos_id' => 'Identyfikator punktu',
			'trans_session_id' => 'Identyfikator transakcji',
			'trans_order_id' => 'Identyfikator zamówienia',
			'trans_amount' => 'Aktualna wartość transakcji w groszach',
			'trans_status' => 'Aktualny status transakcji',
			'trans_pay_type' => 'Typ płatności',
			'trans_pay_gw_name' => 'Bramka realizująca transakcję',
			'trans_desc' => 'Opis transakcji',
			'trans_desc2' => 'Dodatkowy opis transakcji',
			'trans_create' => 'Data utworzenia transakcji',
			'trans_init' => 'Data rozpoczęcia transakcji',
			'trans_sent' => 'Data przekazania transakcji do odbioru',
			'trans_recv' => 'Data odbioru transakcji',
			'trans_cancel' => 'Data anulowania transakcji',
			'trans_auth_fraud' => 'Informacja wewnętrzna',
			'trans_ts' => 'Znacznik czasowy',
			'trans_sig' => 'Suma kontrolna',
			'add_cc_number_hash' => 'Hash numeru konta bankowego nadawcy płatności',
			'add_cc_number_hash' => 'Hash numeru karty płatniczej nadawcy płatności',
			'add_cc_bin' => 'BIN - numer identyfikacyjny banku - wystawcy karty',
			'add_cc_number_hash' => 'Hash numeru konta bankowego nadawcy płatności',
			'add_cc_number' => 'Numer rachunku bankowego odbiorcy płatności',
			'add_owner_name' => 'Nazwa odbiorcy płatności',
			'add_owner_address' => 'Adres odbiorcy płatności',
			'add_trans_title' => 'Tytuł płatności',
			'add_cc_number' => 'Numer rachunku bankowego odbiorcy płatności',
			'add_bank_name' => 'Nazwa banku odbiorcy płatności',
			'add_owner_name' => 'Nazwa odbiorcy płatności',
			'add_owner_address' => 'Adres odbiorcy płatności',
			'add_trans_title' => 'Tytuł płatności',
			'add_trans_prev' => 'Link do strony z podglądem druku przelwu bankowego',
			'add_test' => 'Płatność testowa',
			'add_testid' => 'Identyfikator transakcji testowej',
		),
		'kody_bledow' => array(
			'100' => 'Brak parametru pos_id',
			'101' => 'Brak parametru session_id',
			'102' => 'Brak parametru ts',
			'103' => 'Brak parametru sig',
			'104' => 'Brak parametru desc',
			'105' => 'Brak parametru client_ip',
			'106' => 'Brak parametru first_name',
			'107' => 'Brak parametru last_name',
			'108' => 'Brak parametru street',
			'109' => 'Brak parametru city',
			'110' => 'Brak parametru post_code',
			'111' => 'Brak parametru amount',
			'112' => 'Błędny numer konta bankowego',
			'200' => 'Inny chwilowy błąd',
			'201' => 'Inny chwilowy błąd bazy danych',
			'202' => 'POS o podanym identyfikatorze jest zablokowany',
			'203' => 'Niedozwolona wartość pay_type dla danego pos_id',
			'204' => 'Podana metoda płatności (wartość pay_type) jest chwilowo zablokowana dla danego pos_id, np. przerwa konserwacyjna bramki płatniczej',
			'205' => 'Kwota transakcji mniejsza od wartości minimalnej',
			'206' => 'Kwota transakcji większa od wartości maksymalnej',
			'207' => 'Przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym',
			'208' => 'POS działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)',
			'209' => 'Błedny numer pos_id lub pos_auth_key',
			'500' => 'Transakcja nie istnieje',
			'501' => 'Brak autoryzacji dla danej transakcji',
			'502' => 'Transakcja rozpoczęta wcześniej',
			'503' => 'Autoryzacja do transakcji była juz przeprowadzana',
			'504' => 'Transakcja anulowana wczesniej',
			'505' => 'Transakcja przekazana do odbioru wcześniej',
			'506' => 'Transakcja już odebrana',
			'507' => 'Błąd podczas zwrotu środków do klienta',
			'599' => 'Błędny stan transakcji, np. nie można uznać transakcji kilka razy lub inny, prosimy o kontakt',
			'999' => 'Błąd krytyczny - prosimy o kontakt',
		),
		'statusy' => array(
			'1' => 'Nowa nierozpoczęta',
			'2' => 'Anulowana',
			'3' => 'Odrzucona',
			'4' => 'Rozpoczęta',
			'5' => 'Oczekuje na odbiór',
			'7' => 'Odrzucona, otrzymano środki od klienta po wcześniejszym anulowaniu transakcji, lub nie było możliwości zwrotu środków w sposób automatyczny',
			'99' => 'Płatność odebrana - zakończona',
			'888' => 'Błędny status - prosimy o kontakt',
		),
		'typy_platnosci' => array(
			'm' => 'mTransfer - mBank',
			'n' => 'MultiTransfer - MultiBank',
			'w' => 'BZWBK - Przelew24',
			'o' => 'Pekao24Przelew - Bank Pekao',
			'i' => 'Płacę z Inteligo',
			'd' => 'Płać z Nordea',
			'p' => 'Płać z iPKO',
			'h' => 'Płać z BPH',
			'g' => 'Płać z ING',
			'l' => 'LUKAS e-przelew',
			'u' => 'Eurobank',
			'me' => 'Meritum Bank',
			'wp' => 'Przelew z Polbank',
			'wm' => 'Przelew z Millennium',
			'wk' => 'Przelew z Kredyt Bank',
			'wg' => 'Przelew z BGŻ',
			'wd' => 'Przelew z Deutsche Bank',
			'wr' => 'Przelew z Raiffeisen Bank',
			'wc' => 'Przelew z Citibank',
			'wn' => 'Przelew z Invest Bank',
			'wi' => 'Przelew z Getin Bank',
			'wy' => 'Przelew z Bankiem Pocztowym',
			'c' => 'Karta kredytowa',
			'b' => 'Przelew bankowy',
			't' => 'Płatność testowa',
		),
	);



	/**
	 * Sprawdza dane potrzebne do wygenerowania płatności
	 *
	 * @param Platnosc $platnosc obiekt nowej płatności
	 * @param array $dane dane dodatkowe na podstwie któruch zostanie wygenerowany formularz
	 *
	 * @return array|false
	 */
	public function przygotuj(Platnosc\Obiekt $platnosc, Array $dane = array())
	{
		$pola = array(
			// identyfikator oddzialu sklepu nadany przez Platnosci.pl
			'pos_id' => $this->konfiguracja['id_punktu_sklepu'],
			// haslo oddziału sklepu nadany przez Platnosci.pl
			'pos_auth_key' => substr(trim($this->konfiguracja['klucz_punktu_sklepu']),0,7),
			// identyfikator płatności unikalny dla klienta - u nas id platnosci
			'session_id' => substr(trim($platnosc->id),0,1024),
			// numer zamówienia - u nas powiazany obiekt i jego id
			'order_id' => substr(trim($platnosc->typObiektu.'_'.$platnosc->idObiektu),0,1024),
			// kwota w groszach
			//'amount' => substr(trim(100*intval(strtr($platnosc->kwota, array(','=>'.',' '=>'')))),0,10),
			'amount' => intval(100*round(floatval($platnosc->kwota), 2)),
			// typ platnosci, w przypadku braku wyświetli się okno z wyborem wszystkich typów płatności dostępnych dla danego klienta
			'pay_type' => trim($platnosc->typPlatnosci),
			// krótki opis - pokazywany klientowi, trafia na wyciągi i inne miejsca
			'desc' => substr(trim($platnosc->opis),0,50),
			// dodatkowy opis transakcji dla przelewów bankowych
			//'trsDesc' => substr(trim($dane['opisTransakcji']),0,27),
			// imie użytkownika
			'first_name' => substr(trim($platnosc->imie),0,100),
			// nazwisko użytkownika
			'last_name' => substr(trim($platnosc->nazwisko),0,100),
			// ulica
			'street' => substr(trim($platnosc->ulica),0,100),
			// numer domu
			'street_hn' => substr(trim($platnosc->nrDomu),0,10),
			// numer mieszkania
			'street_an' => substr(trim($platnosc->nrLokalu),0,10),
			// miasto
			'city' => substr(trim($platnosc->miasto),0,100),
			// kod pocztowy
			'post_code' => substr(trim($platnosc->kodPocztowy),0,20),
			// kod kraju klienta (dwuliterowy) zgodnie z ISO-3166 http://www.chemie.fu-berlin.de/diverse/doc/ISO_3166.html
			'country' => substr(trim($platnosc->kraj),0,100),
			// adres email użytkownika
			'email' => substr(trim($platnosc->email),0,100),
			// numer telefonu, można podać kilka numerów rozdzielając je przecinakami
			'phone' => substr(trim($platnosc->telefon),0,100),
			// kod języka zgodnie z ISO-639 http://www.ics.uci.edu/pub/ietf/http/related/iso639.txt (aktualnie pl, en)
			'language' => (isset($dane['jezyk'])) ? substr(trim($dane['jezyk']),0,2) : '',
			//payback_login
			'payback_login' => (isset($dane['loginPayback'])) ? substr(trim($dane['loginPayback']),0,40) : '',
			// adres IP klienta w formacie D{1,3}.D{1,3}.D{1,3}.D{1,3}
			'client_ip' => substr(trim(Zadanie::adresIp()),0,17),
			// znacznik czasowy wykorzystywany do obliczenia wartości sig
			'ts' => date('Y-m-d H:i:s'),
			// suma kontrolna przesyłanych parametrów formularza
			'sig' => ''
		);
		// obliczamy sume kontrolna
		$pola['sig'] = md5(
			$pola['pos_id'].$pola['pay_type'].$pola['session_id'].$pola['pos_auth_key'].$pola['amount'].
			$pola['desc'].$pola['order_id'].$pola['first_name'].$pola['last_name'].$pola['payback_login'].
			$pola['street'].$pola['street_hn'].$pola['street_an'].$pola['city'].$pola['post_code'].$pola['country'].
			$pola['email'].$pola['phone'].$pola['language'].$pola['client_ip'].$pola['ts'].$this->konfiguracja['klucz_nadawczy']
		);

		$wymagane = array('pos_id','pos_auth_key','session_id','order_id','amount','desc','last_name','first_name','email','client_ip','ts','sig');

		$braki = array();
		foreach ($pola as $nazwa_pola => $wartosc)
		{
			if ($wartosc == '')
			{
				if (in_array($nazwa_pola, $wymagane)) $braki[] = $nazwa_pola;
				unset($pola[$nazwa_pola]);
			}
		}
		if (count($braki) > 0)
		{
			trigger_error('Brak pol: '.implode(',', $braki), E_USER_WARNING);
			return;
		}
		return $pola;
	}



	/**
	 * Sprawdza status płatności w serwisie Platnosci.pl
	 * Zwraca tablicę z polami: wyslane(array), odebrane(array), status(string)
	 *
	 * @param Platnosc $platnosc Obiekt platnosci
	 *
	 * @return array
	 */
	public function status(Platnosc\Obiekt $platnosc)
	{
		$znacznik_czasowy = date('Y-m-d H:i:s');

		$dane_wyslane = array(
			'pos_id' => $this->konfiguracja['id_punktu_sklepu'],
			'session_id' => $platnosc->id,
			'ts' => $znacznik_czasowy,
			'sig' => md5($this->konfiguracja['id_punktu_sklepu'].$platnosc->id.$znacznik_czasowy.$this->konfiguracja['klucz_nadawczy']),
		);

		/*
		 * Statusy po stonie platnosci:
		 * 1 - nowa
		 * 2 - anulowana
		 * 3 - odrzucona
		 * 4 - rozpoczęta
		 * 5 - oczekuje na odbiór
		 * 7 - zwrot środków do klienta
		 * 99 - płatność odebrana - zakończona
		 * 888 - błędny status - prosimy o kontakt
		 */

		$statusy = array(
			'1' => 'nowa', // mozna jeszcze anulowac
			'2' => 'anulowana',
			'3' => 'odrzucona',
			'4' => 'oczekujaca', // nie mozna juz anulowac
			'5' => 'oczekujaca', // nie mozna juz anulowac
			'6' => 'blad', // nie powinien wystapic
			'7' => 'odrzucona', // nie powinien wystapic
			'99' => 'zakonczona',
			'888' => 'blad',
		);

		$dane_odebrane = $this->wyslijZadanie('status', $dane_wyslane, 'txt');

		$status = (isset($dane_odebrane['trans_status'])) ? $statusy[trim($dane_odebrane['trans_status'])] : 'blad';

		// Jeżeli transakcja nie istnieje ustawiamy status na anulowano
		if (isset($dane_odebrane['error_nr']) && $dane_odebrane['error_nr'] == '500') $status = 'nierozpoczeta';

		return array(
			'wyslane' => $dane_wyslane,
			'odebrane' => $dane_odebrane,
			'status' => $status,
		);
	}



	/**
	 * Dokonuje potwierdzenia płatności w serwisie Platnosci.pl
	 * Zwraca tablicę z polami: wyslane(array), odebrane(array)
	 *
	 * @param Platnosc $platnosc Obiekt platnosci
	 *
	 * @return array
	 */
	public function potwierdz(Platnosc\Obiekt $platnosc)
	{
		$znacznik_czasowy = date('Y-m-d H:i:s');

		$dane_wyslane = array(
			'pos_id' => $this->konfiguracja['id_punktu_sklepu'],
			'session_id' => $platnosc->id,
			'ts' => $znacznik_czasowy,
			'sig' => md5($this->konfiguracja['id_punktu_sklepu'].$platnosc->id.$znacznik_czasowy.$this->konfiguracja['klucz_nadawczy']),
		);

		$dane_odebrane = $this->wyslijZadanie('potwierdz', $dane_wyslane, 'txt');

		return array(
			'wyslane' => $dane_wyslane,
			'odebrane' => $dane_odebrane,
			'status' => (isset($dane_odebrane['status']) && $dane_odebrane['status'] == 'OK')
		);
	}



	/**
	 * Anuluje płatność w serwisie Platnosci.pl
	 * Zwraca tablicę z polami: wyslane(array), odebrane(array)
	 *
	 * @param Platnosc $platnosc Obiekt platnosci
	 *
	 * @return array
	 */
	public function anuluj(Platnosc\Obiekt $platnosc)
	{
		$znacznik_czasowy = date('Y-m-d H:i:s');

		$dane_wyslane = array(
			'pos_id' => $this->konfiguracja['id_punktu_sklepu'],
			'session_id' => $platnosc->id,
			'ts' => $znacznik_czasowy,
			'sig' => md5($this->konfiguracja['id_punktu_sklepu'].$platnosc->id.$znacznik_czasowy.$this->konfiguracja['klucz_nadawczy']),
		);

		$dane_odebrane = $this->wyslijZadanie('anuluj', $dane_wyslane, 'txt');

		return array(
			'wyslane' => $dane_wyslane,
			'odebrane' => $dane_odebrane,
			'status' => (isset($dane_odebrane['status']) && $dane_odebrane['status'] == 'OK')
		);
	}



	/**
	 * Odbiera powiadomienie o stanie płatności wysłane z serwisu Platnosci.pl
	 * Zwraca tablicę z polami: wyslane(array), odebrane(array), id(integer)
	 *
	 * @return array
	 */
	public function odbierzPowiadomienie()
	{
		$id_platnosci = Zadanie::pobierzPost('session_id');
		$id_punktu_sklepu = Zadanie::pobierzPost('pos_id');
		$znacznik_czasowy = Zadanie::pobierzPost('ts');
		$suma_kontrolna = Zadanie::pobierzPost('sig');

		if ($id_platnosci == null)
		{
			trigger_error('Brak id platnosci w parametrach', E_USER_WARNING);
			return;
		}
		if ($id_punktu_sklepu != $this->konfiguracja['id_punktu_sklepu'])
		{
			trigger_error('Nieprawidłowy identyfikator punktu sklepu '.$id_punktu_sklepu, E_USER_WARNING);
			return;
		}
		if ($suma_kontrolna != md5($id_punktu_sklepu.$id_platnosci.$znacznik_czasowy.trim($this->konfiguracja['klucz_odbiorczy'])))
		{
			trigger_error('Sygnatura przeslana od platnosci lub wygenerowana przez sklep nie jest poprawna.', E_USER_WARNING);
			return;
		}

		return array(
			'id' => $id_platnosci,
			'wyslane' => array(),
			'odebrane' => array(
				'session_id' => $id_platnosci,
				'pos_id' => $id_punktu_sklepu,
				'ts' => $znacznik_czasowy,
				'sig' => $suma_kontrolna,
			),
		);
	}



	/**
	 * Pobiera listę z typami płatności z serwisu Platnosci.pl i zwraca ja w postaci tablicy
	 *
	 * @return array|false
	 */
	public function pobierzTypyPlatnosci()
	{
		$xml = $this->wyslijZadanie('typy', array());

		if (strpos($xml, '<paytypes>') !== false)
		{
			$xml = new \SimpleXMLElement($xml);
			$lista = array();
			foreach ($xml->children() as $pozycja)
			{
				$wiersz = array();
				foreach ($pozycja->children() as $nazwa => $wartosc)
				{
					$wiersz[$nazwa] = (string)trim($wartosc);
				}
				$lista[] = $wiersz;
			}
			return $lista;
		}
		return;
	}



	/**
	 * Generuje url do serwisu Platnosci.pl dla wybranej akcji, jeżeli nie znajdzie akcji zwraca false
	 *
	 * @param string $akcja Kod akcji, dostępne: 'nowa','potwierdz','anuluj','status','typy'
	 * @param string $formatOdpowiedzi Format w jakim ma przyjść odpowiedź - 'xml' lub 'txt'
	 *
	 * @return string|bool
	 */
	public function url($akcja, $formatOdpowiedzi = 'txt')
	{
		$formatOdpowiedzi = strtolower(trim($formatOdpowiedzi));
		$formatOdpowiedzi = ($formatOdpowiedzi == 'xml') ? 'xml' : 'txt';

		switch ($akcja)
		{
			case 'nowa': $url = 'https://www.platnosci.pl/paygw/UTF/NewPayment'; break;
			case 'potwierdz': $url = 'https://www.platnosci.pl/paygw/UTF/Payment/confirm/'.$formatOdpowiedzi; break;
			case 'anuluj': $url = 'https://www.platnosci.pl/paygw/UTF/Payment/cancel/'.$formatOdpowiedzi; break;
			case 'status': $url = 'https://www.platnosci.pl/paygw/UTF/Payment/get/'.$formatOdpowiedzi; break;
			case 'typy': $url = 'https://www.platnosci.pl/paygw/UTF/xml/'.$this->konfiguracja['id_punktu_sklepu'].'/'.substr($this->konfiguracja['klucz_nadawczy'],0,2).'/paytype.xml'; break;
			default:
				trigger_error('Nieznana akcja', E_USER_WARNING);
				return;
			break;
		}
		return $url;
	}



	/**
	 * Wysyła żądanie i konwertuje odpowiedź do postaci tablicy jeżeli podano format w jakim przyjdzie
	 *
	 * @param string $akcja Kod akcji, dostępne: 'nowa','potwierdz','anuluj','status','typy'
	 * @param array $dane Tablica z danymi do wysłania
	 * @param string $formatOdpowiedzi Format w jakim ma przyjść odpowiedź - 'xml' lub 'txt', domyślnie puste
	 *
	 * @return array|string
	 */
	protected function wyslijZadanie($akcja, $dane, $formatOdpowiedzi = '')
	{
		$zadanie = curl_init();

		if ( ! $zadanie)
		{
			trigger_error('Inicjalizacja CURL nie powiodla sie', E_USER_WARNING);
			return;
		}

		curl_setopt_array($zadanie, array(
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $this->url($akcja, $formatOdpowiedzi),
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1, // zwracac to co przyszlo z serwera
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_CONNECTTIMEOUT => 6, // polaczenie moze zajac maksymalnie sekund
			CURLOPT_TIMEOUT => 7, //curl moze pracowac maksymalnie przez sekund
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => http_build_query($dane)
		));

		if ( ! $wynik = curl_exec($zadanie))
		{
			trigger_error('Blad CURL:'.curl_error($zadanie), E_USER_WARNING);
			return;
		}

		curl_close($zadanie);

		if ($formatOdpowiedzi == 'txt')
		{
			$wynik = $this->txt2array($wynik);
		}
		elseif ($formatOdpowiedzi == 'xml')
		{
			$wynik = $this->xml2array($xml);
		}

		return $wynik;
	}



	/**
	 * Tłumaczy opisy danych wysłanych do Platnosci.pl
	 *
	 * @param array $dane dane do przetlumaczenia
	 *
	 * @return array
	 */
	public function tlumaczWyslane($dane)
	{
		$array = array();
		foreach ($dane as $klucz => $wartosc)
		{
			$klucz = trim($klucz);
			$wartosc = trim($wartosc);
			$nowaWartosc = $wartosc;
			$nowyKlucz = $klucz;
			if ($klucz == 'pay_type' && array_key_exists($wartosc, $this->tlumaczenia['typy_platnosci']))
			{
				$nowaWartosc = $this->tlumaczenia['typy_platnosci'][$wartosc]." ({$wartosc})";
			}
			if (array_key_exists($klucz, $this->tlumaczenia['pola_wysylane']))
			{
				$nowyKlucz = $this->tlumaczenia['pola_wysylane'][$klucz]." ({$klucz})";
			}
			$array[$nowyKlucz] = $nowaWartosc;
		}
		return $array;
	}



	/**
	 * Tłumaczy opisy danych odebranych z Platnosci.pl
	 *
	 * @param array $dane dane do przetlumaczenia
	 *
	 * @return array
	 */
	public function tlumaczOdebrane($dane)
	{
		$array = array();
		foreach ($dane as $klucz => $wartosc)
		{
			$klucz = trim($klucz);
			$wartosc = trim($wartosc);
			$nowaWartosc = $wartosc;
			$nowyKlucz = $klucz;
			if ($klucz == 'trans_pay_type' && array_key_exists($wartosc, $this->tlumaczenia['typy_platnosci']))
			{
				$nowaWartosc = $this->tlumaczenia['typy_platnosci'][$wartosc]." ({$wartosc})";
			}
			if ($klucz == 'error_nr' && array_key_exists($wartosc, $this->tlumaczenia['kody_bledow']))
			{
				$nowaWartosc = $this->tlumaczenia['kody_bledow'][$wartosc]." ({$wartosc})";
			}
			if ($klucz == 'trans_status' && array_key_exists($wartosc, $this->tlumaczenia['statusy']))
			{
				$nowaWartosc = $this->tlumaczenia['statusy'][$wartosc]." ({$wartosc})";
			}
			if (array_key_exists($klucz, $this->tlumaczenia['pola_odbierane']))
			{
				$nowyKlucz = $this->tlumaczenia['pola_odbierane'][$klucz]." ({$klucz})";
			}
			$array[$nowyKlucz] = $nowaWartosc;
		}
		return $array;
	}



	/**
	 * Konwertuje tekst na tablice
	 *
	 * @param string $txt tresc tekstowa
	 *
	 * @return array
	 */
	protected function txt2array($txt)
	{
		$array = array();
		foreach (explode("\n",$txt) as $linia)
		{
			$linia = explode(':', $linia);
			$klucz = trim(array_shift($linia));
			$array[$klucz] = trim(implode(':', $linia));
		}
		return $array;
	}



	/**
	 * Konwertuje tresc XML na tablice
	 *
	 * @param string $xml tresc XML
	 *
	 * @return array
	 */
	protected function xml2array($xml)
	{
		$array = array();
		$xml = new \SimpleXMLElement($xml);
		$array = array();
		foreach ($xml->children() as $nazwa => $wartosc)
		{
			$array[$nazwa] = trim($wartosc);
		}
		return $array;
	}



	public function ustawKonfiguracje($config)
	{
		if (isset($config['id_punktu_sklepu']))
		{
			$this->konfiguracja['id_punktu_sklepu'] = trim($config['id_punktu_sklepu']);
		}
		if (isset($config['klucz_punktu_sklepu']))
		{
			$this->konfiguracja['klucz_punktu_sklepu'] = trim($config['klucz_punktu_sklepu']);
		}
		if (isset($config['klucz_nadawczy']))
		{
			$this->konfiguracja['klucz_nadawczy'] = trim($config['klucz_nadawczy']);
		}
		if (isset($config['klucz_odbiorczy']))
		{
			$this->konfiguracja['klucz_odbiorczy'] = trim($config['klucz_odbiorczy']);
		}
	}

}