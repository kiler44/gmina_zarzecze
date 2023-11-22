<?php
namespace Generic\Tlumaczenie\Pl\Modul\ZamowieniaBm;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['dodaj.etykietaMenu']
 * @property string $t['formularz.blad']
 * @property string $t['formularz.blad_zapisu']
 * @property string $t['formularz.dane_zapisane']
 * @property string $t['import.zapisz_zalacznik_brak_zalacznika']
 * @property string $t['import.zapisz_zalacznik_error']
 * @property string $t['import.zapisz_zalacznik_ok']
 * @property string $t['index.autor']
 * @property string $t['index.data_dodania']
 * @property string $t['index.dodajNotatke']
 * @property string $t['index.edytujZamowienieEtykieta']
 * @property string $t['index.etykietaMenu']
 * @property string $t['index.id']
 * @property string $t['index.id_klienta']
 * @property string $t['index.id_model']
 * @property string $t['index.podglad']
 * @property string $t['index.status']
 * @property string $t['index.tabela_etykieta_zalaczniki_wszystkie']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.usun']
 * @property string $t['index.wykonawca']
 * @property string $t['podglad.brak_zamowienia']
 * @property string $t['podglad.cena_etykieta']
 * @property string $t['podglad.dane_etykieta']
 * @property string $t['podglad.dane_klienta_etykieta']
 * @property string $t['podglad.dane_przyjmujacego_etykieta']
 * @property string $t['podglad.dane_wykonawcy_etykieta']
 * @property string $t['podglad.etykieta_drukuj']
 * @property string $t['podglad.etykieta_naglowke']
 * @property string $t['podglad.etykieta_notatka']
 * @property string $t['podglad.kamienie_etykieta']
 * @property string $t['podglad.model_etykieta']
 * @property string $t['podglad.opis_etykieta']
 * @property string $t['podglad.platyna_etykieta']
 * @property string $t['podglad.rabat_etykieta']
 * @property string $t['podglad.srebro_etykieta']
 * @property string $t['podglad.szczeguly_zamowienia_etykieta']
 * @property string $t['podglad.zamowienieNoEtykieta']
 * @property string $t['podglad.zloto_etykieta']
 * @property string $t['usun.blad_usuwania']
 * @property string $t['usun.brak_zamowienia']
 * @property string $t['usun.usuniete']
 * @property string $t['wyszukiwarka.czysc.wartosc']
 * @property string $t['wyszukiwarka.fraza.etykieta']
 * @property string $t['wyszukiwarka.status.etykieta']
 * @property string $t['wyszukiwarka.szukaj.wartosc']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'dodaj.etykietaMenu' => 'Dodaj nowe zamówienie',
		'formularz.blad' => 'Nie wszystkie pola formularza zostały wypełnione poprawnie',
		'formularz.blad_zapisu' => 'Błąd podczas zapisu zamówienia',
		'formularz.dane_zapisane' => 'Dane zapisane poprawnie',
		'formularzZamowienie.zapisz.wartosc' => 'Zapisz',
        'formularzZamowienie.wstecz.wartosc' => 'Wstecz',
        'formularzZamowienie.status.etykieta' => 'Status',
		'import.zapisz_zalacznik_brak_zalacznika' => 'Brak załączników',
		'import.zapisz_zalacznik_error' => 'Błąd zapisu załączników',
		'import.zapisz_zalacznik_ok' => 'Załączniki zapisane',
		'index.autor' => 'Autor',
		'index.data_dodania' => 'Data dodania',
		'index.dodajNotatke' => 'Dodaj notatkę',
		'index.edytujZamowienieEtykieta' => 'Edycja',
		'index.etykietaMenu' => 'Lista zamówień',
		'archiwum.etykietaMenu' => 'Archiwum',
		'index.id' => 'Id',
		'index.id_klienta' => 'Klient',
		'index.id_model' => 'Model',
		'index.podglad' => 'Podgląd',
		'index.status' => 'Status',
		'index.tabela_etykieta_zalaczniki_wszystkie' => 'Załączniki',
		'index.tytul_modulu' => 'Zamówienia',
		'index.tytul_strony' => 'Zamówienia',
		'index.tytul' => 'Tytuł',
		'index.usun' => 'Usuń',
        'index.termin' => 'Termin realizacji',
		'index.rodzaj' => 'Rodzaj wyrobu',
		'index.wykonawca' => 'Osoba wykonująca',
		'podglad.brak_zamowienia' => 'Zamówienie nie istnieje',
		'podglad.etykieta_rodzajOprawy' => 'Rodzaj oprawy',
        'podglad.zloto_info_etykieta' => 'Informacje o złocie',
		'podglad.etykieta_kamienKlienta' => 'Kamień od klienta',
		'podglad.tel_etykieta' => 'Tel. ',
        'podglad.termin' => 'Termin realizacji',
        'podglad.mail_etykieta' => 'Email ',
		'podglad.rozmiar_etykieta' => 'Rozmiar',
        'podglad.wysokosc_etykieta' => 'Wysokość',
		'podglad.cena_etykieta' => 'Cena',
		'podglad.dane_etykieta' => 'Dane ',
		'podglad.dane_klienta_etykieta' => 'Dane klienta',
		'podglad.dane_przyjmujacego_etykieta' => 'Przyjmujący zamówienie',
		'podglad.dane_wykonawcy_etykieta' => 'Wykonawca',
		'podglad.etykieta_drukuj' => 'Drukuj',
		'podglad.etykieta_naglowke' => 'Zamówienie nr. {ID} dla klienta {KLIENT}',
		'podglad.etykieta_notatka' => 'Notatki',
		'podglad.kamienie_etykieta' => 'Wybrane kamienie',
		'podglad.model_etykieta' => 'Wybrany model',
		'podglad.opis_etykieta' => 'Opis',
		'podglad.platyna_etykieta' => 'Platyna (w gr)',
		'podglad.rabat_etykieta' => 'Rabat',
		'podglad.srebro_etykieta' => 'Srebro (w gr)',
		'podglad.szczeguly_zamowienia_etykieta' => 'Szczegóły zamówienia',
		'podglad.zamowienieNoEtykieta' => 'Numer ',
		'podglad.zloto_etykieta' => 'Złoto (w gr)',
		'usun.blad_usuwania' => 'Błąd podczas usuwania zamówienia',
		'usun.brak_zamowienia' => 'Brak zamówienia',
		'usun.usuniete' => 'Zamówienie usunięte',
		'wyszukiwarka.czysc.wartosc' => 'Czyść',
		'wyszukiwarka.fraza.etykieta' => 'Fraza',
        'wyszukiwarka.rodzaj.etykieta' => 'Rodzaj wyrobu',
		'wyszukiwarka.status.etykieta' => 'Status',
		'wyszukiwarka.szukaj.wartosc' => 'Szukaj',
        'rodzaj_wyrobu' => [
            '' => '-wybierz-', 'obrączki' => 'obrączki' , 'pierścionek' => 'pierścionek' , 'kolczyki' => 'kolczyki' , 'przywieszka' => 'przywieszka','bransoleta' => 'bransoleta', 'inne' => 'inne',
        ],
        'sms_powiadomienia_klienta' => [
            'przyjete' => 'Witaj {KLIENT}. Twoje zamówienie o id# {ID} zostało przyjęte do realizacji',
            'akceptacja' => 'Witaj {KLIENT}. Twoje zamówienie o id# {ID} zostało wykonane i oczekuje na odbiór',
            'wydane' => 'Witaj {KLIENT}. Zamówienie zostały zrealizowane i odebrane. Dziękujemy za zaufanie.',
        ],

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}