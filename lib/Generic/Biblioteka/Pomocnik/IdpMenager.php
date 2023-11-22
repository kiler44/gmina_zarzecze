<?php
declare(strict_types=1);

namespace Generic\Biblioteka\Pomocnik;

use FreeIPA\APIAccess\Main;
use Generic\Biblioteka\Cms;

/**
 * Class IdpMenager
 * @package Generic\Biblioteka\Pomocnik
 * @author Marcin Mucha
 */
class IdpMenager
{
    /**
     * @var Main
     */
    private $_ipa;

    private $_error = array();

    public function __construct()
    {
        try {
            $this->_ipa = new Main(Cms::inst()->config['idp']['host'], Cms::inst()->config['idp']['cert']);
        } catch (\Exception $e) {
            $this->_error[$e->getCode()] = $e->getMessage();
        }
    }

    /**
     * @param string $nazwaUzytkownika
     * @param string $haslo
     * @return bool
     */
    public function zaloguj(string $nazwaUzytkownika, string $haslo): bool
    {
        $login = false;
        try {
            $auth = $this->_ipa->connection()->authenticate($nazwaUzytkownika, $haslo);

            if ($auth)
                $login = true;

        } catch
        (\Exception $e) {
            $this->_error[$e->getCode()] = $e->getMessage();
        }
        return $login;
    }

    /**
     * @return array
     */
    public function pobierzBledyLogowania(): array
    {
       return $this->_ipa->connection()->getAuthenticationInfo();
    }

    /**
     * @return array
     */
    public function pobierzBledy(): array
    {
        return $this->_error;
    }
}