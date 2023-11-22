<?php

namespace Generic\Model\Uzytkownik;

use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka;
use Generic\Biblioteka\Katalog;
use Generic\Model\PlikPrywatny;
use Generic\Model\PlikPrywatnyUzytkownikPowiazanie;
use Generic\Biblioteka\Pomocnik\IdpMenager;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $login
 * @property string $haslo
 * @property string $email
 * @property mixed $dataDodania
 * @property mixed $dataAktywacji
 * @property string $token
 * @property bool $czyAdmin
 * @property mixed $status
 * @property string $imie
 * @property string $nazwisko
 * @property string $dataUrodzenia
 * @property string $telKomorkaFirmowa
 * @property string $telKomorkaPrywatna
 * @property string $telDomowy
 * @property string $kontaktAdres
 * @property string $kontaktKodPocztowy
 * @property string $kontaktMiasto
 * @property string $jezyk
 * @property mixed $krajPochodzenia
 * @property string $zdjecie
 * @property mixed $stawkaGodzinowa
 * @property string $tabelaPodatkowa
 * @property string $umiejetnosci
 * @property array $dane
 * @property string $tidsbankenKod
 * @property integer $tidsbankenNumerPracownika
 * @property string $tidsbankenHaslo
 * @property boolen $tidsbankenLogujPrzezHaslo
 * @property integer $dniWolne
 * @property integer $dzial
 * @property double $etat
 * @property string $stanowisko
 * @property string $kontoBankowe
 * @property string $wlascicielKonta
 * @property string $opiekun
 * @property string $emailOpiekun
 * @property string $telefonOpiekun
 * @property boolen $praktykant
 * @property date $praktykantDataDo
 * @property int $dniChorobowe
 * @property double $stalaWyplata
 * @property boolen $wyswietlajWTidsbanken
 * @property string $kodGet
 */
class Obiekt extends ObiektDanych
{
    /**
     * @var bool
     */
    private $_superUzytkownik = false;


    public function __toString()
    {
        return $this->imie . ' ' . $this->nazwisko;
    }

    public static function algorytmZabezpieczajacy($haslo)
    {
        // UWAGA!!! algorytm zabezpieczajacy nie moze byc zmieniany jezeli dopisano uzytkowaników do bazy
        return md5($haslo);
    }


    function ustawHaslo($wartosc)
    {
        $this->_wartosci['haslo'] = self::algorytmZabezpieczajacy($wartosc);
        $this->_zmodyfikowane[] = 'haslo';
    }


    public function pobierzPelnaNazwa()
    {
        return $this->_wartosci['imie'] . ' ' . $this->_wartosci['nazwisko'];
    }


    public function pobierzNazwaOrazLogin()
    {
        if ($this->_wartosci['imie'] != '' || $this->_wartosci['nazwisko'] != '') {
            return trim($this->_wartosci['imie'] . ' ' . $this->_wartosci['nazwisko'] . ' (' . $this->_wartosci['login'] . ')');
        } else {
            return $this->_wartosci['login'];
        }
    }


    public function pobierzRole($zwracaTablice = false)
    {
        $this->_cache['role'] = array();
        if ($this->_wartosci['id'] > 0) {
            $mapper = Cms::inst()->dane()->Rola();
            if ($zwracaTablice)
                $mapper->zwracaTablice();
            $this->_cache['role'] = $mapper->pobierzPrzypisaneUzytkownikowi($this->_wartosci['id']);
            if (!is_array($this->_cache['role'])) $this->_cache['role'] = array();
        }
        return $this->_cache['role'];
    }


    public function pobierzUprawnienia()
    {

        if ($this->_superUzytkownik) return array();

        $this->_cache['uprawnienia'] = array();
        $mapper = Cms::inst()->dane()->Uprawnienie();
        $uprawnienia = $mapper->zwracaTablice()->pobierzDlaUzytkownika($this->_wartosci['id']);
        foreach ($uprawnienia as $wiersz) {
            $this->_cache['uprawnienia'][] = $wiersz['hash'];//$wiersz['usluga'].'_'.$wiersz['id_kategorii'].'_'.$wiersz['akcja'];
        }
        // pobieramy uprawnienia administracyjne
        $mapper = Cms::inst()->dane()->UprawnienieAdministracyjne();
        $uprawnienia = $mapper->zwracaTablice()->pobierzDlaUzytkownika($this->_wartosci['id']);
        foreach ($uprawnienia as $wiersz) {
            $this->_cache['uprawnienia'][] = $wiersz['hash'];//$wiersz['kod_modulu'].'_'.$wiersz['akcja'];
        }
        // pobieramy uprawnienia obiektow
        $mapper = Cms::inst()->dane()->UprawnienieObiektu();
        $uprawnienia = $mapper->zwracaTablice()->pobierzDlaUzytkownika($this->_wartosci['id']);
        foreach ($uprawnienia as $wiersz) {
            $this->_cache['uprawnienia'][] = $wiersz['hash'];
        }
        return $this->_cache['uprawnienia'];
    }

    public function pobierzUprawnieniaEventow()
    {
        if ($this->_superUzytkownik) return array();

        $this->_cache['uprawnienia_eventow'] = array();
        $mapper = Cms::inst()->dane()->RoleUprawnieniaEvents();
        $this->_cache['uprawnienia_eventow'] = array_keys(listaZTablicy($mapper->zwracaTablice('szablon_eventu')->pobierzDlaUzytkownika($this->id), 'szablon_eventu'));

        return $this->_cache['uprawnienia_eventow'];
    }

    public function odnowUprawnienia()
    {
        if (isset($this->_cache['role'])) unset($this->_cache['role']);
        if (isset($this->_cache['uprawnienia'])) unset($this->_cache['uprawnienia']);
        if (isset($this->_cache['uprawnienia_automatyczne'])) unset($this->_cache['uprawnienia_automatyczne']);
        $this->role;
        $this->uprawnienia;
    }


    public function maUprawnieniaDo($kod, ObiektDanych $obiektKontekstu = null)
    {
        //dump($this->uprawnienia);
        if ($this->_superUzytkownik) return true;
        //dump($kod);
        //dump(funkcjaHashujaca($kod));

        $maUprawnienia = in_array(funkcjaHashujaca($kod), $this->uprawnienia);
        //vdump($maUprawnienia);
        if ($maUprawnienia || $obiektKontekstu == null) {
            return $maUprawnienia;
        } else {
            $klasa = explode('\\', get_class($obiektKontekstu))[2];

            if (isset(Cms::inst()->sesja->roleKontekstowe['bezposredni'][$klasa])) {
                foreach (Cms::inst()->sesja->roleKontekstowe['bezposredni'][$klasa] as $pole => $uprawnienia) {
                    $maUprawnienia = false;
                    if ($obiektKontekstu->pobierzWartoscPola($pole) == Cms::inst()->profil()->id) {
                        $maUprawnienia = in_array(funkcjaHashujaca($kod), $uprawnienia);
                    }

                    if ($maUprawnienia) {
                        return $maUprawnienia;
                    }
                }
            }
            if (isset(Cms::inst()->sesja->roleKontekstowe['powiazanie'][$klasa])) {
                foreach (Cms::inst()->sesja->roleKontekstowe['powiazanie'][$klasa] as $powiazanie => $uprawnienia) {
                    $powiazanie = explode('_', $powiazanie);
                    $idPowiazania = $powiazanie[0];
                    $ktoreId = $powiazanie[1];

                    $maUprawnienia = false;
                    if ($ktoreId == 1) {
                        $maUprawnienia = $this->dane()->Powiazanie()->sprawdz(Cms::inst()->profil()->id, $obiektKontekstu->id, $idPowiazania);
                    } else {
                        $maUprawnienia = $this->dane()->Powiazanie()->sprawdz($obiektKontekstu->id, Cms::inst()->profil()->id, $idPowiazania);
                    }

                    if ($maUprawnienia) {
                        return $maUprawnienia;
                    }
                }
            }
        }
    }


    /**
     * Sprawdza czy uzytkownik posiada jedna z podanych rol na podstawie kodow
     * @param array Kody rol do sprawdzenia
     * @return bool
     */
    public function maRole(Array $kodyRol)
    {
        if (isset($this->role[0]) && $this->role[0] instanceof \Generic\Model\Rola\Obiekt)
            $rolaObiekt = true;
        else
            $rolaObiekt = false;
        foreach ($this->role as $rola) {
            if (in_array(($rolaObiekt) ? $rola->kod : $rola['kod'], $kodyRol)) {
                return true;
            }
        }
        return false;
    }


    public function maUprawnieniaAutomatyczneDoModulu($kodModulu)
    {
        if ($this->_superUzytkownik) return true;

        if (!isset($this->_cache['uprawnienia_automatyczne'])) {
            $this->_cache['uprawnienia_automatyczne'] = array();

            if (is_array($this->role) && count($this->role) > 0) {

                foreach ($this->role as $rola) {
                    $this->_cache['uprawnienia_automatyczne'] = array_merge($this->_cache['uprawnienia_automatyczne'], explode(',', $rola['moduly_dostep']));
                }
                $this->_cache['uprawnienia_automatyczne'] = array_unique($this->_cache['uprawnienia_automatyczne']);
            }
        }

        return in_array($kodModulu, $this->_cache['uprawnienia_automatyczne']);
    }


    public function pobierzSuperUzytkownik()
    {
        return $this->_superUzytkownik;
    }


    public function superUzytkownik($dane)
    {
        $temp = array();
        foreach ($this->_pola as $pole) {
            $temp[$pole] = '';
        }
        $temp['czyAdmin'] = true;
        $temp['status'] = 'aktywny';
        $temp['idProjektu'] = ID_PROJEKTU;
        $dane = array_merge($temp, $dane);
        unset($temp);
        $this->wypelnij($dane);
        $this->_superUzytkownik = true;
    }


    public static function zaloguj($login, $haslo)
    {
        $cms = Cms::inst();
        $uzytkownicy = $cms->dane()->Uzytkownik();
        $uzytkownik = null;

        if ($cms->config['idp']['wlacz_logowanie']) {
            $idp = new IdpMenager();
            if ($idp->zaloguj($login, $haslo))
                $uzytkownik = $uzytkownicy->pobierzPoLoginie($login);

        } else {
            $haslo = self::algorytmZabezpieczajacy($haslo);
            $uzytkownik = $uzytkownicy->pobierzPoLoginieHasle(strtolower($login), $haslo);
        }

        if ($uzytkownik instanceof Uzytkownik\Obiekt) {
            $cms->sesja->uzytkownik = $uzytkownik;

            self::zaladujUprawnieniaKontekstowe();

            return true;
        } elseif ($cms->config['superuzytkownik']['login'] == $login) {
            $cfgBaza = parse_ini_file(CMS_KATALOG . '/baza.ini');

            if (self::algorytmZabezpieczajacy($cfgBaza['db_password']) == $haslo) {
                $uzytkownik = new Uzytkownik\Obiekt();

                $cms->config['superuzytkownik']['haslo'] = self::algorytmZabezpieczajacy($cfgBaza['db_password']);

                $uzytkownik->superUzytkownik($cms->config['superuzytkownik']);
                $cms->sesja->uzytkownik = $uzytkownik;

                $wiersz = '[' . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $wiersz .= (PHP_SAPI != 'cli') ? ', ' . Zadanie::wywolanyUrl() . ', ' . Zadanie::adresIp() : ', ' . $_SERVER['SCRIPT_NAME'] . ', User:' . $_SERVER['USER'];
                $wiersz .= ']' . "\n";
                $wiersz .= 'Superuzytkownik zalogowal sie z adresu ' . Zadanie::adresIp() . ' [' . $_SERVER['HTTP_USER_AGENT'] . ']' . "\n\n\n";
                error_log($wiersz, 3, LOGI_KATALOG . '/' . date("Y-m-d", $_SERVER['REQUEST_TIME']) . '-php-error.log');

                return true;
            } else {
                return false;
            }
        }
        return false;
    }


    /**
     * Ładuje do sesji listę ról kontekstowych wraz z uprawnieniami.
     */
    protected static function zaladujUprawnieniaKontekstowe()
    {
        $cms = Cms::inst();

        $roleKontekstowe = array('powiazanie', 'bezposredni');

        foreach ($cms->dane()->Rola()->szukaj(array('kontekstowa' => true)) as $rola) {
            $typKontekstu = 'powiazanie';
            if ($rola->kontekstObiekt != '' && $rola->kontekstPole != '') {
                $typKontekstu = 'bezposredni';
            }

            $uprawnienia = array_merge(
                $cms->dane()->Uprawnienie()->zwracaTablice()->pobierzDlaRoli($rola->id),
                $cms->dane()->UprawnienieAdministracyjne()->zwracaTablice()->pobierzDlaRoli($rola->id),
                $cms->dane()->UprawnienieObiektu()->zwracaTablice()->pobierzDlaRoli($rola->id)
            );

            if ($typKontekstu == 'bezposredni') {
                if (!isset($roleKontekstowe[$typKontekstu][$rola->kontekstObiekt])) {
                    $roleKontekstowe[$typKontekstu][$rola->kontekstObiekt] = array();
                }

                if (!isset($roleKontekstowe[$typKontekstu][$rola->kontekstObiekt][$rola->kontekstPole])) {
                    $roleKontekstowe[$typKontekstu][$rola->kontekstObiekt][$rola->kontekstPole] = array();
                }
            } else {
                $powiazanie = $cms->dane()->PowiazanieTyp()->pobierzPoId($rola->kontekstPowiazanie);

                if ($powiazanie instanceof \Generic\Model\PowiazanieTyp\Obiekt) {
                    $typ = 'typ' . $rola->kontekstPowiazanieKtoreId;

                    if (!isset($roleKontekstowe[$typKontekstu][$powiazanie->$typ])) {
                        $roleKontekstowe[$typKontekstu][$powiazanie->$typ] = array();
                    }

                    if (!isset($roleKontekstowe[$typKontekstu][$powiazanie->$typ][$powiazanie->id . '_' . $rola->kontekstPowiazanieKtoreId])) {
                        $roleKontekstowe[$typKontekstu][$powiazanie->$typ][$powiazanie->id . '_' . $rola->kontekstPowiazanieKtoreId] = array();
                    }
                }
            }

            foreach ($uprawnienia as $wiersz) {
                if ($typKontekstu == 'bezposredni') {
                    $roleKontekstowe[$typKontekstu][$rola->kontekstObiekt][$rola->kontekstPole][] = $wiersz['hash'];
                } else {
                    if ($powiazanie instanceof \Generic\Model\PowiazanieTyp\Obiekt) {
                        $roleKontekstowe[$typKontekstu][$powiazanie->$typ][$powiazanie->id . '_' . $rola->kontekstPowiazanieKtoreId][] = $wiersz['hash'];
                    }
                }
            }
        }

        $cms->sesja->roleKontekstowe = $roleKontekstowe;
    }


    /**
     * Przekazuje obiekt do zapisania w zrodle danych, generuję role dla nowego uzytkownika
     *
     * @return boolean
     */
    public function zapisz(Biblioteka\Mapper\Interfejs $mapper)
    {
        if (!array_key_exists('id', $this->_wartosci) || $this->_wartosci['id'] == 0) {
            parent::zapisz($mapper);

            $rola = new \Generic\Model\Rola\Obiekt();
            $rola->idProjektu = ID_PROJEKTU;
            $rola->kod = 'uzytkownik_' . $this->_wartosci['id'];
            $rola->nazwa = 'Uzytkownik ' . $this->_wartosci['id'];
            $rola->opis = 'Rola użytkownika o ID=' . $this->_wartosci['id'];

            return $rola->zapisz(Cms::inst()->dane()->Rola()) && $rola->przypiszDoUzytkownika($this->_wartosci['id']);
        } else {
            return parent::zapisz($mapper);
        }
    }

    /**
     * Usuwa obiekt ze zrodla danych i czyści zawartosc wewnetrznych zmiennych
     *
     * @return boolean
     */
    public function usun(Biblioteka\Mapper\Interfejs $mapper)
    {
        $id = $this->_wartosci['id'];

        if (parent::usun($mapper)) {
            $rola = Cms::inst()->dane()->Rola()->pobierzPoKodzie('uzytkownik_' . $id);
            if ($rola instanceof \Generic\Model\Rola\Obiekt) {
                return $rola->usun(Cms::inst()->dane()->Rola());
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Pobiera obiekt teamu do którego użytkownik jest aktualnie przydzilony jeśli jest liderem teamu w innym przypadku FALSE
     *
     * @return \Generic\Model\Team\Obiekt
     */
    public function pobierzTeamDlaLidera()
    {
        $id = $this->_wartosci['id'];

        $team = $this->dane()->Team()->pobierzPoIdLidera($id);

        if ($team instanceof \Generic\Model\Team\Obiekt) {
            return $team;
        }
        return false;
    }

    /**
     * Pobiera obiekt teamu do którego użytkownik jest aktualnie przydzilony jeśli jest liderem teamu w innym przypadku FALSE
     *
     * @return \Generic\Model\Team\Obiekt
     */
    public function pobierzTeamDlaPracownika()
    {
        $id = $this->_wartosci['id'];

        $teamy = $this->dane()->Team()->szukaj(array('status' => 'active'));

        if (count($teamy)) {
            foreach ($teamy as $team) {
                if ($team->idUsers != '' && in_array($id, $team->idUsers))
                    return $team;
            }
        }
        return false;
    }

    /**
     *
     * @return \Generic\Model\Timelist\Obiekt
     */
    public function sprawdzCzyZalogowany()
    {
        $id = $this->_wartosci['id'];
        $wpisTimelist = $this->dane()->Timelist()->pobierzNiezakonczoneZadaniaPracownika($id);
        if (isset($wpisTimelist[0]) && $wpisTimelist[0] instanceof \Generic\Model\Timelist\Obiekt) {
            return $wpisTimelist[0];
        }
        return null;
    }

    /**
     *
     * @param type $pole - telKomorkaFirmowa, telKomorkaPrywatna
     * @return boolean
     */
    public function sprawdzNumerTelefonuNorwegia($pole = 'telKomorkaFirmowa')
    {
        if ($this->$pole != "" && preg_match('/^(\+47)\s?\d{8}$/', $this->$pole))
            return true;
        else {
            $plik = substr(Cms::inst()->katalog('trash', (int)Cms::inst()->profil()->id . '-' . date('d-m-Y') . '.txt'), 0, -1);
            if (file_exists($plik)) {
                $numerTelefonu = file_get_contents($plik);
                Cms::inst()->profil()->$pole = trim($numerTelefonu);
                return true;
            } else {
                return false;
            }
        }
    }

    public function pobierzPlikiPrywatneUzytkownika()
    {
        $katalogDocelowy = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('pliki_uzytkownika', $this->id), true);
        $zawartosc = $katalogDocelowy->pobierzZawartosc();
        $uprawnieniaUzytkownika = new PlikPrywatnyUzytkownikPowiazanie\Mapper();
        $listaUprawnionychPlikow = listaZObiektow($uprawnieniaUzytkownika->pobierzPoUzytkowniku($this->id), 'idPliku');

        $link = Cms::inst()->url('pliki_uzytkownika_baza', $this->id);

        $listaPlikow = array();
        $i = 0;
        foreach ($zawartosc as $klucz => $nazwa) {
            $pliki_mapper = $this->dane()->PlikPrywatny();
            $plik = $pliki_mapper->pobierzPoUrl($link . '/' . $klucz);
            if ($plik instanceof PlikPrywatny\Obiekt) {
                $listaPlikow[$i]['nazwa'] = $klucz;
                $listaPlikow[$i]['url'] = $link . '/' . $klucz;
                $listaPlikow[$i]['id_baza'] = $plik->id;
                $listaPlikow[$i]['ma_uprawnienie'] = (isset($listaUprawnionychPlikow[$plik->id])) ? true : false;
                $i++;
            }
        }

        return $listaPlikow;
    }

    public function zabierzUprawnieniaDoPliku(PlikPrywatny\Obiekt $plik)
    {

        $plikiUzytkownikMapper = new PlikPrywatnyUzytkownikPowiazanie\Mapper();

        return $plikiUzytkownikMapper->usunDlaPlikuUzytkownika($plik->id, $this->id);

    }

    public function przypiszUprawnieniaDoPliku(PlikPrywatny\Obiekt $plik)
    {
        $uprawnieniaUzytkownika = new PlikPrywatnyUzytkownikPowiazanie\Obiekt();

        $plikiUzytkownikMapper = new PlikPrywatnyUzytkownikPowiazanie\Mapper();
        $uprawnieniaUzytkownika->idProjektu = ID_PROJEKTU;
        $uprawnieniaUzytkownika->idPliku = $plik->id;
        $uprawnieniaUzytkownika->idUzytkownika = $this->id;

        return $uprawnieniaUzytkownika->zapisz($plikiUzytkownikMapper);
    }

    public function pobierzKolekcje()
    {
        $id = $this->_wartosci['id'];

        $kolekcje = listaZTablicy($this->dane()->TidsbankenUzytkownikKolekcja()->zwracaTablice()->pobierzKolekcjeUzytkownika($id), 'id_kolekcji', 'id_kolekcji');
        $tablicaKolekcji = array();
        if (count($kolekcje)) {
            $tablicaKolekcji = $this->dane()->TidsbankenKolekcja()->szukaj(array('ids' => $kolekcje, 'aktywne' => true, 'rodzaj_wywolania' => 'logout'));
        }
        return $tablicaKolekcji;
    }
}