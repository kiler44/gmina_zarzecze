<?php

namespace Generic\Modul\KonfiguracjaSystemu;

use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;


/**
 * Modul administracyjny odpowiedzialny za zarzadząnie konfiguracją cms-a.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */
class Admin extends Modul\System
{

    /**
     * @var \Generic\Konfiguracja\Modul\KonfiguracjaSystemu\Admin
     */
    protected $k;


    /**
     * opisy ustawien konfiguracyjnych
     * @var array
     */
    protected $opisKonfiguracjiSystemu = array(
        'idp' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia logowania idp',
        ),
        'idp.wlacz_logowanie' => array(
            'typ' => 'bool',
            'etkieta' => 'wlacz logowanie idp',
            'wartosc' => true,
        ),
        'idp.host' => array(
            'typ' => 'varchar',
            'etkieta' => 'idp host',
            'wartosc' => 'idp.bktas.no'
        ),
        'idp.cert' => array(
            'typ' => 'varchar',
            'etkieta' => 'idp cert',
            'wartosc' => '/www/norway/trunk/certs/ldap.crt'
        ),
        'clamav' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia ClamAV',
        ),
        'clamav.ip' => array(
            'typ' => 'varchar',
            'opis' => 'adres ip pod którym działa deamon clamAV (dla clamd_remote i clamd_local)',
            'etykieta' => 'deamon.ip',
            'wartosc' => '172.17.0.4'
        ),
        'clamav.port' => array(
            'typ' => 'varchar',
            'wartosc' => '3310'
        ),
        'clamav.sciezka' => array(
            'typ' => 'varchar',
            'etykieta' => 'clamav.sciezka',
        ),
        'clamav.driver' => array(
            'typ' => 'select',
            'opis' => 'driver dla clamAv',
            'etykieta' => 'deamon.driver',
            'dozwolone' => array('default', 'clamscan', 'clamd_local', 'clamd_remote'),
            'wartosc' => 'clamd_remote'
        ),
        'sesja' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia sesji',
        ),
        'sesja.nazwaSesji' => array(
            'typ' => 'varchar',
            'opis' => 'Nazwa sesji w przeglądarce',
        ),
        'sesja.czasZyciaSesji' => array(
            'opis' => 'Czas życia sesji od odświeżenia strony w przeglądarce podany w sekundach',
            'typ' => 'int',
            'maks' => 10000,
        ),
        'sesja.czasZyciaCiasteczka' => array(
            'opis' => 'Maksymalny czas życia ciasteczka(sesji) podanyw sekundach. Wartość "0"(zero) oznacza do zamkniecia przeglądarki.',
            'typ' => 'int',
            'maks' => 10000,
        ),

        'blokady' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia blokad',
        ),
        'blokady.serwis_zabezpieczony_haslem' => array(
            'opis' => 'Blokada hasłem całego serwisu',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'blokady.tryb_serwisowy' => array(
            'opis' => 'Włącza tryb serwisowy portalu',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'blokady.blokowanie_logowania' => array(
            'opis' => 'Włącza blokowanie logowania użytkowników do serwisu',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'blokady.blokowanie_rejestracji' => array(
            'opis' => 'Włącza blokowanie rejestrowania użytkowników w serwisie',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'blokady.blokowanie_aktywacji' => array(
            'opis' => 'Włącza blokowanie aktywacji konta użytkownika za pomocą linku',
            'typ' => 'bool',
            'wartosc' => 0,
        ),//patrz dane --> cms

        'bledy' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia dotyczące logowania błędów',
        ),
        'bledy.logowanie_ekran' => array(
            'opis' => 'Poziom logowania błędów wyswietlanych na ekranie',
            'typ' => 'select',
            'dozwolone' => array('NONE', 'ERROR', 'WARNING', 'NOTICE', 'ALL'),
        ),
        'bledy.logowanie_plik' => array(
            'opis' => 'Poziom logowania błędów logowanych w pliku',
            'typ' => 'select',
            'dozwolone' => array('NONE', 'ERROR', 'WARNING', 'NOTICE', 'ALL'),
        ),
        'bledy.logowanie_email' => array(
            'opis' => 'Poziom logowania błędów wysyłanych na adres email',
            'typ' => 'select',
            'dozwolone' => array('NONE', 'ERROR', 'WARNING', 'NOTICE', 'ALL'),
        ),
        'bledy.logowanie_email_adres' => array(
            'typ' => 'varchar',
            'opis' => 'Adres email na który bedą wysyłane powiadomienia o błędach',
        ),

        'baza' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia dotyczące bazy danych',
        ),
        'baza.nagrywanie_zapytan' => array(
            'opis' => 'Włącza nagrywanie zapytan typu insert, update, delete podczas pracy',
            'typ' => 'bool',
        ),

        'cache' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia dotyczące cache systemu',
        ),
        'cache.wizytowki' => array(
            'opis' => 'Włącza obsługę cache statyczny całych stron wizytówek',
            'typ' => 'bool',
        ),
        'cache.strony' => array(
            'opis' => 'Włącza obsługę cache statyczny całych stron serwisu',
            'typ' => 'bool',
        ),
        'cache.bloki' => array(
            'opis' => 'Włącza obsługę cache dla bloków',
            'typ' => 'bool',
        ),
        'cache.php' => array(
            'opis' => 'Włącza obsługę pakowania plików bibliotek php',
            'typ' => 'bool',
        ),
        'cache.tpl' => array(
            'opis' => 'Włącza obsługę pakowania plików szablonów tpl',
            'typ' => 'bool',
        ),
        'cache.baza' => array(
            'opis' => 'Włącza obsługę cache zapytań do bazy',
            'typ' => 'bool',
        ),
        'cache.znacznik' => array(
            'opis' => 'Znacznik html który bedzie dołączony do tresci cache dla podstron i wizytówek.<br>Wstawiając w tresc html zmienne: {DATA_START}, {DATA_STOP} otrzymamy czas generowania i czas ważności cache.',
            'typ' => 'array',
        ),

        'email' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia dotyczące wysyłania poczty',
        ),
        'email.smtp_host' => array(
            'typ' => 'varchar',
            'opis' => 'Adres serwera wysyłającego pocztę',
        ),
        'email.smtp_port' => array(
            'typ' => 'int',
            'opis' => 'Port serwera wysyłającego pocztę',
        ),
        'email.smtp_user' => array(
            'typ' => 'varchar',
            'opis' => 'Nazwa konta użytkownika',
        ),
        'email.smtp_pass' => array(
            'typ' => 'varchar',
            'opis' => 'Hasło do konta',
        ),
        'email.smtp_secur' => array(
            'opis' => 'Sposób zabezpieczenia połączenia z serwerem',
            'typ' => 'select',
            'dozwolone' => array('', 'ssl', 'tls'),
        ),
        'email.smtp_debug' => array(
            'opis' => 'Poziom raportowania błedów SMTP',
            'typ' => 'select',
            'dozwolone' => array(0, 1, 2, 4),
        ),
        'email.from' => array(
            'typ' => 'varchar',
            'opis' => 'Domyślny nadawca email\'i',
        ),
        'email.from_name' => array(
            'typ' => 'varchar',
            'opis' => 'Nazwa domyślnego nadawcy email\'i',
        ),
        'email.img_include' => array(
            'opis' => 'Włącza dołączanie obrazków do załącznika maila',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'email.email_dev' => array(
            'typ' => 'varchar',
            'opis' => '<strong>UWAGA! Używać z rozwagą!</strong> Email dla developera. Jeżeli zostanie tutaj wpisany email to wszystkie maile wychodzące zostaną na niego przekierowane.',
        ),

        'router' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia routingu',
        ),
        'router.blokady' => array(
            'opis' => 'Włącza blokowanie wybranych adresow url.<br>Adresy można ustawić w module routingu.',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'router.przekierowania' => array(
            'opis' => 'Włącza przekierowania starych url-i na nowe.<br>Adresy można ustawić w module routingu.',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'router.nowe_urle_kategorie' => array(
            'opis' => 'Włącza generowanie nowych url-i dla kategorii',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'router.nowe_urle_branze' => array(
            'opis' => 'Włącza generowanie nowych url-i dla branz',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'router.wlacz_filtr_url' => array(
            'opis' => 'Włącza slownik tlumaczacy parametry w adresach url',
            'typ' => 'bool',
            'wartosc' => 0,
        ),
        'router.parametry_slownik' => array(
            'opis' => 'Tablica tlumaczaca nazwy parametrów na nazwy wstawiane w adresach url',
            'typ' => 'array',
            'wartosc' => 0,
        ),
        'router.parametry_url' => array(
            'opis' => 'Parametry które bedą wklejane w scieżce adresu url.<br>UWAGA: Kolejnosc wstawiania decyduje okolejnosci pojawiania się w adresie url.',
            'typ' => 'list',
            'wartosc' => 0,
        ),

        'sphinx' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia wyszukiwarki Sphinx',
        ),
        'sphinx.oferty_host' => array(
            'opis' => 'Host dla indeksera ofert',
            'typ' => 'varchar',
        ),
        'sphinx.oferty_port' => array(
            'opis' => 'Port dla indeksera ofert',
            'typ' => 'int',
        ),
        'sphinx.wizytowki_host' => array(
            'opis' => 'Host dla indeksera wizytówek',
            'typ' => 'varchar',
        ),
        'sphinx.wizytowki_port' => array(
            'opis' => 'Port dla indeksera wizytówek',
            'typ' => 'int',
        ),

        'sms' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia smsApi',
        ),
        'sms.token' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'sms.tryb_nie_wysylaj_sms' => array(
            'opis' => '',
            'typ' => 'bool',
        ),
        'sms.tryb_testowy' => array(
            'opis' => '',
            'typ' => 'bool',
        ),
        'sms.numer_testowy_do' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'sms.nazwa_nadawcy' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'platnosci' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia dla platnosci.pl',
        ),
        'platnosci.id_punktu_sklepu' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'platnosci.klucz_punktu_sklepu' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'platnosci.klucz_nadawczy' => array(
            'opis' => 'Po stronie platnosci.pl "klucz1"',
            'typ' => 'varchar',
        ),
        'platnosci.klucz_odbiorczy' => array(
            'opis' => 'Po stronie platnosci.pl "klucz2"',
            'typ' => 'varchar',
        ),

        'katalogi' => array(
            'typ' => 'region',
            'etykieta' => 'Ścieżki katalogów na dysku',
        ),
        'katalogi.aktualnosci' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.galeria' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.czytnik_rss' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.artykuly' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.ogloszenia' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.ogloszenia_promowane' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.wizytowki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.wizytowki_zdjecia' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.wizytowki_pliki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.wizytowki_materialy' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.platnosci' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.email_zalaczniki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.private_temp' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.public_temp' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.miniatury' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.udostepniane_pliki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'katalogi.edytor_graficzny' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),

        'url' => array(
            'typ' => 'region',
            'etykieta' => 'Adresy url dla plików',
        ),
        'url.aktualnosci' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.galeria' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.artykuly' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.ogloszenia' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.ogloszenia_promowane' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.wizytowki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.wizytowki_zdjecia' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.wizytowki_pliki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.wizytowki_materialy' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.email_zalaczniki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.private_temp' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.public_temp' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.miniatury' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.udostepniane_pliki' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),
        'url.edytor_graficzny' => array(
            'opis' => '',
            'typ' => 'varchar',
        ),

        'rozdzielanie_wizytowek' => array(
            'typ' => 'region',
            'etykieta' => 'Automatyczne rozdzielanie wizytówek',
        ),
        'rozdzielanie_wizytowek.automat_wlaczony' => array(
            'opis' => 'Czy wizytówki mają być rozdzielane automatycznie?',
            'typ' => 'bool',
        ),
        'rozdzielanie_wizytowek.okres_wyliczania_statystyk' => array(
            'opis' => 'Okres wyliczenia statystyk dla uzytkowników podczas automatycznego przydzielanie. Im mniejszy tym mniejsze obciążenie systemu, ale mniej dokładne statystyki. <strong>Format zapisu zgodny z metodą strtotime(), zawsze ujemny!</strong>',
            'typ' => 'varchar',
        ),
        'rozdzielanie_wizytowek.godzin_roboczych_dziennie' => array(
            'opis' => 'Liczba godzin roboczych na dzień od 1 do 24.',
            'typ' => 'int',
        ),
        'rozdzielanie_wizytowek.uwzgledniaj_weekendy' => array(
            'opis' => 'Czy podczas rozdzielania uwzględniać weekendy?',
            'typ' => 'bool',
        ),
        'rozdzielanie_wizytowek.uwzgledniaj_urlopy' => array(
            'opis' => 'Czy podczas rozdzielania uwzględniać urlopy pracowników?',
            'typ' => 'bool',
        ),
        'rozdzielanie_wizytowek.tryb_pracy' => array(
            'opis' => 'Tryb pracy automatycznego prdzielania wizytówek. Wagowy jest rozwiązaniem prostszym opartym jedynie na wadze wizytówki. Czasowy uwzględnia dodatkowo prędkość pracy każdego z pracowników.',
            'typ' => 'select',
            'dozwolone' => array('czasowy', 'wagowy')
        ),
        'rozdzielanie_wizytowek.kody_rol' => array(
            'opis' => 'Kody ról, dla których mają być przydzielane wizytówki. <strong>UWAGA! Jeśli zostaną ustawione błędnie, wizytówki mogą być prdzielane użytkownikom, którzy nie mają możliwości ich edycji!</strong>',
            'typ' => 'list',
        ),
        'cropper' => array(
            'typ' => 'region',
            'etykieta' => 'Ustawienia domyślne dla croppera',
        ),
        'cropper.klucz_szyfrowania' => array(
            'typ' => 'varchar',
            'opis' => 'Klucz, którym są szyfrowane dane przekazywane do croppera',
        ),
    );


    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\WierszKonfiguracjiSystemu\Admin
     */
    protected $j;

    protected $plikKonfiguracja;

    protected $plikGlobalne;

    // pola konfiguracji odczytane z bazy
    protected $konfiguracjaBaza = array();


    // mapowanie kluczy konfiguracji na nazwy pól w formularzu
    protected $klucze = array();


    // obiekt dla ktorego zmieniamy konfiguracje: kategoria albo blok
    protected $obiekt;

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajSystem',
        'wykonajAdministracyjne',
        'wykonajZwykle',
        'wykonajEdytujAdministracyjny',
        'wykonajEdytujZwykly',
        'wykonajEdytujKategorie',
        'wykonajEdytujBlok',
        'wykonajCzyscSystem',
        'wykonajCzyscAdministracyjny',
        'wykonajCzyscZwykly',
        'wykonajCzyscKategorie',
        'wykonajCzyscBlok',
        'wykonajZmienneGlobalne',
        'wykonajPobierzKonfiguracje',
        'wykonajWczytajKonfiguracje',
        'wykonajSzukajFrazy',
        'opcjeSystemowe',
    );


    public function inicjuj(Sterownik $sterownik, Kategoria\Obiekt $kategoria = null, Blok\Obiekt $blok = null)
    {
        parent::inicjuj($sterownik, $kategoria, $blok);
        $cms = Cms::inst();
        $this->plikKonfiguracja = TEMP_KATALOG . '/config.inc.php';
        $this->plikGlobalne = TEMP_KATALOG . '/zmienne_globalne.inc.php';
    }


    public function wykonajIndex()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

        $dane = array(
            'link_konfiguracja' => Router::urlAdmin('Testy', 'konfiguracja'),
            'link_konfiguracja_systemu' => Router::urlAdmin('KonfiguracjaSystemu', 'system'),
            'link_konfiguracja_systemu_czysc' => Router::urlAdmin('KonfiguracjaSystemu', 'czyscSystem'),
            'link_konfiguracja_moduly_administracyjne' => Router::urlAdmin('KonfiguracjaSystemu', 'administracyjne'),
            'link_konfiguracja_moduly_zwykle' => Router::urlAdmin('KonfiguracjaSystemu', 'zwykle'),
            'link_konfiguracja_zmienne_globalne' => Router::urlAdmin('KonfiguracjaSystemu', 'zmienneGlobalne'),
            'link_wyszukiwarka' => Router::urlAdmin('KonfiguracjaSystemu', 'szukajFrazy'),
        );
        $this->tresc .= $this->szablon->parsujBlok('index', $dane);
    }


    public function wykonajSzukajFrazy()
    {
        $cms = Cms::inst();

        $fraza = Zadanie::pobierz('fraza', 'strip_tags', 'filtr_xss', 'trim');

        //	if (strlen($fraza) < 3)
        //	{
        //		$this->komunikat($this->tlumaczenia['szukajFrazy.blad.fraza_zbyt_krotka'], 'error', 'sesja');
        //		Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'index'));
        //	}

        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['szukajFrazy.tytul_strony'], $fraza)));

        $mapperModuly = DostepnyModul\Mapper::wywolaj();

        $istniejaKonfiguracjeWModulach = false;

        foreach ($mapperModuly->pobierzPrzypisane() as $modul) {
            foreach ($modul->uslugi as $usluga) {
                $grid = new TabelaDanych();
                $grid->dodajKolumne('kod', '', 0, '', true);
                $grid->dodajKolumne('nazwa', $this->j->t['szukajFrazy.etykieta_nazwa'], 300);
                $grid->dodajKolumne('wartosc', $this->j->t['szukajFrazy.etykieta_wartosc'], 300);
                $grid->dodajKolumne('dotyczy', $this->j->t['szukajFrazy.etykieta_dotyczy'], 240);

                $grid->naglowek(sprintf($this->j->t['szukajFrazy.naglowek_modulu'], $modul->nazwa . ' - ' . $usluga));

                $grid->dodajPrzyciski(
                    Router::urlAdmin('KonfiguracjaSystemu', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
                    array(
                        array(
                            'akcja' => Router::urlAdmin('KonfiguracjaSystemu', (($modul->typ == 'administracyjny') ? 'edytujAdministracyjny' : 'edytujZwykly'), array('{KLUCZ}' => '{WARTOSC}')),
                            'ikona' => 'icon-pencil',
                            'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
                            'klucz' => 'globalne',
                        ), array(
                        'akcja' => Router::urlAdmin('KonfiguracjaSystemu', 'edytujKategorie', array('id' => '{WARTOSC}')),
                        'ikona' => 'icon-pencil',
                        'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
                        'klucz' => 'kategorii',
                    ), array(
                        'akcja' => Router::urlAdmin('KonfiguracjaSystemu', 'edytujBlok', array('id' => '{WARTOSC}')),
                        'ikona' => 'icon-pencil',
                        'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
                        'klucz' => 'bloku',
                    ),
                    )
                );

                $nazwaKlasy = 'Generic\\Modul\\' . $modul->kod . '\\' . $usluga;
                $instancja = new $nazwaKlasy;

                $istniejaKonfiguracje = false;

                foreach ($instancja->pobierzKonfiguracje() as $klucz => $wartosc) {
                    if (is_array($wartosc)) {
                        foreach ($wartosc as $kluczWartosci => $wartoscWartosci) {
                            $wiersz = $this->sprawdzWierszWyszukiwania($fraza, $kluczWartosci, $wartoscWartosci, $modul->kod, $usluga, $klucz);
                            if ($wiersz !== false) {
                                switch ($wiersz['typ']) {
                                    case 'kategorii':
                                        $grid->usunPrzyciski(array('globalne', 'bloku'));
                                        break;
                                    case 'bloku':
                                        $grid->usunPrzyciski(array('globalne', 'kategorii'));
                                        break;
                                    default:
                                        $grid->usunPrzyciski(array('bloku', 'kategorii'));
                                        break;
                                }
                                $grid->dodajWiersz($wiersz);
                                $istniejaKonfiguracje = $istniejaKonfiguracjeWModulach = true;
                            }
                        }
                    } else {
                        $wiersz = $this->sprawdzWierszWyszukiwania($fraza, $klucz, $wartosc, $modul->kod, $usluga);
                        if ($wiersz !== false) {
                            switch ($wiersz['typ']) {
                                case 'kategorii':
                                    $grid->usunPrzyciski(array('globalne', 'bloku'));
                                    break;
                                case 'bloku':
                                    $grid->usunPrzyciski(array('globalne', 'kategorii'));
                                    break;
                                default:
                                    $grid->usunPrzyciski(array('bloku', 'kategorii'));
                                    break;
                            }
                            $grid->dodajWiersz($wiersz);
                            $istniejaKonfiguracje = $istniejaKonfiguracjeWModulach = true;
                        }
                    }
                }
                if ($istniejaKonfiguracje)
                    $this->tresc .= $grid->html(CMS_KATALOG . '/' . SZABLON_SYSTEM . '/' . SZABLON_TABELA_DANYCH2) . '<br />';
            }
        }

        if (!$istniejaKonfiguracjeWModulach) {
            $this->komunikat($this->j->t['szukajFrazy.nie_znaleziono'], 'info', 'sesja');
            Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'index'));
        }
    }


    protected function sprawdzWierszWyszukiwania($fraza, $klucz, $wartosc, $kodModulu, $usluga, $nazwaRodzica = '')
    {
        $mapperKonfiguracja = $this->dane()->WierszKonfiguracji();
        $mapperBloki = $this->dane()->Blok();
        $mapperKategorie = $this->dane()->Kategoria();

        $konfiguracjaZBazy = $mapperKonfiguracja->wyszukajWiersz($nazwaRodzica != '' ? $nazwaRodzica : $klucz, $kodModulu . '_' . $usluga);

        if ($konfiguracjaZBazy instanceof WierszKonfiguracji\Obiekt) {
            $wartosc = $konfiguracjaZBazy->wartosc;
            if ($nazwaRodzica != '' && $konfiguracjaZBazy->typ == 'array') {
                $daneOdserializowane = unserialize($wartosc);
                if (isset($daneOdserializowane[$klucz]))
                    $wartosc = $daneOdserializowane[$klucz];
            }
        }

        if (stripos(strtolower($klucz), $fraza) !== false || stripos(strtolower($wartosc), $fraza) !== false || stripos(strtolower($nazwaRodzica), $fraza) !== false) {
            $dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_globalne'];
            $kod = $kodModulu . '#' . $usluga . '|' . $usluga . '_' . ($nazwaRodzica != '' ? $nazwaRodzica . '_wyswietlony' : $klucz);
            $typ = 'globale';
            if ($konfiguracjaZBazy instanceof WierszKonfiguracji\Obiekt) {
                if ($konfiguracjaZBazy->idBloku) {
                    $blok = $mapperBloki->pobierzPoId($konfiguracjaZBazy->idBloku);
                    if ($blok instanceof Blok\Obiekt) {
                        $dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_bloku'] . $blok->nazwa;
                        $kod = $konfiguracjaZBazy->idBloku . '#' . $usluga . '|' . $usluga . '_' . ($nazwaRodzica != '' ? $nazwaRodzica . '_wyswietlony' : $klucz);
                        $typ = 'bloku';
                    }
                } elseif (($konfiguracjaZBazy->idKategorii)) {
                    $kategoria = $mapperKategorie->pobierzPoId($konfiguracjaZBazy->idKategorii);
                    if ($kategoria instanceof Kategoria\Obiekt) {
                        $dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_kategorii'] . $kategoria->nazwa;
                        $kod = $konfiguracjaZBazy->idKategorii . '#' . $usluga . '|' . $usluga . '_' . ($nazwaRodzica != '' ? $nazwaRodzica . '_wyswietlony' : $klucz);
                        $typ = 'kategorii';
                    }

                }

            }

            return array(
                'kod' => str_replace('.', '_', $kod),
                'nazwa' => str_ireplace($fraza, '<strong>' . $fraza . '</strong>', ($nazwaRodzica != '' ? $nazwaRodzica . '.' : '') . $klucz),
                'wartosc' => str_ireplace($fraza, '<strong>' . $fraza . '</strong>', htmlspecialchars($wartosc)),
                'dotyczy' => $dotyczy,
                'typ' => $typ,
            );
        } else
            return false;
    }


    public function wykonajSystem()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['system.tytul_strony']));

        $konfiguracja = $this->opisKonfiguracjiSystemu;

        $konfiguracjaDane = array_replace_recursive(Cms::inst()->konfiguracjaDomyslna(), konfiguracjaCzytajPlik(true));

        if (isset($konfiguracjaDane['superuzytkownik'])) unset($konfiguracjaDane['superuzytkownik']);

        $oznaczenia_bledy_typy = array(
            'NONE' => 0,
            'ERROR' => E_ERROR,
            'WARNING' => E_WARNING,
            'NOTICE' => E_NOTICE,
            'ALL' => E_ALL,
        );
        $oznaczenia_bledy_typy_odwrotne = array_flip($oznaczenia_bledy_typy);

        foreach ($konfiguracjaDane as $blok => $wiersze) {
            foreach ($wiersze as $klucz => $wartosc) {
                $kluczPelny = $blok . '.' . $klucz;
                if (in_array($kluczPelny, array('bledy.logowanie_ekran', 'bledy.logowanie_plik', 'bledy.logowanie_email'))) {
                    $wartosc = (isset($oznaczenia_bledy_typy_odwrotne[$wartosc])) ? $oznaczenia_bledy_typy_odwrotne[$wartosc] : 'NONE';
                }
                $konfiguracja[$kluczPelny]['wartosc'] = $wartosc;
            }
        }

        $urlPowrotny = Router::urlAdmin('KonfiguracjaSystemu', 'index');
        $nazwy = array();
        $formularz = $this->budujFormularz(array('System' => $konfiguracja), $nazwy, $urlPowrotny);
        if ($formularz->wypelniony() && $formularz->danePoprawne()) {
            $dane = $formularz->pobierzZmienioneWartosci();

            $nazwy = array_flip($nazwy);

            $danePlik = array();
            foreach ($konfiguracjaDane as $blok => $wiersze) {
                foreach ($wiersze as $klucz => $wartosc) {
                    $kluczPelny = $blok . '.' . $klucz;
                    if ($kluczPelny == 'bledy.logowanie_plik_nazwa') continue;
                    $danePlik[$blok][$klucz] = $konfiguracjaDane[$blok][$klucz];
                    if (isset($nazwy[$kluczPelny]) && isset($dane[$nazwy[$kluczPelny]])) {
                        $wartosc = $dane[$nazwy[$kluczPelny]];
                        if (in_array($kluczPelny, array('bledy.logowanie_ekran', 'bledy.logowanie_plik', 'bledy.logowanie_email')))
                            $wartosc = isset($oznaczenia_bledy_typy[$wartosc]) ? $oznaczenia_bledy_typy[$wartosc] : 0;
                        $danePlik[$blok][$klucz] = $wartosc;
                    }
                }
            }

            if (file_put_contents($this->plikKonfiguracja, "<?php
namespace Generic\Modul\WierszKonfiguracjiSystemu;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;
use Generic\Modul\EmailZarzadzanie;
 return " . var_export($danePlik, true) . ";\n") !== false) {
                $this->komunikat(sprintf($this->j->t['system.info_zapisano_wiersze'], count($dane)), 'info', 'sesja');
                Router::przekierujDo($urlPowrotny);
                return;
            } else {
                $this->komunikat($this->j->t['system.error_nie_mozna_zapisac_wierszy'], 'error');
            }
        }
        $this->tresc .= $this->szablon->parsujBlok('system', array(
            'form' => $formularz->html(),
        ));
    }


    public function wykonajAdministracyjne()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['administracyjne.tytul_strony']));
        $grid = $this->listaModulow('administracyjne');
        $dane['grid'] = $grid->html();
        $this->tresc .= $this->szablon->parsujBlok('administracyjne', $dane);
    }


    public function wykonajZwykle()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['zwykle.tytul_strony']));
        $grid = $this->listaModulow('zwykle');
        $dane['grid'] = $grid->html();
        $this->tresc .= $this->szablon->parsujBlok('zwykle', $dane);
    }


    public function wykonajEdytujAdministracyjny()
    {
        $urlPowrotny = Router::urlAdmin('KonfiguracjaSystemu', 'administracyjne');

        $mapper = DostepnyModul\Mapper::wywolaj();
        $modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
        if (!($modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['edytujAdministracyjny.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }
        if ($modul->typ != 'administracyjny') {
            $this->komunikat($this->j->t['edytujAdministracyjny.blad_modulu_nie_jest_administracyjny'], 'error', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }
        if (!$this->moznaWykonacAkcje('opcjeSystemowe') && in_array($modul->kod, array('ModulyZarzadzanie', 'ProjektyZarzadzanie'))) {
            $this->komunikat($this->j->t['edytujAdministracyjny.blad_brak_uprawnien_do_modulu'], 'error', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }

        $this->obiekt = $modul;

        if ($this->pobierzParametr('czysc') != '') {
            $this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
        }

        $zakladki = $this->przygotujDaneFormularza($modul);
        if (count($zakladki) < 1) {
            $this->komunikat($this->j->t['edytujAdministracyjny.info_modul_nie_posiada_konfiguracji'], 'info', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }

        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujAdministracyjny.tytul_strony'], $modul->nazwa)));

        $urlCzysc = Router::urlAdmin('KonfiguracjaSystemu', 'edytujAdministracyjny', array('kod' => $modul->kod, 'czysc' => '{KOD}'));

        $nazwy = array();
        $formularz = $this->budujFormularz($zakladki, $nazwy, $urlPowrotny, $urlCzysc);
        if ($formularz->wypelniony() && $formularz->danePoprawne()) {
            $this->zapiszKonfiguracje($formularz->pobierzZmienioneWartosci(), $nazwy, $urlPowrotny);
            return;
        } else {
            $this->tresc .= $this->szablon->parsujBlok('edytujAdministracyjny', array(
                'form' => $formularz->html(),
                'link_czysc' => Router::urlAdmin('KonfiguracjaSystemu', 'czyscAdministracyjny', array('kod' => $modul->kod)),
            ));
        }
    }


    public function wykonajEdytujZwykly()
    {
        $urlPowrotny = Router::urlAdmin('KonfiguracjaSystemu', 'zwykle');

        $mapper = DostepnyModul\Mapper::wywolaj();
        $modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
        if (!($modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['edytujZwykly.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }
        if (!in_array($modul->kod, Cms::inst()->projekt->powiazaneModulyHttp)) {
            $this->komunikat($this->j->t['edytujZwykly.blad_modul_nie_przypisany_do_projektu'], 'error', 'sesja');
            Router::przekierujDo($urlPowrotny);
            return;
        }

        if ($this->pobierzParametr('czysc') != '') {
            $this->czyscKlucz($modul, $this->pobierzParametr('czysc'));
        }

        $zakladki = $this->przygotujDaneFormularza($modul);
        if (count($zakladki) < 1) {
            $this->komunikat($this->j->t['edytujZwykly.info_modul_nie_posiada_konfiguracji'], 'info', 'sesja');
            Router::przekierujDo($urlPowrotny);
        }

        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujZwykly.tytul_strony'], $modul->nazwa)));

        $urlCzysc = Router::urlAdmin('KonfiguracjaSystemu', 'edytujZwykly', array('kod' => $modul->kod, 'czysc' => '{KOD}'));

        $nazwy = array();
        $formularz = $this->budujFormularz($zakladki, $nazwy, $urlPowrotny, $urlCzysc);
        if ($formularz->wypelniony() && $formularz->danePoprawne()) {
            $this->zapiszKonfiguracje($formularz->pobierzZmienioneWartosci(), $nazwy, $urlPowrotny);
            return;
        } else {
            $this->tresc .= $this->szablon->parsujBlok('edytujZwykly', array(
                'form' => $formularz->html(),
                'link_czysc' => Router::urlAdmin('KonfiguracjaSystemu', 'czyscZwykly', array('kod' => $modul->kod)),
            ));
        }
    }


    public function wykonajEdytujKategorie()
    {
        $mapper = $this->dane()->Kategoria();
        $this->obiekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if (!($this->obiekt instanceof Kategoria\Obiekt)) {
            $this->komunikat($this->j->t['edytujKategorie.blad_nieprawidlowa_kategoria'], 'error');
            return;
        }

        if (!($this->obiekt->modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['edytujKategorie.blad_nie_mozna_pobrac_modulu'], 'error');
            return;
        }

        if ($this->pobierzParametr('czysc') != '') {
            $this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
        }

        $zakladki = $this->przygotujDaneFormularza($this->obiekt->modul, $this->obiekt);
        if (count($zakladki) < 1) {
            $this->komunikat($this->j->t['edytujKategorie.info_modul_nie_posiada_konfiguracji'], 'info');
            return;
        }

        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujKategorie.tytul_strony'], $this->obiekt->nazwa)));

        $urlCzysc = Router::urlAdmin('KonfiguracjaSystemu', 'edytujKategorie', array('id' => $this->obiekt->id, 'czysc' => '{KOD}'));

        $nazwy = array();
        $formularz = $this->budujFormularz($zakladki, $nazwy, null, $urlCzysc);
        if ($formularz->wypelniony() && $formularz->danePoprawne()) {
            $zmienioneWiersze = $formularz->pobierzZmienioneWartosci();
            $this->zapiszKonfiguracje($zmienioneWiersze, $nazwy);
            return;
        } else {
            $this->tresc .= $this->szablon->parsujBlok('edytujKategorie', array(
                'form' => $formularz->html(),
                'link_czysc' => Router::urlAdmin('KonfiguracjaSystemu', 'czyscKategorie', array('id' => $this->obiekt->id)),
            ));
        }
    }


    public function wykonajEdytujBlok()
    {
        $mapper = $this->dane()->Blok();
        $this->obiekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if (!($this->obiekt instanceof Blok\Obiekt)) {
            $this->komunikat($this->j->t['edytujBlok.blad_nieprawidlowy_blok'], 'error');
            return;
        }
        if (!($this->obiekt->modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['edytujBlok.blad_nie_mozna_pobrac_modulu'], 'error');
            return;
        }

        if ($this->pobierzParametr('czysc') != '') {
            $this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
        }

        $zakladki = $this->przygotujDaneFormularza($this->obiekt->modul, $this->obiekt);
        if (count($zakladki) < 1) {
            $this->komunikat($this->j->t['edytujBlok.info_modul_nie_posiada_konfiguracji'], 'info');
            return;
        }

        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujBlok.tytul_strony'], $this->obiekt->nazwa)));

        $urlCzysc = Router::urlAdmin('KonfiguracjaSystemu', 'edytujBlok', array('id' => $this->obiekt->id, 'czysc' => '{KOD}'));

        $nazwy = array();
        $formularz = $this->budujFormularz($zakladki, $nazwy, null, $urlCzysc);
        if ($formularz->wypelniony() && $formularz->danePoprawne()) {
            $this->zapiszKonfiguracje($formularz->pobierzZmienioneWartosci(), $nazwy);
            return;
        } else {
            $this->tresc .= $this->szablon->parsujBlok('edytujBlok', array(
                'form' => $formularz->html(),
                'link_czysc' => Router::urlAdmin('KonfiguracjaSystemu', 'czyscBlok', array('id' => $this->obiekt->id)),
                'link_pobierz_konfiguracje' => Router::urlAdmin('KonfiguracjaSystemu', 'pobierzKonfiguracje', array('id' => $this->obiekt->id)),
                'link_wczytaj_konfiguracje' => Router::urlAdmin('KonfiguracjaSystemu', 'wczytajKonfiguracje', array('id' => $this->obiekt->id)),
            ));
        }
    }


    public function wykonajPobierzKonfiguracje()
    {
        $konfiguracja = $this->wezKonfiguracjeBloku(Zadanie::pobierz('id', 'intval', 'abs'));
        zwrocTrescDoPrzegladarki($konfiguracja, 'konfiguracja.csv');
    }


    public function wykonajWczytajKonfiguracje()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['wczytajKonfiguracje.tytul_strony']));

        $obiektFormularza = new \Generic\Formularz\Konfiguracja\Import();

        $obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('wczytajKonfiguracje'))
            ->ustawKonfiguracje(array('dozwolone_formaty_plikow' => $this->k->k['wczytajKonfiguracje.dozwolone_formaty_plikow']));

        if ($obiektFormularza->wypelniony()) {
            if ($obiektFormularza->danePoprawne()) {
                $baza = Cms::inst()->Baza();
                $baza->transakcjaStart();

                $statusy = array();
                $status = true;

                $idBloku = Zadanie::pobierz('id', 'intval', 'abs');
                $mapper = $this->dane()->Blok();
                $blok = $mapper->pobierzPoId($idBloku);

                $mapper = $this->dane()->WierszKonfiguracji();
                $konfiguracja = array();
                $konfiguracja = $mapper->pobierzDlaBloku($idBloku);

                //Usuniecie starej konfiguracji dla bloczku
                foreach ($konfiguracja as $wiersz) {
                    $statusy[] = $wiersz->usun($mapper);
                }

                //Wczytanie pliku z nowa konfiguracja
                $plik_konfiguracja = $obiektFormularza->zwrocFormularz()->plik->pobierzWartosc();
                $plik = new Plik($plik_konfiguracja['tmp_name']);


                //Pobieranie w petli kolejnych wierszy konfiguracji i zapisywanie ich do bazy danych
                if ($plik->pobierzZawartosc()) {
                    foreach (explode("\n", $plik->pobierzZawartosc()) as $linia) {
                        $dane = explode("|", $linia);
                        $kod_modulu = (strpos($dane['0'], '_Http') !== false) ? str_replace('_Http', '', $dane['0']) : str_replace('_Admin', '', $dane['0']);

                        //Sprawdzenie w wierszu czy kod modulu jest taki sam jak ten we wczytanej konfiguracji
                        //Jest to zabezpieczenie przed zapisaniem do bazy danych konfiguracji inego bloku z danym innym id
                        if ($kod_modulu == $blok->kodModulu) {
                            $wiersz = new WierszKonfiguracji\Obiekt;
                            $wiersz->idProjektu = ID_PROJEKTU;
                            $wiersz->kodJezyka = KOD_JEZYKA;
                            $wiersz->kodModulu = $dane['0'];
                            $wiersz->idBloku = $idBloku;
                            $wiersz->nazwa = $dane['3'];
                            $wiersz->typ = $dane['4'];
                            $wiersz->wartosc = $dane['5'];
                            $statusy[] = $wiersz->zapisz($mapper);
                        } else
                            $statusy[] = false;
                    }
                }
                //Spradzenie wszystkich statusow, jesli chodz jeden jest false to wszytanie konfiguracji nie powiodlo sie
                foreach ($statusy as $wartosc) {
                    if (!$wartosc) {
                        $status = false;
                        break;
                    }
                }

                if ($status) {
                    $this->komunikat($this->j->t['wczytajKonfiguracje.wczytano_konfiguracje'], 'info', 'sesja');
                    $baza->transakcjaPotwierdz();
                } else {
                    $this->komunikat($this->j->t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji'], 'error', 'sesja');
                    $baza->transakcjaCofnij();
                }
                Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'edytujBlok', array('id' => $idBloku)));
            }
        }
        $this->tresc .= $obiektFormularza->html();
    }


    public function wykonajCzyscSystem()
    {
        if (is_file($this->plikKonfiguracja) && unlink($this->plikKonfiguracja)) {
            $this->komunikat($this->j->t['czyscSystem.info_usunieto_wiersze'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['czyscSystem.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'index'));
    }


    public function wykonajCzyscAdministracyjny()
    {
        $mapper = DostepnyModul\Mapper::wywolaj();
        $modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
        if (!($modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['czyscAdministracyjny.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'administracyjne'));
            return;
        }
        if ($modul->typ != 'administracyjny') {
            $this->komunikat($this->j->t['czyscAdministracyjny.blad_modulu_nie_jest_administracyjny'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'administracyjne'));
            return;
        }

        $mapper = $this->dane()->WierszKonfiguracji();
        if ($mapper->czyscDlaModulu($modul->kod)) {
            $this->komunikat($this->j->t['czyscAdministracyjny.info_usunieto_wiersze'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['czyscAdministracyjny.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'edytujAdministracyjny', array('kod' => $modul->kod)));
    }


    public function wykonajCzyscZwykly()
    {
        $mapper = DostepnyModul\Mapper::wywolaj();
        $modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
        if (!($modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['czyscZwykly.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'zwykle'));
            return;
        }
        if (!in_array($modul->kod, Cms::inst()->projekt->powiazaneModulyHttp)) {
            $this->komunikat($this->j->t['czyscZwykly.blad_modul_nie_przypisany_do_projektu'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'zwykle'));
        }

        $mapper = $this->dane()->WierszKonfiguracji();
        if ($mapper->czyscDlaModulu($modul->kod)) {
            $this->komunikat($this->j->t['czyscZwykly.info_usunieto_wiersze'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['czyscZwykly.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'edytujZwykly', array('kod' => $modul->kod)));
    }


    public function wykonajCzyscKategorie()
    {
        $mapper = $this->dane()->Kategoria();
        $kategoria = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if (!($kategoria instanceof Kategoria\Obiekt)) {
            $this->komunikat($this->j->t['czyscKategorie.blad_nieprawidlowa_kategoria'], 'error');
            return;
        }
        if (!($kategoria->modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['czyscKategorie.blad_nie_mozna_pobrac_modulu'], 'error');
            return;
        }

        $mapper = $this->dane()->WierszKonfiguracji();
        if ($mapper->czyscDlaModulu($kategoria->kodModulu, $kategoria->id)) {
            $this->komunikat($this->j->t['czyscKategorie.info_usunieto_wiersze'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['czyscKategorie.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'edytujKategorie', array('id' => $kategoria->id)));
    }


    public function wykonajCzyscBlok()
    {
        $mapper = $this->dane()->Blok();
        $blok = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if (!($blok instanceof Blok\Obiekt)) {
            $this->komunikat($this->j->t['czyscBlok.blad_nieprawidlowy_blok'], 'error');
            return;
        }
        if (!($blok->modul instanceof DostepnyModul\Obiekt)) {
            $this->komunikat($this->j->t['czyscBlok.blad_nie_mozna_pobrac_modulu'], 'error');
            return;
        }

        $mapper = $this->dane()->WierszKonfiguracji();
        if ($mapper->czyscDlaModulu($blok->kodModulu, null, $blok->id)) {
            $this->komunikat($this->j->t['czyscBlok.info_usunieto_wiersze'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['czyscBlok.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin('KonfiguracjaSystemu', 'edytujBlok', array('id' => $blok->id)));
    }


    public function wykonajZmienneGlobalne()
    {
        if (file_exists($this->plikGlobalne) && is_file($this->plikGlobalne) && is_readable($this->plikGlobalne)) {
            $var_zmienne = include($this->plikGlobalne);
        } else {
            $var_zmienne = array();
        }

        $var_systemowe = (is_array($var_zmienne) && array_key_exists('systemowe', $var_zmienne)) ? $var_zmienne['systemowe'] : array();
        $var_zarezerwowane = (is_array($var_zmienne) && array_key_exists('zarezerwowane', $var_zmienne)) ? $var_zmienne['zarezerwowane'] : array();
        $var_globalne = (is_array($var_zmienne) && array_key_exists('uzytkownika', $var_zmienne)) ? $var_zmienne['uzytkownika'] : array();


        $obiektFormularza = new \Generic\Formularz\Konfiguracja\ZmienneGlobalne();
        $obiektFormularza->ustawZmienne($var_systemowe, $var_zarezerwowane, $var_globalne)
            ->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienneGlobalne'))
            ->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
            ->ustawUrlPowrotny(Router::urlAdmin('KonfiguracjaSystemu', 'index'));

        if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne()) {
            $dane = $obiektFormularza->pobierzWartosci();
            if (!$this->moznaWykonacAkcje('opcjeSystemowe')) {
                $form_systemowe = (is_array($var_systemowe)) ? $var_systemowe : array();
            } else {
                $form_systemowe = (is_array($dane) && array_key_exists('globalne_systemowe', $dane)) ? $dane['globalne_systemowe'] : array();
            }
            $form_zarezerwowane = (is_array($dane) && array_key_exists('globalne_zarezerwowane', $dane)) ? $dane['globalne_zarezerwowane'] : array();
            $form_globalne = (is_array($dane) && array_key_exists('globalne', $dane)) ? $dane['globalne'] : array();


            $full_array = array_merge($form_zarezerwowane, $form_systemowe);
            $roznica = count(array_diff_key($form_globalne, $full_array));
            $ilosc = count($form_globalne);

            if ($roznica != $ilosc) {
                $this->komunikat($this->j->t['zmienneGlobalne.blad_kluczy'], 'warning', 'modul');
            } else {
                if (count(array_diff_key($form_systemowe, $var_systemowe)) > 0 || count(array_diff_key($var_systemowe, $form_systemowe)) > 0
                    || count(array_diff_key($form_zarezerwowane, $var_zarezerwowane)) > 0 || count(array_diff_key($var_zarezerwowane, $form_zarezerwowane)) > 0) {
                    $this->komunikat($this->j->t['zmienneGlobalne.blad_systemowe'], 'warning', 'modul');
                } else {
                    $wynik = array(
                        'systemowe' => $form_systemowe,
                        'zarezerwowane' => $form_zarezerwowane,
                        'uzytkownika' => $form_globalne,
                    );
                    $wynik = sprintf('<?php
namespace Generic\Modul\WierszKonfiguracjiSystemu;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;
use Generic\Modul\EmailZarzadzanie;
 return %s ?>', var_export($wynik, true));
                    if ((is_file($this->plikGlobalne) && is_writable($this->plikGlobalne) && file_put_contents($this->plikGlobalne, $wynik)) || !file_exists($this->plikGlobalne) && file_put_contents($this->plikGlobalne, $wynik)) {
                        $this->komunikat($this->j->t['zmienneGlobalne.zapisano'], 'info', 'modul');
                    } else {
                        $this->komunikat($this->j->t['zmienneGlobalne.nie_zapisano'], 'error', 'modul');
                    }
                }
            }
        }

        $this->tresc .= $obiektFormularza->html();
    }


    protected function listaModulow($typ)
    {
        $akcja = ($typ == 'administracyjne') ? 'edytujAdministracyjny' : 'edytujZwykly';

        $grid = new TabelaDanych();
        $grid->dodajKolumne('kod', '', null, '', true);
        $grid->dodajKolumne('nazwa', $this->j->t['tabela.etykieta_nazwa'], null, Router::urlAdmin('KonfiguracjaSystemu', $akcja, array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('typ', $this->j->t['tabela.etykieta_typ'], 200);

        $grid->dodajPrzyciski(Router::urlAdmin('KonfiguracjaSystemu', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), array(
            array(
                'akcja' => Router::urlAdmin('KonfiguracjaSystemu', $akcja, array('{KLUCZ}' => '{WARTOSC}')),
                'etykieta' => $this->j->t['tabela.etykieta_edytuj'],
                'ikona' => 'icon-pencil',
            )
        ));


        $kryteria = $this->formularzWyszukiwania($grid, $typ);

        if (!$this->moznaWykonacAkcje('opcjeSystemowe')) {
            $kryteria['pomin'] = array('ModulyZarzadzanie', 'ProjektyZarzadzanie');
        }

        $mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if ($ilosc > 0) {
            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['tabela.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['tabela.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new DostepnyModul\Sorter($kolumna, $kierunek);
            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);

            $grid->ustawSortownie(array('nazwa', 'typ'), $kolumna, $kierunek,
                Router::urlAdmin('KonfiguracjaSystemu', $typ, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );
            $grid->pager($pager->html(Router::urlAdmin('KonfiguracjaSystemu', $typ, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            foreach ($mapper->szukaj($kryteria, $pager, $sorter) as $modul) {
                $modul['typ'] = $this->j->t['modul_typy'][$modul['typ']];
                $grid->dodajWiersz($modul);
            }
        }
        return $grid;
    }


    protected function przygotujDaneFormularza(DostepnyModul\Obiekt $modul, $obiekt = null)
    {
        $uslugi = array();
        foreach ($modul->uslugi as $usluga) {
            $uslugi[$usluga] = array();
        }

        $mapper = $this->dane()->WierszKonfiguracji();
        $mapperTlumaczenia = $this->dane()->WierszTlumaczen();

        $zakladki = array();
        foreach ($uslugi as $usluga => $konfiguracja) {
            $nazwaKlasy = 'Generic\\Modul\\' . $modul->kod . '\\' . $usluga;
            $instancja = new $nazwaKlasy;

            //$moduly = 'powiazaneModuly'.$usluga;
            //if (!in_array($modul->kod, Cms::inst()->projekt->$moduly) && !($instancja instanceof Generic\Modul\System)) continue;

            $opisy = $instancja->pobierzOpisKonfiguracji();

            $konfiguracja = array();
            foreach ($instancja->pobierzKonfiguracje() as $klucz => $wartosc) {
                $konfiguracja[$klucz]['wartosc'] = $wartosc;
                $konfiguracja[$klucz]['kod_modulu'] = $modul->kod;
                if (isset($opisy[$klucz])) $konfiguracja[$klucz] = array_merge($konfiguracja[$klucz], $opisy[$klucz]);
            }

            if ($obiekt instanceof Kategoria\Obiekt) {
                $konfiguracjaBaza = $mapper->pobierzDlaModulu($modul->kod . '_' . $usluga, $obiekt->id);
            } elseif ($obiekt instanceof Blok\Obiekt) {
                $konfiguracjaBaza = $mapper->pobierzDlaModulu($modul->kod . '_' . $usluga, null, $obiekt->id);
            } else {
                $konfiguracjaBaza = $mapper->pobierzDlaModulu($modul->kod . '_' . $usluga);
            }
            foreach ($konfiguracjaBaza as $wiersz) {
                if (array_key_exists($wiersz->nazwa, $konfiguracja)) {
                    if ($wiersz->typ == 'array' || $wiersz->typ == 'object') {
                        $wartosc = unserialize($wiersz->wartosc);
                    } else {
                        $wartosc = $wiersz->wartosc;
                        settype($wartosc, $wiersz->typ);
                    }
                    $konfiguracja[$wiersz->nazwa]['wartosc'] = $wartosc;

                    if (($obiekt instanceof Kategoria\Obiekt && $wiersz->idKategorii == $obiekt->id)
                        || ($obiekt instanceof Blok\Obiekt && $wiersz->idBloku == $obiekt->id)
                        || ($obiekt === null && $wiersz->idKategorii == '' && $wiersz->idBloku == '')) {
                        $klucz = str_replace(array('.', '-'), '_', $usluga . '_' . $wiersz->nazwa);
                        $this->konfiguracjaBaza[$klucz] = $wiersz;
                        $konfiguracja[$wiersz->nazwa]['klucz_baza'] = $usluga . '_' . $wiersz->nazwa;
                    }
                }
            }
            unset($konfiguracjaBaza);

            if ($obiekt instanceof Kategoria\Obiekt) {
                $tlumaczeniaBaza = $mapperTlumaczenia->pobierzDlaModulu($modul->kod . '_' . $usluga, $obiekt->id);
            } elseif ($obiekt instanceof Blok\Obiekt) {
                $tlumaczeniaBaza = $mapperTlumaczenia->pobierzDlaModulu($modul->kod . '_' . $usluga, null, $obiekt->id);
            } else {
                $tlumaczeniaBaza = $mapperTlumaczenia->pobierzDlaModulu($modul->kod . '_' . $usluga);
            }
            foreach ($tlumaczeniaBaza as $wiersz) {
                $nazwa = str_replace('_opis_konfiguracji', '', $wiersz->nazwa);
                if (strpos($wiersz->nazwa, '_opis_konfiguracji') !== false && array_key_exists($nazwa, $konfiguracja)) {
                    $konfiguracja[$nazwa]['opis'] = $wiersz->wartosc;
                }
            }

            // czy jest co konfigurowac
            if (count($konfiguracja) > 0) {
                $zakladki[$usluga] = $konfiguracja;
            }
        }

        return $zakladki;
    }


    protected function budujFormularz($zakladki, &$nazwy = array(), $urlPowrotny = '', $urlCzysc = '')
    {
        $cms = Cms::inst();
        $nazwy = array();
        $linkCzysc = $this->szablon->parsujBlok('/linkCzyscKlucz', array(
            'etykieta' => $this->j->t['formularz.etykieta_link_czysc'],
            'url' => $urlCzysc,
        ));
        $linkPodglad = $this->szablon->parsujBlok('/podgladWartosciDomyslnej', array(
            'id' => 'nyro_{NAZWA}',
            'etykieta_link_podglad' => 'Podgląd',
            'podglad_tresc' => '{TRESC}',
        ));

        // ustaw skrypt nyroModal
        $this->tresc .= $this->szablon->parsujBlok('/scriptNyroModal');

        $obiektFormularza = new \Generic\Formularz\Konfiguracja\Edycja();
        $obiektFormularza->ustawUrlPowrotny($urlPowrotny)
            ->ustawZakladki($zakladki)
            ->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
            ->ustawUrlCzysc($urlCzysc)
            ->ustawLinki($linkCzysc, $linkPodglad)
            ->ustawUprawnienia($this->uprawnienia);

        foreach ($zakladki as $usluga => $konfiguracja) {

            foreach ($konfiguracja as $klucz => $pole) {
                if (isset($pole['systemowy']) && !$this->moznaWykonacAkcje('opcjeSystemowe')) continue;

                $nazwa = str_replace(array('.', '-'), '_', $usluga . '_' . $klucz);
                $nazwy[$nazwa] = $klucz;
            }
        }

        return $obiektFormularza->zwrocFormularz();
    }


    protected function zapiszKonfiguracje($zmienioneWiersze, $nazwy, $urlPowrotny = '')
    {
        $licznik = 0;
        $bledy = 0;

        $mapper = $this->dane()->WierszKonfiguracji();
        $kodModulu = Zadanie::pobierz('kod', 'strval');

        foreach ($zmienioneWiersze as $klucz => $wartosc) {
            if (strpos($klucz, 'superuzytkownik.') !== false || strpos($klucz, 'baza.') !== false) {
                continue;
            }
            $wiersz = null;
            if (array_key_exists($klucz, $this->konfiguracjaBaza)) {
                $wiersz = $this->konfiguracjaBaza[$klucz];

                switch ($this->wykonywanaAkcja) {
                    case 'system':
                        if ($wiersz->idKategorii > 0 || $wiersz->idBloku > 0 || $wiersz->kodModulu != '') $wiersz = null;
                        break;

                    case 'edytujKategorie':
                        if ($wiersz->idKategorii < 0) $wiersz = null;
                        break;

                    case 'edytujBlok':
                        if ($wiersz->idBloku < 0) $wiersz = null;
                        break;

                    default:
                        if ($wiersz->idKategorii > 0 || $wiersz->idBloku > 0) $wiersz = null;
                        break;
                }
            }
            if (!($wiersz instanceof WierszKonfiguracji\Obiekt)) {
                $wiersz = new WierszKonfiguracji\Obiekt;
                $wiersz->idProjektu = ID_PROJEKTU;
                $wiersz->kodJezyka = KOD_JEZYKA;
                $wiersz->typ = gettype($wartosc);
                $wiersz->nazwa = $nazwy[$klucz];

                $rozbity = explode('_', $klucz);
                $usluga = array_shift($rozbity);

                switch ($this->wykonywanaAkcja) {
                    case 'system':
                        break;

                    case 'edytujKategorie':
                        $wiersz->idKategorii = $this->obiekt->id;
                        $wiersz->kodModulu = $this->obiekt->kodModulu . '_' . $usluga;
                        break;

                    case 'edytujBlok':
                        $wiersz->idBloku = $this->obiekt->id;
                        $wiersz->kodModulu = $this->obiekt->kodModulu . '_' . $usluga;
                        break;

                    default:
                        $wiersz->kodModulu = $kodModulu . '_' . $usluga;
                        break;
                }
            }

            $wiersz->wartosc = (is_array($wartosc)) ? serialize($wartosc) : (string)$wartosc;
            if ($wiersz->zapisz($mapper)) {
                $licznik++;
            } else {
                $this->komunikat(sprintf($this->j->t['system.blad_nie_mozna_zapisac_wiersza'], $klucz), 'error', ($urlPowrotny != '') ? 'sesja' : 'modul');
                $bledy++;
            }
        }
        $this->komunikat(sprintf($this->j->t['system.info_zapisano_wiersze'], $licznik), 'info', ($urlPowrotny != '') ? 'sesja' : 'modul');

        if ($urlPowrotny != '') Router::przekierujDo($urlPowrotny);
    }


    protected function czyscKlucz($obiekt, $wiersz)
    {
        $wiersz = explode('_', $wiersz);
        $usluga = $wiersz[0];
        array_shift($wiersz);
        $nazwa = implode('_', $wiersz);
        $mapper = $this->dane()->WierszKonfiguracji();
        $dane = null;

        if ($obiekt instanceof Kategoria\Obiekt) {
            $dane = $mapper->pobierzDlaModulu($obiekt->modul->kod . '_' . $usluga, $obiekt->id, null);
        } elseif ($obiekt instanceof Blok\Obiekt) {
            $dane = $mapper->pobierzDlaModulu($obiekt->modul->kod . '_' . $usluga, null, $obiekt->id);
        } elseif ($obiekt instanceof DostepnyModul\Obiekt) {
            $dane = $mapper->pobierzDlaModulu($obiekt->kod . '_' . $usluga);
        }
        if (is_array($dane)) {
            foreach ($dane as $wiersz) {
                if ($wiersz instanceof WierszKonfiguracji\Obiekt && $wiersz->nazwa == $nazwa && (
                        ($obiekt instanceof Kategoria\Obiekt && $wiersz->idKategorii == $obiekt->id)
                        || ($obiekt instanceof Blok\Obiekt && $wiersz->idBloku == $obiekt->id)
                        || ($obiekt instanceof DostepnyModul\Obiekt && $wiersz->idKategorii == '' && $wiersz->idBloku == '')
                    )) {
                    $wiersz->usun($mapper);
                }
            }
        }
    }


    private function wezKonfiguracjeBloku($idBloku)
    {
        $mapper = $this->dane()->WierszKonfiguracji();

        $konfiguracja = array();
        foreach ($mapper->zwracaTablice()->pobierzDlaBloku($idBloku) as $wiersz) {
            $konfiguracja[] = implode('|', array(
                $wiersz['kod_modulu'],
                $wiersz['id_kategorii'],
                $wiersz['id_bloku'],
                $wiersz['nazwa'],
                $wiersz['typ'],
                strtr($wiersz['wartosc'], array("\r\n" => '\r\n', "\n" => '\n')),
            ));
        }
        sort($konfiguracja);
        $konfiguracja = implode("\n", $konfiguracja);

        return $konfiguracja;
    }


    private function formularzWyszukiwania(TabelaDanych $grid, $typ)
    {
        $obiektFormularza = new \Generic\Formularz\Konfiguracja\Wyszukiwanie();
        $obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('tabela'))
            ->ustawTlumaczenia(array('modul_typy' => $this->j->t['modul_typy']))
            ->ustawTypModulow($typ)
            ->ustawDomyslne($this->pobierzParametr('typ', null, true), $this->pobierzParametr('fraza', null, true, array('strip_tags', 'filtr_xss', 'trim')));

        $kryteria = array_merge(array(), $obiektFormularza->pobierzWartosci());

        // wymuszenie wartosci
        if ($typ == 'administracyjne') {
            $kryteria['typ'] = 'administracyjny';
        } elseif ($typ == 'zwykle') {
            $kryteria['kod'] = Cms::inst()->projekt->powiazaneModulyHttp;
            if (!isset($kryteria['typ']) || !in_array($kryteria['typ'], array('zwykly', 'jednorazowy', 'blok'))) {
                $kryteria['typ'] = array('zwykly', 'jednorazowy', 'blok');
            }
        }

        if (Zadanie::pobierz('czysc', 'trim') != '') {
            $this->czyscParametr('typ');
            $this->czyscParametr('fraza');
        }

        $grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

        return $kryteria;
    }

}
