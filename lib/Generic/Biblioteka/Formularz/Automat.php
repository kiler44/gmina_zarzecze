<?php
declare(strict_types=1);
namespace Generic\Biblioteka\Formularz;

use Generic\Biblioteka\{Input, ObiektDanych, Formularz};


/**
 * Klasa rozszerzająca Formularz o automatyczne generowanie na podstawie danych dostarczanych przez obiekty
 *
 * @package biblioteki
 */
class Automat extends Formularz
{
    /**
     * Tablica przetrzymująca obiekty wstawione do formularza
     *
     * @var array
     */
    private $obiekty = null;

    /**
     * Tablica przetrzymująca pola dodatkowe, które trzeba dodać do formularza dla danego obiektu
     *
     * @var dodatkoweInputy
     */
    private $dodatkoweInputy = [];

    public function wstawInputPo(ObiektDanych $obiekt, string $poJakimPolu, Input $poleDoWstawienia)
    {
        $hash_obiektu = spl_object_hash($obiekt);
        $this->dodatkoweInputy[$hash_obiektu][$poJakimPolu][] = $poleDoWstawienia;
    }

    /**
     * Dodaje inputy do formularza na podstawie danych zawartych w definicji podanego obiektu
     *
     * @param ObiektDanych $obiekt obiekt danych na którego podstawie definicji formularz będzie budowany
     * @param Array $pola Wyszczególnione pola do dodania w zapisie ('wszystkie', 'opróczTego', 'OrazTego') lub ('!wszystkie', 'tylkoTaki', 'orazTaki')
     *
     * @return Formularz
     */
    public function wstawInputyObiektu(ObiektDanych $obiekt, array $pola = array('wszystkie')): Formularz
    {
        $hash_obiektu = spl_object_hash($obiekt);
        if ($obiekt->pobierzTlumaczeniaObiektu() instanceof \Generic\Tlumaczenie\Tlumaczenie) {
            $this->tlumaczenia[$hash_obiektu] = $obiekt->pobierzTlumaczeniaObiektu()->t;
        }

        if (!isset($this->obiekty[$hash_obiektu]))
            $this->obiekty[$hash_obiektu] = $obiekt;

        if ($pola[0] != 'wszystkie' && $pola[0] != '!wszystkie') {
            throw new \Exception('Błąd składni w liście przekazanych pól "' . $pola[0] . '" możliwe: "wszystkie" | "!wszystkie" ("wszystkie" domyślnie) ', E_USER_WARNING);
        }

        $tryb = $pola[0];
        unset($pola[0]);

        $inputyObiektu = $obiekt->pobierzPolaFormularza();

        // Usuwam znak ! oraz sprawdzam czy podane pole jest na liście pól dla danego obiektu
        foreach ($pola as $klucz => $wartosc) {
            $wartosc = str_replace('!', '', $wartosc);
            $pola[$klucz] = $wartosc;

            if (!array_key_exists($wartosc, $inputyObiektu)) {
                unset($pola[$klucz]);
                trigger_error('Podane pole: "' . $wartosc . '" nie znajduje się na liście pól dla obiektu: "' . get_class($obiekt) . '", zostanie pominięte', E_USER_WARNING);
            }
        }

        $dodajInputyDoRegionu = array();
        $otworzRegion = '';
        $otwartyRegion = '';
        if ($tryb == 'wszystkie') {
            $otwarty = true;
            foreach ($inputyObiektu as $nazwa => $definicja) {
                if (in_array($nazwa, $pola))
                    continue;

                if (!is_array($definicja) && strpos($definicja, ':closed') !== false) {
                    $definicja = str_replace(':closed', '', $definicja);
                    $otwarty = false;
                }

                if ($definicja == '_region_') {
                    if ($otworzRegion != '') {
                        $otworzRegion = '';
                        continue;
                    }
                    $otworzRegion = $nazwa;
                    if (isset($this->dodatkoweInputy[$hash_obiektu]) && count($this->dodatkoweInputy[$hash_obiektu]) > 0 && array_key_exists($nazwa, $this->dodatkoweInputy[$hash_obiektu])) {
                        $dodajInputyDoRegionu = $this->dodatkoweInputy[$hash_obiektu][$nazwa];
                    }
                } else {
                    if ($otworzRegion != '') {
                        if ($otwartyRegion != '') {
                            $this->zamknijRegion($otwartyRegion);
                            $otwartyRegion = '';
                        }

                        $etykieta_regionu = (isset($this->tlumaczenia[$hash_obiektu][$otworzRegion . '.region'])) ? $this->tlumaczenia[$hash_obiektu][$otworzRegion . '.region'] : $otworzRegion;

                        $this->otworzRegion($otworzRegion, $etykieta_regionu, $otwarty);
                        $otwarty = true;
                        $otwartyRegion = $otworzRegion;
                        $otworzRegion = '';

                        foreach ($dodajInputyDoRegionu as $klucz => $input) {
                            $this->input($input);
                            unset($dodajInputyDoRegionu[$klucz]);
                        }

                    }
                    $this->wstawInput($nazwa, $hash_obiektu, $definicja);
                    // Wstawienie dodatkowych inputow metodą wstawInputPo
                    if (isset($this->dodatkoweInputy[$hash_obiektu]) && count($this->dodatkoweInputy[$hash_obiektu]) > 0 && array_key_exists($nazwa, $this->dodatkoweInputy[$hash_obiektu])) {
                        foreach ($this->dodatkoweInputy[$hash_obiektu][$nazwa] as $input) {
                            $this->input($input);
                        }
                    }
                }
            }
        } else // Tutaj "nie wszystkie"
        {
            if (count($pola) == 0) {
                throw new \Exception('Nie podano żadnych dozwolonych pól formularza przy deklaracji "!wszystkie" dla obiektu: "' . get_class($obiekt) . '"', E_USER_ERROR);
            }

            foreach ($pola as $pole) {
                $otwarty = true;
                if (!is_array($inputyObiektu[$pole]) && strpos($inputyObiektu[$pole], ':closed') !== false) {
                    $inputyObiektu[$pole] = str_replace(':closed', '', $inputyObiektu[$pole]);
                    $otwarty = false;
                }
                if ($inputyObiektu[$pole] == '_region_') {
                    if ($otworzRegion != '') {
                        $otworzRegion = '';
                        continue;
                    }
                    $otworzRegion = $pole;
                } else {
                    if ($otworzRegion != '') {
                        if ($otwartyRegion != '') {
                            $this->zamknijRegion($otwartyRegion);
                            $otwartyRegion = '';
                        }

                        $etykieta_regionu = (isset($this->tlumaczenia[$hash_obiektu][$otworzRegion . '.region'])) ? $this->tlumaczenia[$hash_obiektu][$otworzRegion . '.region'] : $otworzRegion;

                        $this->otworzRegion($otworzRegion, $etykieta_regionu, $otwarty);
                        $otwarty = true;
                        $otwartyRegion = $otworzRegion;
                        $otworzRegion = '';

                        foreach ($dodajInputyDoRegionu as $klucz => $input) {
                            $this->input($input);
                            unset($dodajInputyDoRegionu[$klucz]);
                        }

                    }
                    $this->wstawInput($pole, $hash_obiektu, $inputyObiektu[$pole]);
                    // Wstawienie dodatkowych inputow metodą wstawInputPo
                    if (isset($this->dodatkoweInputy[$hash_obiektu]) && array_key_exists($pole, $this->dodatkoweInputy[$hash_obiektu])) {
                        foreach ($this->dodatkoweInputy[$hash_obiektu][$pole] as $input) {
                            $this->input($input);
                        }
                    }
                }

            }
        }

        if ($otwartyRegion != '') {
            $this->zamknijRegion($otwartyRegion);
        }

        return $this;
    }


    private function wstawInput(string $nazwa, string $hashObiektu, array $deklaracjaInputa)
    {
        $input = '\\Generic\Biblioteka\Input\\' . $deklaracjaInputa['input'];
        $walidatory = '\\Generic\Biblioteka\Walidator\\';

        if ($deklaracjaInputa['input'] != '' && class_exists($input, true)) {
            $lista_wartosciPolWybieralnych = array('Select', 'Radio', 'CheckboxOpis', 'SelectWiele', 'AutocompleteLista', 'SelectKlienci', 'SelectLista', 'SelectProdukty');

            $input_etykieta = (isset($this->tlumaczenia[$hashObiektu][$nazwa . '.etykieta'])) ? $this->tlumaczenia[$hashObiektu][$nazwa . '.etykieta'] : $nazwa . '.etykieta';
            $input_opis = (isset($this->tlumaczenia[$hashObiektu][$nazwa . '.opis'])) ? $this->tlumaczenia[$hashObiektu][$nazwa . '.opis'] : '';

            $listaSpecjalna = false;
            if (in_array($deklaracjaInputa['input'], $lista_wartosciPolWybieralnych)) {
                $lista_wartosci = array();
                if (isset($deklaracjaInputa['dopuszczalneWartosci']) && count($deklaracjaInputa['dopuszczalneWartosci']) > 0) {
                    $lista_wartosci = $deklaracjaInputa['dopuszczalneWartosci'];
                }
                if (count($lista_wartosci) == 0) {
                    $nazwaMetody = 'lista_' . $nazwa;

                    if (method_exists($this->obiekty[$hashObiektu]->definicjaObiektu, $nazwaMetody)) {
                        $lista_wartosci = $this->obiekty[$hashObiektu]->definicjaObiektu->$nazwaMetody();
                        $listaSpecjalna = true;
                    }
                }
                if (count($lista_wartosci) == 0) {
                    $dopuszczalneWartosci = $this->obiekty[$hashObiektu]->definicjaObiektu->dopuszczalneWartosci;
                    if (array_key_exists($nazwa, $dopuszczalneWartosci)) {
                        $lista_wartosci = $dopuszczalneWartosci[$nazwa];
                    }
                }

                $lista_wartosci_title = array();
                $nazwaMetodyTitle = 'title_' . $nazwa;
                if (method_exists($this->obiekty[$hashObiektu]->definicjaObiektu, $nazwaMetodyTitle)) {
                    $lista_wartosci_title = $this->obiekty[$hashObiektu]->definicjaObiektu->$nazwaMetodyTitle();
                }

                if (count($lista_wartosci) == 0) {
                    trigger_error('Nie zdefiniowano listy dla pola: "' . $nazwa . '" obiektu: "' . get_class($this->obiekty[$hashObiektu]), E_USER_WARNING);
                }

                $lista = array();
                foreach ($lista_wartosci as $klucz => $wartosc) {
                    if (isset($this->tlumaczenia[$hashObiektu][$nazwa . '.wartosci'])) {
                        $lista[$wartosc] = (isset($this->tlumaczenia[$hashObiektu][$nazwa . '.wartosci'][$wartosc])) ? $this->tlumaczenia[$hashObiektu][$nazwa . '.wartosci'][$wartosc] : $wartosc;
                    } else {
                        if ($wartosc != '') {
                            $lista[$klucz] = $wartosc;
                        } else
                            trigger_error('Brak tłumaczeń listy dla pola: ' . $nazwa, E_USER_WARNING);
                    }
                }
                if (count($lista) > 0) {
                    $podstawowe = array(
                        'wartosc' => $this->obiekty[$hashObiektu]->$nazwa,
                        'lista' => $lista,
                        'title' => $lista_wartosci_title,
                        'wymagany' => (isset($deklaracjaInputa['wymagany']) && $deklaracjaInputa['wymagany']) ? true : false);
                    $dodatkowe = (isset($deklaracjaInputa['parametry']) && !empty($deklaracjaInputa['parametry'])) ? $deklaracjaInputa['parametry'] : array();
                    $konfiguracja = array_merge($podstawowe, $dodatkowe);

                    $this->input(new $input($nazwa, $konfiguracja, $input_etykieta, $input_opis));
                }
            } else {
                $podstawowe = array('wartosc' => $this->obiekty[$hashObiektu]->$nazwa, 'wymagany' => (isset($deklaracjaInputa['wymagany']) && $deklaracjaInputa['wymagany']) ? true : false);
                $dodatkowe = (isset($deklaracjaInputa['parametry']) && !empty($deklaracjaInputa['parametry'])) ? $deklaracjaInputa['parametry'] : array();
                $konfiguracja = array_merge($podstawowe, $dodatkowe);


                $this->input(new $input($nazwa, $konfiguracja, $input_etykieta, $input_opis));
            }

            if (isset($deklaracjaInputa['filtry']) && is_array($deklaracjaInputa['filtry']) && !empty($deklaracjaInputa['filtry'])) {
                foreach ($deklaracjaInputa['filtry'] as $filtr) {
                    $this->$nazwa->dodajFiltr($filtr);
                }
            }

            if (isset($deklaracjaInputa['wymagany']) && $deklaracjaInputa['wymagany']) {
                $this->$nazwa->dodajWalidator(new \Generic\Biblioteka\Walidator\NiePuste());
            }

            if ($deklaracjaInputa['input'] == 'Select' && !isset($deklaracjaInputa['walidatory']['DozwoloneWartosci'])) {
                if ($listaSpecjalna)
                    $dozwolone = array_keys($lista_wartosci);
                else
                    $dozwolone = $lista_wartosci;

                $this->$nazwa->dodajWalidator(new \Generic\Biblioteka\Walidator\DozwoloneWartosci($dozwolone));
            }

            if (isset($deklaracjaInputa['walidatory'])) {
                foreach ($deklaracjaInputa['walidatory'] as $key => $val) {
                    if (!is_numeric($key)) {
                        $walidator = $walidatory . $key;
                        if (class_exists($walidator)) {
                            $this->$nazwa->dodajWalidator(new $walidator($val));
                        }
                    } else if (is_numeric($key) && $val !== '') {
                        $walidator = $walidatory . $val;
                        if (class_exists($walidator)) {
                            $this->$nazwa->dodajWalidator(new $walidator());
                        }
                    }
                }
            }
        }
    }
}
