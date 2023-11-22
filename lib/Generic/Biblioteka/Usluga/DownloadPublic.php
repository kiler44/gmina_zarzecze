<?php
declare(strict_types=1);

namespace Generic\Biblioteka\Usluga;

use Generic\Formularz\Orders\Zalaczniki;
use Generic\Biblioteka\{
    Usluga,
    Cms,
    Router,
    Zadanie
};
use Generic\Model\{
    Projekt,
    Uzytkownik,
    Zalacznik
};

/**
 * Klasa odpowiedzialna za dostęp do plików prywatnych
 *
 * @author Marcin Mucha
 * @package biblioteki
 */
class DownloadPublic extends Usluga
{
    public function start()
    {
        $cms = Cms::inst();
        $cms->ladujBazeDanych();
        $cms->rozpocznijSesje();
        $projekty = Cms::inst()->dane()->Projekt();
        $cms->projekt = $projekty->pobierzPoKodzie(KOD_PROJEKTU);

        if ($cms->projekt instanceof Projekt\Obiekt) {
            define('ID_PROJEKTU', $cms->projekt->id);
            if (!defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
        } else {
            cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_projektu'], 503);
        }

        $parametryZadania = Router::analizujUrl();

        $kod_jezyka = $parametryZadania['jezyk'];
        if ($kod_jezyka != '' && in_array($kod_jezyka, $cms->projekt->jezykiKody)) {
            define('KOD_JEZYKA_ITERFEJSU', $kod_jezyka);
            define('KOD_JEZYKA', $kod_jezyka);
            $cms->sesja->kod_jezyka = $kod_jezyka;
        } elseif (isset($cms->sesja->kod_jezyka) && $cms->sesja->kod_jezyka != '') {
            define('KOD_JEZYKA_ITERFEJSU', $cms->sesja->kod_jezyka);
            define('KOD_JEZYKA', $cms->sesja->kod_jezyka);
        } else {
            define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
            define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
        }

        // znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
        $cms->konfiguracjaBaza();
        $cms->tlumaczeniaBaza();

        $urlPliku = trim(str_replace('_public', '', trim($_SERVER['ST_URL'])), '/');

        if (!$cms->profil() instanceof Uzytkownik\Obiekt) {
            $ilosc = count($tab = explode('/', $urlPliku));
            $kod = $tab[$ilosc - 2];

            $pattern = '/^[[:alnum:]]{14}\.[[:alnum:]]{8}$/';
            if (preg_match($pattern, $kod)) {
                $plik = $tab[$ilosc - 1];
                $idObiektu = intval($tab[$ilosc - 3]);
                $zalacznik = Cms::inst()->dane()->Zalacznik()->dopasuj($kod, $plik, $idObiektu);

                if ($zalacznik instanceof Zalacznik\Obiekt) {

                    ob_end_clean(); // czyszczenie buforowania z index.php
                    $urlPliku = str_replace($kod . '/', '', $urlPliku);

                    if (zwrocPlikDoPrzegladarki(TEMP_KATALOG . '/public/' . $urlPliku) === false) {
                        cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_pliku']);
                    }
                }
            }


            $urlPowrotny = Zadanie::adresWywolujacego();
            if (stripos(getClearDomain($urlPowrotny), $cms->projekt->domena) !== false) {
                if (!isset($cms->sesja->komunikaty)) $cms->sesja->komunikaty = array();

                //$cms->sesja->komunikaty[] = array('tresc' => $cms->lang['bledy']['nie_zalogowany_uzytkownik'], 'typ' => 'error', 'klasa' => '');
                $urlPowrotny = Zadanie::adresWywolujacego();

                Router::przekierujDo(Zadanie::adresWywolujacego());
            } else {
                cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_zalogowany_uzytkownik']);
                die();
            }


        } else {
            ob_end_clean(); // czyszczenie buforowania z index.php
            // podgląd
            if (strpos($urlPliku, 'preview')) {
                $urlPliku = str_replace('/preview', '', $urlPliku);

                podgladPliku(TEMP_KATALOG . '/public/' . $urlPliku);
            } else {
                if (zwrocPlikDoPrzegladarki(TEMP_KATALOG . '/public/' . $urlPliku) === false) {
                    cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_pliku']);
                }
            }

        }

    }
}