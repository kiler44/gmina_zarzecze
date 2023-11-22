<?php

namespace Generic\Biblioteka\SmsBm;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Walidator;
use Generic\Model\Klient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client;
use Generic\Model\Sms;
use Generic\Model\Uzytkownik;
use Smsapi\Client\Infrastructure\ResponseMapper;
use Generic\Biblioteka\Zadanie;

class SmsApiPl
{
    private $statusInfo = '';
    private $obiektSms = null;

    private $apiToke = 'mYe90O9Ei3RF6Wmoct4q5PDciwpaPqug7og4IBmC';
    private $service;

    public $odbiorca;
    public $nadawca;
    public $wiadomosc;
    public $kategoria;
    public $obiektPowiazany = null;

    public function __construct()
    {
        $this->apiToken = Cms::inst()->config['sms']['token'];
        $client = (new Client\SmsapiHttpClient());
        $logger = new Logger();
        $client->setLogger($logger);
        $this->service = $client->smsapiPlService($this->apiToken);
    }

    private function pobierzNumerTelefonuOdbiorcy()
    {
        if (Cms::inst()->config['sms']['tryb_testowy'])
            $numer = Cms::inst()->config['sms']['numer_testowy_do'];
        else if ($this->odbiorca instanceof Uzytkownik\Obiekt)
            $numer = $this->odbiorca->telKomorkaFirmowa;
        else if ($this->odbiorca instanceof Klient\Obiekt)
            $numer = $this->odbiorca->phoneMobile;
        else
            $numer = $this->odbiorca;

        if (!$this->poprawnyNumerTelefonu($numer)) {
            throw new \Exception('Podany docelowy numer nie jest prawidlowy, dozwolony jest polski numer telefonu komorkowego . Podano: ' . $numer);
        }

        return $numer;
    }


    /**
     * Wysyła wiadomość SMS
     * @return bool
     */
    public function wyslijSms()
    {
        $cms = Cms::inst();
        $blad = true;

        if ($this->polaczono()) {
            if ($cms->config['sms']['tryb_nie_wysylaj_sms']) {
                $this->statusInfo = 'Sms w trybie nie wysyłaj, jedynie zapis do bazy.';
            } else {

                $numerDo = $this->pobierzNumerTelefonuOdbiorcy();
                $wiadomosc = $this->przygotujWiadomosc($this->wiadomosc, $numerDo, $cms->config['sms']['nazwa_nadawcy']);

                try {
                    $request = $this->service->smsFeature()->sendSms($wiadomosc);
                    $this->statusInfo = $request->status;

                    if (in_array($request->status, ['QUEUE', 'SENT', 'DELIVERED', 'ACCEPTED']))
                        $blad = false;

                } catch (ResponseMapper\ApiErrorException $exception) {
                    $this->statusInfo = $exception->getMessage();
                    $blad = true;
                }

            }

        } else {
            $this->statusInfo = 'Błąd połączenia z sms api.';
            $blad = true;
        }
        $this->zapiszDoBazy(!$blad);

        if ($blad) $this->zalogujBlad();

        return !$blad;

    }

    private function zalogujBlad()
    {
        $numerDo = $this->pobierzNumerTelefonuOdbiorcy();
        $nadawca = $this->zwrocIdWysylajacego();

        $obiekt = 'brak';
        if ($this->obiektPowiazany !== null && is_object($this->obiektPowiazany)) {
            $obiekt = get_class($this->obiektPowiazany) . ', id->' . $this->obiektPowiazany->id;
        }
        $user = Cms::inst()->profil()->login;
        $czas = date("Y-m-d H:i");
        $referer = (PHP_SAPI != 'cli') ? ', ' . Zadanie::wywolanyUrl() . ', ' . Zadanie::adresIp() : ', ' . $_SERVER['SCRIPT_NAME'] . ', User:' . $_SERVER['USER'];

        error_log($user . '@' . $czas . ', Do: ' . $numerDo . ', od (id uzytkownika): ' . $nadawca . ', wiadomosc: "' . $this->wiadomosc . '", kategoria: ' . $this->kategoria . ', 
        obiekt powiazany: ' . $obiekt . ', API response: ' . $this->statusInfo . ' adres: ' . $referer . "\n", 3, LOGI_KATALOG . '/' . date("Y-m-d", $_SERVER['REQUEST_TIME']) . '-sms-error.log');
    }

    public function polaczono()
    {
        return $this->service->pingFeature()
            ->ping();
    }

    /**
     * @param string $wiadomosc
     * @param string $numerTelefonu
     * @param string $from
     * @return SendSmsBag
     */
    private function przygotujWiadomosc(string $wiadomosc, string $numerTelefonu, string $from): SendSmsBag
    {
        $sms = SendSmsBag::withMessage($numerTelefonu, $wiadomosc);
        $sms->encoding = 'utf-8';
        $sms->from = $from;

        return $sms;
    }

    /*
     * Wysyła istniejącą w bazie wiadomość sms
     *
     * @param int idSms - id wiadomości sms do ponownego wysłania
     *
     */
    public function wyslijSmsPonownie($idSms)
    {
        if ($idSms > 0) {
            $smsMapper = Cms::inst()->dane()->Sms();
            $obiektSms = $smsMapper->pobierzPoId($idSms);

            if ($obiektSms instanceof Sms\Obiekt) {
                $this->obiektSms = $obiektSms;
                return $this->wyslijSms($obiektSms->recipientNumber, $obiektSms->senderNumber, $obiektSms->message, $obiektSms->type);
            } else {
                trigger_error('Wiadomość SMS którą próbujesz wysłać ponownie nie istnieje w bazie', E_USER_WARNING);
                return false;
            }

        }
    }

    private function zwrocIdWysylajacego()
    {
        $idWysylajacego = null;

        if ($this->nadawca instanceof Uzytkownik\Obiekt)
            $idWysylajacego = $this->nadawca->id;
        elseif (($u = Cms::inst()->profil()) instanceof Uzytkownik\Obiekt)
            $idWysylajacego = $u->id;
        else
            $idWysylajacego = $this->pobierzSuperUzytkownika()->id;

        return $idWysylajacego;

    }

    private function zwrocIdOdbiorcy($do)
    {
        $idOdbiorcy = null;

        if ($do instanceof Uzytkownik\Obiekt) {
            $idOdbiorcy = $do->id;
        } else if ($do instanceof Klient\Obiekt) {
            $idOdbiorcy = $do->id;
        }

        return $idOdbiorcy;
    }

    private function poprawnyNumerTelefonu($numer)
    {
        $walidator = new Walidator\Telefon();
        return $walidator->sprawdz($numer);
    }

    private function pobierzSuperUzytkownika()
    {
        $od = new Uzytkownik\Obiekt();
        $od->superUzytkownik(Cms::inst()->config['superuzytkownik']);

        return $od;
    }

    private function poprawnyObiektPowiazany($obiektPowiazany)
    {
        if (is_object($obiektPowiazany) && $obiektPowiazany->id > 0) {
            return true;
        } else {
            trigger_error('Błąd. Podana wartość nie jest objektem .', E_USER_WARNING);
            return false;
        }
    }

    private function pobierzTypObiektPowiazany($obiektPowiazany)
    {
        $chunks = explode('\\', get_class($obiektPowiazany));
        return $chunks[count($chunks) - 2];
    }

    /**
     * Zapisuje wiadomość SMS do bazy
     * @param bool $czyWyslane - 1 - wiadomość wysłana / 0 wiadomość nie wysłana
     */
    public function zapiszDoBazy($czyWyslane)
    {
        $mapperSms = Cms::inst()->dane()->Sms();
        if ($this->obiektSms instanceof Sms\Obiekt) {
            $obiektSms = $this->obiektSms;
        } else {
            $obiektSms = new Sms\Obiekt();
            $obiektSms->idProjektu = ID_PROJEKTU;
            if ($this->obiektPowiazany != null && $this->poprawnyObiektPowiazany($this->obiektPowiazany)) {
                $obiektSms->object = $this->pobierzTypObiektPowiazany($this->obiektPowiazany);
                $obiektSms->idObject = $this->obiektPowiazany->id;
            }
            $obiektSms->idSender = $this->zwrocIdWysylajacego($this->nadawca);
            $obiektSms->idRecipient = $this->zwrocIdOdbiorcy($this->odbiorca);
        }


        $obiektSms->message = $this->wiadomosc;
        $obiektSms->type = $this->kategoria;
        $obiektSms->dateSent = date('Y-m-d H:i:s');
        $obiektSms->recipientNumber = $this->pobierzNumerTelefonuOdbiorcy($this->odbiorca);
        $obiektSms->senderNumber = Cms::inst()->config['sms']['nazwa_nadawcy'];
        $obiektSms->statusInfo = $this->statusInfo;
        $obiektSms->sent = $czyWyslane;

        // $obiektSms->requireSend = ''
        // $obiektSms->dateDelivered = '';

        if (!$obiektSms->zapisz($mapperSms)) {
            trigger_error('Nie udało się zapisać wiadomości sms', E_USER_NOTICE);
            return false;
        }
        return true;

    }

    public function pobierzBlad()
    {
        return $this->statusInfo;
    }

    public function pozwolNaMiedzynarodoweSms()
    {
        $this->zezwolMiedzynarodoweSms = true;
    }

    public function zabronNaMiedzynarodoweSms()
    {
        $this->zezwolMiedzynarodoweSms = false;
    }
}
