<?php

namespace Generic\ModelNosql\Base;

/**
 * Base class of Generic\ModelNosql\UzytkownikWersja document.
 */
abstract class UzytkownikWersja extends \Mandango\Document\Document implements \ArrayAccess
{
    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
    }

    /**
     * Set the document data (hydrate).
     *
     * @param array $data  The document data.
     * @param bool  $clean Whether clean the document.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['_query_hash'])) {
            $this->addQueryHash($data['_query_hash']);
        }
        if (isset($data['_id'])) {
            $this->setId($data['_id']);
            $this->setIsNew(false);
        }
        if (isset($data['dataWersji'])) {
            $this->data['fields']['dataWersji'] = new \DateTime(); $this->data['fields']['dataWersji']->setTimestamp($data['dataWersji']->sec);
        } elseif (isset($data['_fields']['dataWersji'])) {
            $this->data['fields']['dataWersji'] = null;
        }
        if (isset($data['idTworzacegoWersje'])) {
            $this->data['fields']['idTworzacegoWersje'] = (int) $data['idTworzacegoWersje'];
        } elseif (isset($data['_fields']['idTworzacegoWersje'])) {
            $this->data['fields']['idTworzacegoWersje'] = null;
        }
        if (isset($data['idObiektu'])) {
            $this->data['fields']['idObiektu'] = (int) $data['idObiektu'];
        } elseif (isset($data['_fields']['idObiektu'])) {
            $this->data['fields']['idObiektu'] = null;
        }
        if (isset($data['idProjektu'])) {
            $this->data['fields']['idProjektu'] = (int) $data['idProjektu'];
        } elseif (isset($data['_fields']['idProjektu'])) {
            $this->data['fields']['idProjektu'] = null;
        }
        if (isset($data['login'])) {
            $this->data['fields']['login'] = (string) $data['login'];
        } elseif (isset($data['_fields']['login'])) {
            $this->data['fields']['login'] = null;
        }
        if (isset($data['haslo'])) {
            $this->data['fields']['haslo'] = (string) $data['haslo'];
        } elseif (isset($data['_fields']['haslo'])) {
            $this->data['fields']['haslo'] = null;
        }
        if (isset($data['email'])) {
            $this->data['fields']['email'] = (string) $data['email'];
        } elseif (isset($data['_fields']['email'])) {
            $this->data['fields']['email'] = null;
        }
        if (isset($data['dataDodania'])) {
            $this->data['fields']['dataDodania'] = new \DateTime(); $this->data['fields']['dataDodania']->setTimestamp($data['dataDodania']->sec);
        } elseif (isset($data['_fields']['dataDodania'])) {
            $this->data['fields']['dataDodania'] = null;
        }
        if (isset($data['dataAktywacji'])) {
            $this->data['fields']['dataAktywacji'] = new \DateTime(); $this->data['fields']['dataAktywacji']->setTimestamp($data['dataAktywacji']->sec);
        } elseif (isset($data['_fields']['dataAktywacji'])) {
            $this->data['fields']['dataAktywacji'] = null;
        }
        if (isset($data['token'])) {
            $this->data['fields']['token'] = (string) $data['token'];
        } elseif (isset($data['_fields']['token'])) {
            $this->data['fields']['token'] = null;
        }
        if (isset($data['czyAdmin'])) {
            $this->data['fields']['czyAdmin'] = (bool) $data['czyAdmin'];
        } elseif (isset($data['_fields']['czyAdmin'])) {
            $this->data['fields']['czyAdmin'] = null;
        }
        if (isset($data['status'])) {
            $this->data['fields']['status'] = (string) $data['status'];
        } elseif (isset($data['_fields']['status'])) {
            $this->data['fields']['status'] = null;
        }
        if (isset($data['imie'])) {
            $this->data['fields']['imie'] = (string) $data['imie'];
        } elseif (isset($data['_fields']['imie'])) {
            $this->data['fields']['imie'] = null;
        }
        if (isset($data['nazwisko'])) {
            $this->data['fields']['nazwisko'] = (string) $data['nazwisko'];
        } elseif (isset($data['_fields']['nazwisko'])) {
            $this->data['fields']['nazwisko'] = null;
        }
        if (isset($data['dataUrodzenia'])) {
            $this->data['fields']['dataUrodzenia'] = new \DateTime(); $this->data['fields']['dataUrodzenia']->setTimestamp($data['dataUrodzenia']->sec);
        } elseif (isset($data['_fields']['dataUrodzenia'])) {
            $this->data['fields']['dataUrodzenia'] = null;
        }
        if (isset($data['plec'])) {
            $this->data['fields']['plec'] = (string) $data['plec'];
        } elseif (isset($data['_fields']['plec'])) {
            $this->data['fields']['plec'] = null;
        }
        if (isset($data['kontaktTelefon'])) {
            $this->data['fields']['kontaktTelefon'] = (string) $data['kontaktTelefon'];
        } elseif (isset($data['_fields']['kontaktTelefon'])) {
            $this->data['fields']['kontaktTelefon'] = null;
        }
        if (isset($data['kontaktKomorka'])) {
            $this->data['fields']['kontaktKomorka'] = (string) $data['kontaktKomorka'];
        } elseif (isset($data['_fields']['kontaktKomorka'])) {
            $this->data['fields']['kontaktKomorka'] = null;
        }
        if (isset($data['kontaktFax'])) {
            $this->data['fields']['kontaktFax'] = (string) $data['kontaktFax'];
        } elseif (isset($data['_fields']['kontaktFax'])) {
            $this->data['fields']['kontaktFax'] = null;
        }
        if (isset($data['kontaktWWW'])) {
            $this->data['fields']['kontaktWWW'] = (string) $data['kontaktWWW'];
        } elseif (isset($data['_fields']['kontaktWWW'])) {
            $this->data['fields']['kontaktWWW'] = null;
        }
        if (isset($data['kontaktNazwa'])) {
            $this->data['fields']['kontaktNazwa'] = (string) $data['kontaktNazwa'];
        } elseif (isset($data['_fields']['kontaktNazwa'])) {
            $this->data['fields']['kontaktNazwa'] = null;
        }
        if (isset($data['kontaktAdres'])) {
            $this->data['fields']['kontaktAdres'] = (string) $data['kontaktAdres'];
        } elseif (isset($data['_fields']['kontaktAdres'])) {
            $this->data['fields']['kontaktAdres'] = null;
        }
        if (isset($data['kontaktKodPocztowy'])) {
            $this->data['fields']['kontaktKodPocztowy'] = (string) $data['kontaktKodPocztowy'];
        } elseif (isset($data['_fields']['kontaktKodPocztowy'])) {
            $this->data['fields']['kontaktKodPocztowy'] = null;
        }
        if (isset($data['kontaktMiasto'])) {
            $this->data['fields']['kontaktMiasto'] = (string) $data['kontaktMiasto'];
        } elseif (isset($data['_fields']['kontaktMiasto'])) {
            $this->data['fields']['kontaktMiasto'] = null;
        }
        if (isset($data['firmaNazwa'])) {
            $this->data['fields']['firmaNazwa'] = (string) $data['firmaNazwa'];
        } elseif (isset($data['_fields']['firmaNazwa'])) {
            $this->data['fields']['firmaNazwa'] = null;
        }
        if (isset($data['firmaNip'])) {
            $this->data['fields']['firmaNip'] = (string) $data['firmaNip'];
        } elseif (isset($data['_fields']['firmaNip'])) {
            $this->data['fields']['firmaNip'] = null;
        }
        if (isset($data['firmaAdres'])) {
            $this->data['fields']['firmaAdres'] = (string) $data['firmaAdres'];
        } elseif (isset($data['_fields']['firmaAdres'])) {
            $this->data['fields']['firmaAdres'] = null;
        }
        if (isset($data['firmaKodPocztowy'])) {
            $this->data['fields']['firmaKodPocztowy'] = (string) $data['firmaKodPocztowy'];
        } elseif (isset($data['_fields']['firmaKodPocztowy'])) {
            $this->data['fields']['firmaKodPocztowy'] = null;
        }
        if (isset($data['firmaMiasto'])) {
            $this->data['fields']['firmaMiasto'] = (string) $data['firmaMiasto'];
        } elseif (isset($data['_fields']['firmaMiasto'])) {
            $this->data['fields']['firmaMiasto'] = null;
        }
        if (isset($data['pocztaHost'])) {
            $this->data['fields']['pocztaHost'] = (string) $data['pocztaHost'];
        } elseif (isset($data['_fields']['pocztaHost'])) {
            $this->data['fields']['pocztaHost'] = null;
        }
        if (isset($data['pocztaPort'])) {
            $this->data['fields']['pocztaPort'] = (int) $data['pocztaPort'];
        } elseif (isset($data['_fields']['pocztaPort'])) {
            $this->data['fields']['pocztaPort'] = null;
        }
        if (isset($data['pocztaLogin'])) {
            $this->data['fields']['pocztaLogin'] = (string) $data['pocztaLogin'];
        } elseif (isset($data['_fields']['pocztaLogin'])) {
            $this->data['fields']['pocztaLogin'] = null;
        }
        if (isset($data['pocztaHaslo'])) {
            $this->data['fields']['pocztaHaslo'] = (string) $data['pocztaHaslo'];
        } elseif (isset($data['_fields']['pocztaHaslo'])) {
            $this->data['fields']['pocztaHaslo'] = null;
        }
        if (isset($data['jezyk'])) {
            $this->data['fields']['jezyk'] = (string) $data['jezyk'];
        } elseif (isset($data['_fields']['jezyk'])) {
            $this->data['fields']['jezyk'] = null;
        }
        if (isset($data['zgodaMailing'])) {
            $this->data['fields']['zgodaMailing'] = (int) $data['zgodaMailing'];
        } elseif (isset($data['_fields']['zgodaMailing'])) {
            $this->data['fields']['zgodaMailing'] = null;
        }
        if (isset($data['zgodaMarketing'])) {
            $this->data['fields']['zgodaMarketing'] = (int) $data['zgodaMarketing'];
        } elseif (isset($data['_fields']['zgodaMarketing'])) {
            $this->data['fields']['zgodaMarketing'] = null;
        }
        if (isset($data['typAktywacji'])) {
            $this->data['fields']['typAktywacji'] = (string) $data['typAktywacji'];
        } elseif (isset($data['_fields']['typAktywacji'])) {
            $this->data['fields']['typAktywacji'] = null;
        }
        if (isset($data['numerKontaBankowego'])) {
            $this->data['fields']['numerKontaBankowego'] = (string) $data['numerKontaBankowego'];
        } elseif (isset($data['_fields']['numerKontaBankowego'])) {
            $this->data['fields']['numerKontaBankowego'] = null;
        }
        if (isset($data['numerUmowy'])) {
            $this->data['fields']['numerUmowy'] = (string) $data['numerUmowy'];
        } elseif (isset($data['_fields']['numerUmowy'])) {
            $this->data['fields']['numerUmowy'] = null;
        }
        if (isset($data['mapaSzerokosc'])) {
            $this->data['fields']['mapaSzerokosc'] = (string) $data['mapaSzerokosc'];
        } elseif (isset($data['_fields']['mapaSzerokosc'])) {
            $this->data['fields']['mapaSzerokosc'] = null;
        }
        if (isset($data['mapaDlugosc'])) {
            $this->data['fields']['mapaDlugosc'] = (string) $data['mapaDlugosc'];
        } elseif (isset($data['_fields']['mapaDlugosc'])) {
            $this->data['fields']['mapaDlugosc'] = null;
        }

        return $this;
    }

    /**
     * Set the "dataWersji" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setDataWersji($value)
    {
        if (!isset($this->data['fields']['dataWersji'])) {
            if (!$this->isNew()) {
                $this->getDataWersji();
                if ($value === $this->data['fields']['dataWersji']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['dataWersji'] = null;
                $this->data['fields']['dataWersji'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['dataWersji']) {
            return $this;
        }

        if (!isset($this->fieldsModified['dataWersji']) && !array_key_exists('dataWersji', $this->fieldsModified)) {
            $this->fieldsModified['dataWersji'] = $this->data['fields']['dataWersji'];
        } elseif ($value === $this->fieldsModified['dataWersji']) {
            unset($this->fieldsModified['dataWersji']);
        }

        $this->data['fields']['dataWersji'] = $value;

        return $this;
    }

    /**
     * Returns the "dataWersji" field.
     *
     * @return mixed The $name field.
     */
    public function getDataWersji()
    {
        if (!isset($this->data['fields']['dataWersji'])) {
            if ($this->isNew()) {
                $this->data['fields']['dataWersji'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('dataWersji', $this->data['fields'])) {
                $this->addFieldCache('dataWersji');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('dataWersji' => 1));
                if (isset($data['dataWersji'])) {
                    $this->data['fields']['dataWersji'] = new \DateTime(); $this->data['fields']['dataWersji']->setTimestamp($data['dataWersji']->sec);
                } else {
                    $this->data['fields']['dataWersji'] = null;
                }
            }
        }

        return $this->data['fields']['dataWersji'];
    }

    /**
     * Set the "idTworzacegoWersje" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setIdTworzacegoWersje($value)
    {
        if (!isset($this->data['fields']['idTworzacegoWersje'])) {
            if (!$this->isNew()) {
                $this->getIdTworzacegoWersje();
                if ($value === $this->data['fields']['idTworzacegoWersje']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['idTworzacegoWersje'] = null;
                $this->data['fields']['idTworzacegoWersje'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['idTworzacegoWersje']) {
            return $this;
        }

        if (!isset($this->fieldsModified['idTworzacegoWersje']) && !array_key_exists('idTworzacegoWersje', $this->fieldsModified)) {
            $this->fieldsModified['idTworzacegoWersje'] = $this->data['fields']['idTworzacegoWersje'];
        } elseif ($value === $this->fieldsModified['idTworzacegoWersje']) {
            unset($this->fieldsModified['idTworzacegoWersje']);
        }

        $this->data['fields']['idTworzacegoWersje'] = $value;

        return $this;
    }

    /**
     * Returns the "idTworzacegoWersje" field.
     *
     * @return mixed The $name field.
     */
    public function getIdTworzacegoWersje()
    {
        if (!isset($this->data['fields']['idTworzacegoWersje'])) {
            if ($this->isNew()) {
                $this->data['fields']['idTworzacegoWersje'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('idTworzacegoWersje', $this->data['fields'])) {
                $this->addFieldCache('idTworzacegoWersje');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('idTworzacegoWersje' => 1));
                if (isset($data['idTworzacegoWersje'])) {
                    $this->data['fields']['idTworzacegoWersje'] = (int) $data['idTworzacegoWersje'];
                } else {
                    $this->data['fields']['idTworzacegoWersje'] = null;
                }
            }
        }

        return $this->data['fields']['idTworzacegoWersje'];
    }

    /**
     * Set the "idObiektu" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setIdObiektu($value)
    {
        if (!isset($this->data['fields']['idObiektu'])) {
            if (!$this->isNew()) {
                $this->getIdObiektu();
                if ($value === $this->data['fields']['idObiektu']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['idObiektu'] = null;
                $this->data['fields']['idObiektu'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['idObiektu']) {
            return $this;
        }

        if (!isset($this->fieldsModified['idObiektu']) && !array_key_exists('idObiektu', $this->fieldsModified)) {
            $this->fieldsModified['idObiektu'] = $this->data['fields']['idObiektu'];
        } elseif ($value === $this->fieldsModified['idObiektu']) {
            unset($this->fieldsModified['idObiektu']);
        }

        $this->data['fields']['idObiektu'] = $value;

        return $this;
    }

    /**
     * Returns the "idObiektu" field.
     *
     * @return mixed The $name field.
     */
    public function getIdObiektu()
    {
        if (!isset($this->data['fields']['idObiektu'])) {
            if ($this->isNew()) {
                $this->data['fields']['idObiektu'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('idObiektu', $this->data['fields'])) {
                $this->addFieldCache('idObiektu');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('idObiektu' => 1));
                if (isset($data['idObiektu'])) {
                    $this->data['fields']['idObiektu'] = (int) $data['idObiektu'];
                } else {
                    $this->data['fields']['idObiektu'] = null;
                }
            }
        }

        return $this->data['fields']['idObiektu'];
    }

    /**
     * Set the "idProjektu" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setIdProjektu($value)
    {
        if (!isset($this->data['fields']['idProjektu'])) {
            if (!$this->isNew()) {
                $this->getIdProjektu();
                if ($value === $this->data['fields']['idProjektu']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['idProjektu'] = null;
                $this->data['fields']['idProjektu'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['idProjektu']) {
            return $this;
        }

        if (!isset($this->fieldsModified['idProjektu']) && !array_key_exists('idProjektu', $this->fieldsModified)) {
            $this->fieldsModified['idProjektu'] = $this->data['fields']['idProjektu'];
        } elseif ($value === $this->fieldsModified['idProjektu']) {
            unset($this->fieldsModified['idProjektu']);
        }

        $this->data['fields']['idProjektu'] = $value;

        return $this;
    }

    /**
     * Returns the "idProjektu" field.
     *
     * @return mixed The $name field.
     */
    public function getIdProjektu()
    {
        if (!isset($this->data['fields']['idProjektu'])) {
            if ($this->isNew()) {
                $this->data['fields']['idProjektu'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('idProjektu', $this->data['fields'])) {
                $this->addFieldCache('idProjektu');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('idProjektu' => 1));
                if (isset($data['idProjektu'])) {
                    $this->data['fields']['idProjektu'] = (int) $data['idProjektu'];
                } else {
                    $this->data['fields']['idProjektu'] = null;
                }
            }
        }

        return $this->data['fields']['idProjektu'];
    }

    /**
     * Set the "login" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setLogin($value)
    {
        if (!isset($this->data['fields']['login'])) {
            if (!$this->isNew()) {
                $this->getLogin();
                if ($value === $this->data['fields']['login']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['login'] = null;
                $this->data['fields']['login'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['login']) {
            return $this;
        }

        if (!isset($this->fieldsModified['login']) && !array_key_exists('login', $this->fieldsModified)) {
            $this->fieldsModified['login'] = $this->data['fields']['login'];
        } elseif ($value === $this->fieldsModified['login']) {
            unset($this->fieldsModified['login']);
        }

        $this->data['fields']['login'] = $value;

        return $this;
    }

    /**
     * Returns the "login" field.
     *
     * @return mixed The $name field.
     */
    public function getLogin()
    {
        if (!isset($this->data['fields']['login'])) {
            if ($this->isNew()) {
                $this->data['fields']['login'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('login', $this->data['fields'])) {
                $this->addFieldCache('login');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('login' => 1));
                if (isset($data['login'])) {
                    $this->data['fields']['login'] = (string) $data['login'];
                } else {
                    $this->data['fields']['login'] = null;
                }
            }
        }

        return $this->data['fields']['login'];
    }

    /**
     * Set the "haslo" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setHaslo($value)
    {
        if (!isset($this->data['fields']['haslo'])) {
            if (!$this->isNew()) {
                $this->getHaslo();
                if ($value === $this->data['fields']['haslo']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['haslo'] = null;
                $this->data['fields']['haslo'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['haslo']) {
            return $this;
        }

        if (!isset($this->fieldsModified['haslo']) && !array_key_exists('haslo', $this->fieldsModified)) {
            $this->fieldsModified['haslo'] = $this->data['fields']['haslo'];
        } elseif ($value === $this->fieldsModified['haslo']) {
            unset($this->fieldsModified['haslo']);
        }

        $this->data['fields']['haslo'] = $value;

        return $this;
    }

    /**
     * Returns the "haslo" field.
     *
     * @return mixed The $name field.
     */
    public function getHaslo()
    {
        if (!isset($this->data['fields']['haslo'])) {
            if ($this->isNew()) {
                $this->data['fields']['haslo'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('haslo', $this->data['fields'])) {
                $this->addFieldCache('haslo');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('haslo' => 1));
                if (isset($data['haslo'])) {
                    $this->data['fields']['haslo'] = (string) $data['haslo'];
                } else {
                    $this->data['fields']['haslo'] = null;
                }
            }
        }

        return $this->data['fields']['haslo'];
    }

    /**
     * Set the "email" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setEmail($value)
    {
        if (!isset($this->data['fields']['email'])) {
            if (!$this->isNew()) {
                $this->getEmail();
                if ($value === $this->data['fields']['email']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['email'] = null;
                $this->data['fields']['email'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['email']) {
            return $this;
        }

        if (!isset($this->fieldsModified['email']) && !array_key_exists('email', $this->fieldsModified)) {
            $this->fieldsModified['email'] = $this->data['fields']['email'];
        } elseif ($value === $this->fieldsModified['email']) {
            unset($this->fieldsModified['email']);
        }

        $this->data['fields']['email'] = $value;

        return $this;
    }

    /**
     * Returns the "email" field.
     *
     * @return mixed The $name field.
     */
    public function getEmail()
    {
        if (!isset($this->data['fields']['email'])) {
            if ($this->isNew()) {
                $this->data['fields']['email'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('email', $this->data['fields'])) {
                $this->addFieldCache('email');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('email' => 1));
                if (isset($data['email'])) {
                    $this->data['fields']['email'] = (string) $data['email'];
                } else {
                    $this->data['fields']['email'] = null;
                }
            }
        }

        return $this->data['fields']['email'];
    }

    /**
     * Set the "dataDodania" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setDataDodania($value)
    {
        if (!isset($this->data['fields']['dataDodania'])) {
            if (!$this->isNew()) {
                $this->getDataDodania();
                if ($value === $this->data['fields']['dataDodania']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['dataDodania'] = null;
                $this->data['fields']['dataDodania'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['dataDodania']) {
            return $this;
        }

        if (!isset($this->fieldsModified['dataDodania']) && !array_key_exists('dataDodania', $this->fieldsModified)) {
            $this->fieldsModified['dataDodania'] = $this->data['fields']['dataDodania'];
        } elseif ($value === $this->fieldsModified['dataDodania']) {
            unset($this->fieldsModified['dataDodania']);
        }

        $this->data['fields']['dataDodania'] = $value;

        return $this;
    }

    /**
     * Returns the "dataDodania" field.
     *
     * @return mixed The $name field.
     */
    public function getDataDodania()
    {
        if (!isset($this->data['fields']['dataDodania'])) {
            if ($this->isNew()) {
                $this->data['fields']['dataDodania'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('dataDodania', $this->data['fields'])) {
                $this->addFieldCache('dataDodania');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('dataDodania' => 1));
                if (isset($data['dataDodania'])) {
                    $this->data['fields']['dataDodania'] = new \DateTime(); $this->data['fields']['dataDodania']->setTimestamp($data['dataDodania']->sec);
                } else {
                    $this->data['fields']['dataDodania'] = null;
                }
            }
        }

        return $this->data['fields']['dataDodania'];
    }

    /**
     * Set the "dataAktywacji" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setDataAktywacji($value)
    {
        if (!isset($this->data['fields']['dataAktywacji'])) {
            if (!$this->isNew()) {
                $this->getDataAktywacji();
                if ($value === $this->data['fields']['dataAktywacji']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['dataAktywacji'] = null;
                $this->data['fields']['dataAktywacji'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['dataAktywacji']) {
            return $this;
        }

        if (!isset($this->fieldsModified['dataAktywacji']) && !array_key_exists('dataAktywacji', $this->fieldsModified)) {
            $this->fieldsModified['dataAktywacji'] = $this->data['fields']['dataAktywacji'];
        } elseif ($value === $this->fieldsModified['dataAktywacji']) {
            unset($this->fieldsModified['dataAktywacji']);
        }

        $this->data['fields']['dataAktywacji'] = $value;

        return $this;
    }

    /**
     * Returns the "dataAktywacji" field.
     *
     * @return mixed The $name field.
     */
    public function getDataAktywacji()
    {
        if (!isset($this->data['fields']['dataAktywacji'])) {
            if ($this->isNew()) {
                $this->data['fields']['dataAktywacji'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('dataAktywacji', $this->data['fields'])) {
                $this->addFieldCache('dataAktywacji');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('dataAktywacji' => 1));
                if (isset($data['dataAktywacji'])) {
                    $this->data['fields']['dataAktywacji'] = new \DateTime(); $this->data['fields']['dataAktywacji']->setTimestamp($data['dataAktywacji']->sec);
                } else {
                    $this->data['fields']['dataAktywacji'] = null;
                }
            }
        }

        return $this->data['fields']['dataAktywacji'];
    }

    /**
     * Set the "token" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setToken($value)
    {
        if (!isset($this->data['fields']['token'])) {
            if (!$this->isNew()) {
                $this->getToken();
                if ($value === $this->data['fields']['token']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['token'] = null;
                $this->data['fields']['token'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['token']) {
            return $this;
        }

        if (!isset($this->fieldsModified['token']) && !array_key_exists('token', $this->fieldsModified)) {
            $this->fieldsModified['token'] = $this->data['fields']['token'];
        } elseif ($value === $this->fieldsModified['token']) {
            unset($this->fieldsModified['token']);
        }

        $this->data['fields']['token'] = $value;

        return $this;
    }

    /**
     * Returns the "token" field.
     *
     * @return mixed The $name field.
     */
    public function getToken()
    {
        if (!isset($this->data['fields']['token'])) {
            if ($this->isNew()) {
                $this->data['fields']['token'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('token', $this->data['fields'])) {
                $this->addFieldCache('token');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('token' => 1));
                if (isset($data['token'])) {
                    $this->data['fields']['token'] = (string) $data['token'];
                } else {
                    $this->data['fields']['token'] = null;
                }
            }
        }

        return $this->data['fields']['token'];
    }

    /**
     * Set the "czyAdmin" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setCzyAdmin($value)
    {
        if (!isset($this->data['fields']['czyAdmin'])) {
            if (!$this->isNew()) {
                $this->getCzyAdmin();
                if ($value === $this->data['fields']['czyAdmin']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['czyAdmin'] = null;
                $this->data['fields']['czyAdmin'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['czyAdmin']) {
            return $this;
        }

        if (!isset($this->fieldsModified['czyAdmin']) && !array_key_exists('czyAdmin', $this->fieldsModified)) {
            $this->fieldsModified['czyAdmin'] = $this->data['fields']['czyAdmin'];
        } elseif ($value === $this->fieldsModified['czyAdmin']) {
            unset($this->fieldsModified['czyAdmin']);
        }

        $this->data['fields']['czyAdmin'] = $value;

        return $this;
    }

    /**
     * Returns the "czyAdmin" field.
     *
     * @return mixed The $name field.
     */
    public function getCzyAdmin()
    {
        if (!isset($this->data['fields']['czyAdmin'])) {
            if ($this->isNew()) {
                $this->data['fields']['czyAdmin'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('czyAdmin', $this->data['fields'])) {
                $this->addFieldCache('czyAdmin');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('czyAdmin' => 1));
                if (isset($data['czyAdmin'])) {
                    $this->data['fields']['czyAdmin'] = (bool) $data['czyAdmin'];
                } else {
                    $this->data['fields']['czyAdmin'] = null;
                }
            }
        }

        return $this->data['fields']['czyAdmin'];
    }

    /**
     * Set the "status" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setStatus($value)
    {
        if (!isset($this->data['fields']['status'])) {
            if (!$this->isNew()) {
                $this->getStatus();
                if ($value === $this->data['fields']['status']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['status'] = null;
                $this->data['fields']['status'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['status']) {
            return $this;
        }

        if (!isset($this->fieldsModified['status']) && !array_key_exists('status', $this->fieldsModified)) {
            $this->fieldsModified['status'] = $this->data['fields']['status'];
        } elseif ($value === $this->fieldsModified['status']) {
            unset($this->fieldsModified['status']);
        }

        $this->data['fields']['status'] = $value;

        return $this;
    }

    /**
     * Returns the "status" field.
     *
     * @return mixed The $name field.
     */
    public function getStatus()
    {
        if (!isset($this->data['fields']['status'])) {
            if ($this->isNew()) {
                $this->data['fields']['status'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('status', $this->data['fields'])) {
                $this->addFieldCache('status');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('status' => 1));
                if (isset($data['status'])) {
                    $this->data['fields']['status'] = (string) $data['status'];
                } else {
                    $this->data['fields']['status'] = null;
                }
            }
        }

        return $this->data['fields']['status'];
    }

    /**
     * Set the "imie" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setImie($value)
    {
        if (!isset($this->data['fields']['imie'])) {
            if (!$this->isNew()) {
                $this->getImie();
                if ($value === $this->data['fields']['imie']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['imie'] = null;
                $this->data['fields']['imie'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['imie']) {
            return $this;
        }

        if (!isset($this->fieldsModified['imie']) && !array_key_exists('imie', $this->fieldsModified)) {
            $this->fieldsModified['imie'] = $this->data['fields']['imie'];
        } elseif ($value === $this->fieldsModified['imie']) {
            unset($this->fieldsModified['imie']);
        }

        $this->data['fields']['imie'] = $value;

        return $this;
    }

    /**
     * Returns the "imie" field.
     *
     * @return mixed The $name field.
     */
    public function getImie()
    {
        if (!isset($this->data['fields']['imie'])) {
            if ($this->isNew()) {
                $this->data['fields']['imie'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('imie', $this->data['fields'])) {
                $this->addFieldCache('imie');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('imie' => 1));
                if (isset($data['imie'])) {
                    $this->data['fields']['imie'] = (string) $data['imie'];
                } else {
                    $this->data['fields']['imie'] = null;
                }
            }
        }

        return $this->data['fields']['imie'];
    }

    /**
     * Set the "nazwisko" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setNazwisko($value)
    {
        if (!isset($this->data['fields']['nazwisko'])) {
            if (!$this->isNew()) {
                $this->getNazwisko();
                if ($value === $this->data['fields']['nazwisko']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['nazwisko'] = null;
                $this->data['fields']['nazwisko'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['nazwisko']) {
            return $this;
        }

        if (!isset($this->fieldsModified['nazwisko']) && !array_key_exists('nazwisko', $this->fieldsModified)) {
            $this->fieldsModified['nazwisko'] = $this->data['fields']['nazwisko'];
        } elseif ($value === $this->fieldsModified['nazwisko']) {
            unset($this->fieldsModified['nazwisko']);
        }

        $this->data['fields']['nazwisko'] = $value;

        return $this;
    }

    /**
     * Returns the "nazwisko" field.
     *
     * @return mixed The $name field.
     */
    public function getNazwisko()
    {
        if (!isset($this->data['fields']['nazwisko'])) {
            if ($this->isNew()) {
                $this->data['fields']['nazwisko'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('nazwisko', $this->data['fields'])) {
                $this->addFieldCache('nazwisko');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('nazwisko' => 1));
                if (isset($data['nazwisko'])) {
                    $this->data['fields']['nazwisko'] = (string) $data['nazwisko'];
                } else {
                    $this->data['fields']['nazwisko'] = null;
                }
            }
        }

        return $this->data['fields']['nazwisko'];
    }

    /**
     * Set the "dataUrodzenia" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setDataUrodzenia($value)
    {
        if (!isset($this->data['fields']['dataUrodzenia'])) {
            if (!$this->isNew()) {
                $this->getDataUrodzenia();
                if ($value === $this->data['fields']['dataUrodzenia']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['dataUrodzenia'] = null;
                $this->data['fields']['dataUrodzenia'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['dataUrodzenia']) {
            return $this;
        }

        if (!isset($this->fieldsModified['dataUrodzenia']) && !array_key_exists('dataUrodzenia', $this->fieldsModified)) {
            $this->fieldsModified['dataUrodzenia'] = $this->data['fields']['dataUrodzenia'];
        } elseif ($value === $this->fieldsModified['dataUrodzenia']) {
            unset($this->fieldsModified['dataUrodzenia']);
        }

        $this->data['fields']['dataUrodzenia'] = $value;

        return $this;
    }

    /**
     * Returns the "dataUrodzenia" field.
     *
     * @return mixed The $name field.
     */
    public function getDataUrodzenia()
    {
        if (!isset($this->data['fields']['dataUrodzenia'])) {
            if ($this->isNew()) {
                $this->data['fields']['dataUrodzenia'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('dataUrodzenia', $this->data['fields'])) {
                $this->addFieldCache('dataUrodzenia');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('dataUrodzenia' => 1));
                if (isset($data['dataUrodzenia'])) {
                    $this->data['fields']['dataUrodzenia'] = new \DateTime(); $this->data['fields']['dataUrodzenia']->setTimestamp($data['dataUrodzenia']->sec);
                } else {
                    $this->data['fields']['dataUrodzenia'] = null;
                }
            }
        }

        return $this->data['fields']['dataUrodzenia'];
    }

    /**
     * Set the "plec" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setPlec($value)
    {
        if (!isset($this->data['fields']['plec'])) {
            if (!$this->isNew()) {
                $this->getPlec();
                if ($value === $this->data['fields']['plec']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['plec'] = null;
                $this->data['fields']['plec'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['plec']) {
            return $this;
        }

        if (!isset($this->fieldsModified['plec']) && !array_key_exists('plec', $this->fieldsModified)) {
            $this->fieldsModified['plec'] = $this->data['fields']['plec'];
        } elseif ($value === $this->fieldsModified['plec']) {
            unset($this->fieldsModified['plec']);
        }

        $this->data['fields']['plec'] = $value;

        return $this;
    }

    /**
     * Returns the "plec" field.
     *
     * @return mixed The $name field.
     */
    public function getPlec()
    {
        if (!isset($this->data['fields']['plec'])) {
            if ($this->isNew()) {
                $this->data['fields']['plec'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('plec', $this->data['fields'])) {
                $this->addFieldCache('plec');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('plec' => 1));
                if (isset($data['plec'])) {
                    $this->data['fields']['plec'] = (string) $data['plec'];
                } else {
                    $this->data['fields']['plec'] = null;
                }
            }
        }

        return $this->data['fields']['plec'];
    }

    /**
     * Set the "kontaktTelefon" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktTelefon($value)
    {
        if (!isset($this->data['fields']['kontaktTelefon'])) {
            if (!$this->isNew()) {
                $this->getKontaktTelefon();
                if ($value === $this->data['fields']['kontaktTelefon']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktTelefon'] = null;
                $this->data['fields']['kontaktTelefon'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktTelefon']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktTelefon']) && !array_key_exists('kontaktTelefon', $this->fieldsModified)) {
            $this->fieldsModified['kontaktTelefon'] = $this->data['fields']['kontaktTelefon'];
        } elseif ($value === $this->fieldsModified['kontaktTelefon']) {
            unset($this->fieldsModified['kontaktTelefon']);
        }

        $this->data['fields']['kontaktTelefon'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktTelefon" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktTelefon()
    {
        if (!isset($this->data['fields']['kontaktTelefon'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktTelefon'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktTelefon', $this->data['fields'])) {
                $this->addFieldCache('kontaktTelefon');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktTelefon' => 1));
                if (isset($data['kontaktTelefon'])) {
                    $this->data['fields']['kontaktTelefon'] = (string) $data['kontaktTelefon'];
                } else {
                    $this->data['fields']['kontaktTelefon'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktTelefon'];
    }

    /**
     * Set the "kontaktKomorka" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktKomorka($value)
    {
        if (!isset($this->data['fields']['kontaktKomorka'])) {
            if (!$this->isNew()) {
                $this->getKontaktKomorka();
                if ($value === $this->data['fields']['kontaktKomorka']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktKomorka'] = null;
                $this->data['fields']['kontaktKomorka'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktKomorka']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktKomorka']) && !array_key_exists('kontaktKomorka', $this->fieldsModified)) {
            $this->fieldsModified['kontaktKomorka'] = $this->data['fields']['kontaktKomorka'];
        } elseif ($value === $this->fieldsModified['kontaktKomorka']) {
            unset($this->fieldsModified['kontaktKomorka']);
        }

        $this->data['fields']['kontaktKomorka'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktKomorka" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktKomorka()
    {
        if (!isset($this->data['fields']['kontaktKomorka'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktKomorka'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktKomorka', $this->data['fields'])) {
                $this->addFieldCache('kontaktKomorka');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktKomorka' => 1));
                if (isset($data['kontaktKomorka'])) {
                    $this->data['fields']['kontaktKomorka'] = (string) $data['kontaktKomorka'];
                } else {
                    $this->data['fields']['kontaktKomorka'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktKomorka'];
    }

    /**
     * Set the "kontaktFax" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktFax($value)
    {
        if (!isset($this->data['fields']['kontaktFax'])) {
            if (!$this->isNew()) {
                $this->getKontaktFax();
                if ($value === $this->data['fields']['kontaktFax']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktFax'] = null;
                $this->data['fields']['kontaktFax'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktFax']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktFax']) && !array_key_exists('kontaktFax', $this->fieldsModified)) {
            $this->fieldsModified['kontaktFax'] = $this->data['fields']['kontaktFax'];
        } elseif ($value === $this->fieldsModified['kontaktFax']) {
            unset($this->fieldsModified['kontaktFax']);
        }

        $this->data['fields']['kontaktFax'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktFax" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktFax()
    {
        if (!isset($this->data['fields']['kontaktFax'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktFax'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktFax', $this->data['fields'])) {
                $this->addFieldCache('kontaktFax');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktFax' => 1));
                if (isset($data['kontaktFax'])) {
                    $this->data['fields']['kontaktFax'] = (string) $data['kontaktFax'];
                } else {
                    $this->data['fields']['kontaktFax'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktFax'];
    }

    /**
     * Set the "kontaktWWW" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktWWW($value)
    {
        if (!isset($this->data['fields']['kontaktWWW'])) {
            if (!$this->isNew()) {
                $this->getKontaktWWW();
                if ($value === $this->data['fields']['kontaktWWW']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktWWW'] = null;
                $this->data['fields']['kontaktWWW'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktWWW']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktWWW']) && !array_key_exists('kontaktWWW', $this->fieldsModified)) {
            $this->fieldsModified['kontaktWWW'] = $this->data['fields']['kontaktWWW'];
        } elseif ($value === $this->fieldsModified['kontaktWWW']) {
            unset($this->fieldsModified['kontaktWWW']);
        }

        $this->data['fields']['kontaktWWW'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktWWW" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktWWW()
    {
        if (!isset($this->data['fields']['kontaktWWW'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktWWW'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktWWW', $this->data['fields'])) {
                $this->addFieldCache('kontaktWWW');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktWWW' => 1));
                if (isset($data['kontaktWWW'])) {
                    $this->data['fields']['kontaktWWW'] = (string) $data['kontaktWWW'];
                } else {
                    $this->data['fields']['kontaktWWW'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktWWW'];
    }

    /**
     * Set the "kontaktNazwa" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktNazwa($value)
    {
        if (!isset($this->data['fields']['kontaktNazwa'])) {
            if (!$this->isNew()) {
                $this->getKontaktNazwa();
                if ($value === $this->data['fields']['kontaktNazwa']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktNazwa'] = null;
                $this->data['fields']['kontaktNazwa'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktNazwa']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktNazwa']) && !array_key_exists('kontaktNazwa', $this->fieldsModified)) {
            $this->fieldsModified['kontaktNazwa'] = $this->data['fields']['kontaktNazwa'];
        } elseif ($value === $this->fieldsModified['kontaktNazwa']) {
            unset($this->fieldsModified['kontaktNazwa']);
        }

        $this->data['fields']['kontaktNazwa'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktNazwa" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktNazwa()
    {
        if (!isset($this->data['fields']['kontaktNazwa'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktNazwa'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktNazwa', $this->data['fields'])) {
                $this->addFieldCache('kontaktNazwa');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktNazwa' => 1));
                if (isset($data['kontaktNazwa'])) {
                    $this->data['fields']['kontaktNazwa'] = (string) $data['kontaktNazwa'];
                } else {
                    $this->data['fields']['kontaktNazwa'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktNazwa'];
    }

    /**
     * Set the "kontaktAdres" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktAdres($value)
    {
        if (!isset($this->data['fields']['kontaktAdres'])) {
            if (!$this->isNew()) {
                $this->getKontaktAdres();
                if ($value === $this->data['fields']['kontaktAdres']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktAdres'] = null;
                $this->data['fields']['kontaktAdres'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktAdres']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktAdres']) && !array_key_exists('kontaktAdres', $this->fieldsModified)) {
            $this->fieldsModified['kontaktAdres'] = $this->data['fields']['kontaktAdres'];
        } elseif ($value === $this->fieldsModified['kontaktAdres']) {
            unset($this->fieldsModified['kontaktAdres']);
        }

        $this->data['fields']['kontaktAdres'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktAdres" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktAdres()
    {
        if (!isset($this->data['fields']['kontaktAdres'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktAdres'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktAdres', $this->data['fields'])) {
                $this->addFieldCache('kontaktAdres');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktAdres' => 1));
                if (isset($data['kontaktAdres'])) {
                    $this->data['fields']['kontaktAdres'] = (string) $data['kontaktAdres'];
                } else {
                    $this->data['fields']['kontaktAdres'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktAdres'];
    }

    /**
     * Set the "kontaktKodPocztowy" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktKodPocztowy($value)
    {
        if (!isset($this->data['fields']['kontaktKodPocztowy'])) {
            if (!$this->isNew()) {
                $this->getKontaktKodPocztowy();
                if ($value === $this->data['fields']['kontaktKodPocztowy']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktKodPocztowy'] = null;
                $this->data['fields']['kontaktKodPocztowy'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktKodPocztowy']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktKodPocztowy']) && !array_key_exists('kontaktKodPocztowy', $this->fieldsModified)) {
            $this->fieldsModified['kontaktKodPocztowy'] = $this->data['fields']['kontaktKodPocztowy'];
        } elseif ($value === $this->fieldsModified['kontaktKodPocztowy']) {
            unset($this->fieldsModified['kontaktKodPocztowy']);
        }

        $this->data['fields']['kontaktKodPocztowy'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktKodPocztowy" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktKodPocztowy()
    {
        if (!isset($this->data['fields']['kontaktKodPocztowy'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktKodPocztowy'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktKodPocztowy', $this->data['fields'])) {
                $this->addFieldCache('kontaktKodPocztowy');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktKodPocztowy' => 1));
                if (isset($data['kontaktKodPocztowy'])) {
                    $this->data['fields']['kontaktKodPocztowy'] = (string) $data['kontaktKodPocztowy'];
                } else {
                    $this->data['fields']['kontaktKodPocztowy'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktKodPocztowy'];
    }

    /**
     * Set the "kontaktMiasto" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setKontaktMiasto($value)
    {
        if (!isset($this->data['fields']['kontaktMiasto'])) {
            if (!$this->isNew()) {
                $this->getKontaktMiasto();
                if ($value === $this->data['fields']['kontaktMiasto']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['kontaktMiasto'] = null;
                $this->data['fields']['kontaktMiasto'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['kontaktMiasto']) {
            return $this;
        }

        if (!isset($this->fieldsModified['kontaktMiasto']) && !array_key_exists('kontaktMiasto', $this->fieldsModified)) {
            $this->fieldsModified['kontaktMiasto'] = $this->data['fields']['kontaktMiasto'];
        } elseif ($value === $this->fieldsModified['kontaktMiasto']) {
            unset($this->fieldsModified['kontaktMiasto']);
        }

        $this->data['fields']['kontaktMiasto'] = $value;

        return $this;
    }

    /**
     * Returns the "kontaktMiasto" field.
     *
     * @return mixed The $name field.
     */
    public function getKontaktMiasto()
    {
        if (!isset($this->data['fields']['kontaktMiasto'])) {
            if ($this->isNew()) {
                $this->data['fields']['kontaktMiasto'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('kontaktMiasto', $this->data['fields'])) {
                $this->addFieldCache('kontaktMiasto');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('kontaktMiasto' => 1));
                if (isset($data['kontaktMiasto'])) {
                    $this->data['fields']['kontaktMiasto'] = (string) $data['kontaktMiasto'];
                } else {
                    $this->data['fields']['kontaktMiasto'] = null;
                }
            }
        }

        return $this->data['fields']['kontaktMiasto'];
    }

    /**
     * Set the "firmaNazwa" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setFirmaNazwa($value)
    {
        if (!isset($this->data['fields']['firmaNazwa'])) {
            if (!$this->isNew()) {
                $this->getFirmaNazwa();
                if ($value === $this->data['fields']['firmaNazwa']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['firmaNazwa'] = null;
                $this->data['fields']['firmaNazwa'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['firmaNazwa']) {
            return $this;
        }

        if (!isset($this->fieldsModified['firmaNazwa']) && !array_key_exists('firmaNazwa', $this->fieldsModified)) {
            $this->fieldsModified['firmaNazwa'] = $this->data['fields']['firmaNazwa'];
        } elseif ($value === $this->fieldsModified['firmaNazwa']) {
            unset($this->fieldsModified['firmaNazwa']);
        }

        $this->data['fields']['firmaNazwa'] = $value;

        return $this;
    }

    /**
     * Returns the "firmaNazwa" field.
     *
     * @return mixed The $name field.
     */
    public function getFirmaNazwa()
    {
        if (!isset($this->data['fields']['firmaNazwa'])) {
            if ($this->isNew()) {
                $this->data['fields']['firmaNazwa'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('firmaNazwa', $this->data['fields'])) {
                $this->addFieldCache('firmaNazwa');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('firmaNazwa' => 1));
                if (isset($data['firmaNazwa'])) {
                    $this->data['fields']['firmaNazwa'] = (string) $data['firmaNazwa'];
                } else {
                    $this->data['fields']['firmaNazwa'] = null;
                }
            }
        }

        return $this->data['fields']['firmaNazwa'];
    }

    /**
     * Set the "firmaNip" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setFirmaNip($value)
    {
        if (!isset($this->data['fields']['firmaNip'])) {
            if (!$this->isNew()) {
                $this->getFirmaNip();
                if ($value === $this->data['fields']['firmaNip']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['firmaNip'] = null;
                $this->data['fields']['firmaNip'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['firmaNip']) {
            return $this;
        }

        if (!isset($this->fieldsModified['firmaNip']) && !array_key_exists('firmaNip', $this->fieldsModified)) {
            $this->fieldsModified['firmaNip'] = $this->data['fields']['firmaNip'];
        } elseif ($value === $this->fieldsModified['firmaNip']) {
            unset($this->fieldsModified['firmaNip']);
        }

        $this->data['fields']['firmaNip'] = $value;

        return $this;
    }

    /**
     * Returns the "firmaNip" field.
     *
     * @return mixed The $name field.
     */
    public function getFirmaNip()
    {
        if (!isset($this->data['fields']['firmaNip'])) {
            if ($this->isNew()) {
                $this->data['fields']['firmaNip'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('firmaNip', $this->data['fields'])) {
                $this->addFieldCache('firmaNip');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('firmaNip' => 1));
                if (isset($data['firmaNip'])) {
                    $this->data['fields']['firmaNip'] = (string) $data['firmaNip'];
                } else {
                    $this->data['fields']['firmaNip'] = null;
                }
            }
        }

        return $this->data['fields']['firmaNip'];
    }

    /**
     * Set the "firmaAdres" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setFirmaAdres($value)
    {
        if (!isset($this->data['fields']['firmaAdres'])) {
            if (!$this->isNew()) {
                $this->getFirmaAdres();
                if ($value === $this->data['fields']['firmaAdres']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['firmaAdres'] = null;
                $this->data['fields']['firmaAdres'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['firmaAdres']) {
            return $this;
        }

        if (!isset($this->fieldsModified['firmaAdres']) && !array_key_exists('firmaAdres', $this->fieldsModified)) {
            $this->fieldsModified['firmaAdres'] = $this->data['fields']['firmaAdres'];
        } elseif ($value === $this->fieldsModified['firmaAdres']) {
            unset($this->fieldsModified['firmaAdres']);
        }

        $this->data['fields']['firmaAdres'] = $value;

        return $this;
    }

    /**
     * Returns the "firmaAdres" field.
     *
     * @return mixed The $name field.
     */
    public function getFirmaAdres()
    {
        if (!isset($this->data['fields']['firmaAdres'])) {
            if ($this->isNew()) {
                $this->data['fields']['firmaAdres'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('firmaAdres', $this->data['fields'])) {
                $this->addFieldCache('firmaAdres');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('firmaAdres' => 1));
                if (isset($data['firmaAdres'])) {
                    $this->data['fields']['firmaAdres'] = (string) $data['firmaAdres'];
                } else {
                    $this->data['fields']['firmaAdres'] = null;
                }
            }
        }

        return $this->data['fields']['firmaAdres'];
    }

    /**
     * Set the "firmaKodPocztowy" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setFirmaKodPocztowy($value)
    {
        if (!isset($this->data['fields']['firmaKodPocztowy'])) {
            if (!$this->isNew()) {
                $this->getFirmaKodPocztowy();
                if ($value === $this->data['fields']['firmaKodPocztowy']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['firmaKodPocztowy'] = null;
                $this->data['fields']['firmaKodPocztowy'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['firmaKodPocztowy']) {
            return $this;
        }

        if (!isset($this->fieldsModified['firmaKodPocztowy']) && !array_key_exists('firmaKodPocztowy', $this->fieldsModified)) {
            $this->fieldsModified['firmaKodPocztowy'] = $this->data['fields']['firmaKodPocztowy'];
        } elseif ($value === $this->fieldsModified['firmaKodPocztowy']) {
            unset($this->fieldsModified['firmaKodPocztowy']);
        }

        $this->data['fields']['firmaKodPocztowy'] = $value;

        return $this;
    }

    /**
     * Returns the "firmaKodPocztowy" field.
     *
     * @return mixed The $name field.
     */
    public function getFirmaKodPocztowy()
    {
        if (!isset($this->data['fields']['firmaKodPocztowy'])) {
            if ($this->isNew()) {
                $this->data['fields']['firmaKodPocztowy'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('firmaKodPocztowy', $this->data['fields'])) {
                $this->addFieldCache('firmaKodPocztowy');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('firmaKodPocztowy' => 1));
                if (isset($data['firmaKodPocztowy'])) {
                    $this->data['fields']['firmaKodPocztowy'] = (string) $data['firmaKodPocztowy'];
                } else {
                    $this->data['fields']['firmaKodPocztowy'] = null;
                }
            }
        }

        return $this->data['fields']['firmaKodPocztowy'];
    }

    /**
     * Set the "firmaMiasto" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setFirmaMiasto($value)
    {
        if (!isset($this->data['fields']['firmaMiasto'])) {
            if (!$this->isNew()) {
                $this->getFirmaMiasto();
                if ($value === $this->data['fields']['firmaMiasto']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['firmaMiasto'] = null;
                $this->data['fields']['firmaMiasto'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['firmaMiasto']) {
            return $this;
        }

        if (!isset($this->fieldsModified['firmaMiasto']) && !array_key_exists('firmaMiasto', $this->fieldsModified)) {
            $this->fieldsModified['firmaMiasto'] = $this->data['fields']['firmaMiasto'];
        } elseif ($value === $this->fieldsModified['firmaMiasto']) {
            unset($this->fieldsModified['firmaMiasto']);
        }

        $this->data['fields']['firmaMiasto'] = $value;

        return $this;
    }

    /**
     * Returns the "firmaMiasto" field.
     *
     * @return mixed The $name field.
     */
    public function getFirmaMiasto()
    {
        if (!isset($this->data['fields']['firmaMiasto'])) {
            if ($this->isNew()) {
                $this->data['fields']['firmaMiasto'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('firmaMiasto', $this->data['fields'])) {
                $this->addFieldCache('firmaMiasto');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('firmaMiasto' => 1));
                if (isset($data['firmaMiasto'])) {
                    $this->data['fields']['firmaMiasto'] = (string) $data['firmaMiasto'];
                } else {
                    $this->data['fields']['firmaMiasto'] = null;
                }
            }
        }

        return $this->data['fields']['firmaMiasto'];
    }

    /**
     * Set the "pocztaHost" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setPocztaHost($value)
    {
        if (!isset($this->data['fields']['pocztaHost'])) {
            if (!$this->isNew()) {
                $this->getPocztaHost();
                if ($value === $this->data['fields']['pocztaHost']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['pocztaHost'] = null;
                $this->data['fields']['pocztaHost'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['pocztaHost']) {
            return $this;
        }

        if (!isset($this->fieldsModified['pocztaHost']) && !array_key_exists('pocztaHost', $this->fieldsModified)) {
            $this->fieldsModified['pocztaHost'] = $this->data['fields']['pocztaHost'];
        } elseif ($value === $this->fieldsModified['pocztaHost']) {
            unset($this->fieldsModified['pocztaHost']);
        }

        $this->data['fields']['pocztaHost'] = $value;

        return $this;
    }

    /**
     * Returns the "pocztaHost" field.
     *
     * @return mixed The $name field.
     */
    public function getPocztaHost()
    {
        if (!isset($this->data['fields']['pocztaHost'])) {
            if ($this->isNew()) {
                $this->data['fields']['pocztaHost'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('pocztaHost', $this->data['fields'])) {
                $this->addFieldCache('pocztaHost');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('pocztaHost' => 1));
                if (isset($data['pocztaHost'])) {
                    $this->data['fields']['pocztaHost'] = (string) $data['pocztaHost'];
                } else {
                    $this->data['fields']['pocztaHost'] = null;
                }
            }
        }

        return $this->data['fields']['pocztaHost'];
    }

    /**
     * Set the "pocztaPort" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setPocztaPort($value)
    {
        if (!isset($this->data['fields']['pocztaPort'])) {
            if (!$this->isNew()) {
                $this->getPocztaPort();
                if ($value === $this->data['fields']['pocztaPort']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['pocztaPort'] = null;
                $this->data['fields']['pocztaPort'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['pocztaPort']) {
            return $this;
        }

        if (!isset($this->fieldsModified['pocztaPort']) && !array_key_exists('pocztaPort', $this->fieldsModified)) {
            $this->fieldsModified['pocztaPort'] = $this->data['fields']['pocztaPort'];
        } elseif ($value === $this->fieldsModified['pocztaPort']) {
            unset($this->fieldsModified['pocztaPort']);
        }

        $this->data['fields']['pocztaPort'] = $value;

        return $this;
    }

    /**
     * Returns the "pocztaPort" field.
     *
     * @return mixed The $name field.
     */
    public function getPocztaPort()
    {
        if (!isset($this->data['fields']['pocztaPort'])) {
            if ($this->isNew()) {
                $this->data['fields']['pocztaPort'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('pocztaPort', $this->data['fields'])) {
                $this->addFieldCache('pocztaPort');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('pocztaPort' => 1));
                if (isset($data['pocztaPort'])) {
                    $this->data['fields']['pocztaPort'] = (int) $data['pocztaPort'];
                } else {
                    $this->data['fields']['pocztaPort'] = null;
                }
            }
        }

        return $this->data['fields']['pocztaPort'];
    }

    /**
     * Set the "pocztaLogin" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setPocztaLogin($value)
    {
        if (!isset($this->data['fields']['pocztaLogin'])) {
            if (!$this->isNew()) {
                $this->getPocztaLogin();
                if ($value === $this->data['fields']['pocztaLogin']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['pocztaLogin'] = null;
                $this->data['fields']['pocztaLogin'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['pocztaLogin']) {
            return $this;
        }

        if (!isset($this->fieldsModified['pocztaLogin']) && !array_key_exists('pocztaLogin', $this->fieldsModified)) {
            $this->fieldsModified['pocztaLogin'] = $this->data['fields']['pocztaLogin'];
        } elseif ($value === $this->fieldsModified['pocztaLogin']) {
            unset($this->fieldsModified['pocztaLogin']);
        }

        $this->data['fields']['pocztaLogin'] = $value;

        return $this;
    }

    /**
     * Returns the "pocztaLogin" field.
     *
     * @return mixed The $name field.
     */
    public function getPocztaLogin()
    {
        if (!isset($this->data['fields']['pocztaLogin'])) {
            if ($this->isNew()) {
                $this->data['fields']['pocztaLogin'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('pocztaLogin', $this->data['fields'])) {
                $this->addFieldCache('pocztaLogin');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('pocztaLogin' => 1));
                if (isset($data['pocztaLogin'])) {
                    $this->data['fields']['pocztaLogin'] = (string) $data['pocztaLogin'];
                } else {
                    $this->data['fields']['pocztaLogin'] = null;
                }
            }
        }

        return $this->data['fields']['pocztaLogin'];
    }

    /**
     * Set the "pocztaHaslo" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setPocztaHaslo($value)
    {
        if (!isset($this->data['fields']['pocztaHaslo'])) {
            if (!$this->isNew()) {
                $this->getPocztaHaslo();
                if ($value === $this->data['fields']['pocztaHaslo']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['pocztaHaslo'] = null;
                $this->data['fields']['pocztaHaslo'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['pocztaHaslo']) {
            return $this;
        }

        if (!isset($this->fieldsModified['pocztaHaslo']) && !array_key_exists('pocztaHaslo', $this->fieldsModified)) {
            $this->fieldsModified['pocztaHaslo'] = $this->data['fields']['pocztaHaslo'];
        } elseif ($value === $this->fieldsModified['pocztaHaslo']) {
            unset($this->fieldsModified['pocztaHaslo']);
        }

        $this->data['fields']['pocztaHaslo'] = $value;

        return $this;
    }

    /**
     * Returns the "pocztaHaslo" field.
     *
     * @return mixed The $name field.
     */
    public function getPocztaHaslo()
    {
        if (!isset($this->data['fields']['pocztaHaslo'])) {
            if ($this->isNew()) {
                $this->data['fields']['pocztaHaslo'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('pocztaHaslo', $this->data['fields'])) {
                $this->addFieldCache('pocztaHaslo');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('pocztaHaslo' => 1));
                if (isset($data['pocztaHaslo'])) {
                    $this->data['fields']['pocztaHaslo'] = (string) $data['pocztaHaslo'];
                } else {
                    $this->data['fields']['pocztaHaslo'] = null;
                }
            }
        }

        return $this->data['fields']['pocztaHaslo'];
    }

    /**
     * Set the "jezyk" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setJezyk($value)
    {
        if (!isset($this->data['fields']['jezyk'])) {
            if (!$this->isNew()) {
                $this->getJezyk();
                if ($value === $this->data['fields']['jezyk']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['jezyk'] = null;
                $this->data['fields']['jezyk'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['jezyk']) {
            return $this;
        }

        if (!isset($this->fieldsModified['jezyk']) && !array_key_exists('jezyk', $this->fieldsModified)) {
            $this->fieldsModified['jezyk'] = $this->data['fields']['jezyk'];
        } elseif ($value === $this->fieldsModified['jezyk']) {
            unset($this->fieldsModified['jezyk']);
        }

        $this->data['fields']['jezyk'] = $value;

        return $this;
    }

    /**
     * Returns the "jezyk" field.
     *
     * @return mixed The $name field.
     */
    public function getJezyk()
    {
        if (!isset($this->data['fields']['jezyk'])) {
            if ($this->isNew()) {
                $this->data['fields']['jezyk'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('jezyk', $this->data['fields'])) {
                $this->addFieldCache('jezyk');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('jezyk' => 1));
                if (isset($data['jezyk'])) {
                    $this->data['fields']['jezyk'] = (string) $data['jezyk'];
                } else {
                    $this->data['fields']['jezyk'] = null;
                }
            }
        }

        return $this->data['fields']['jezyk'];
    }

    /**
     * Set the "zgodaMailing" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setZgodaMailing($value)
    {
        if (!isset($this->data['fields']['zgodaMailing'])) {
            if (!$this->isNew()) {
                $this->getZgodaMailing();
                if ($value === $this->data['fields']['zgodaMailing']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['zgodaMailing'] = null;
                $this->data['fields']['zgodaMailing'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['zgodaMailing']) {
            return $this;
        }

        if (!isset($this->fieldsModified['zgodaMailing']) && !array_key_exists('zgodaMailing', $this->fieldsModified)) {
            $this->fieldsModified['zgodaMailing'] = $this->data['fields']['zgodaMailing'];
        } elseif ($value === $this->fieldsModified['zgodaMailing']) {
            unset($this->fieldsModified['zgodaMailing']);
        }

        $this->data['fields']['zgodaMailing'] = $value;

        return $this;
    }

    /**
     * Returns the "zgodaMailing" field.
     *
     * @return mixed The $name field.
     */
    public function getZgodaMailing()
    {
        if (!isset($this->data['fields']['zgodaMailing'])) {
            if ($this->isNew()) {
                $this->data['fields']['zgodaMailing'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('zgodaMailing', $this->data['fields'])) {
                $this->addFieldCache('zgodaMailing');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('zgodaMailing' => 1));
                if (isset($data['zgodaMailing'])) {
                    $this->data['fields']['zgodaMailing'] = (int) $data['zgodaMailing'];
                } else {
                    $this->data['fields']['zgodaMailing'] = null;
                }
            }
        }

        return $this->data['fields']['zgodaMailing'];
    }

    /**
     * Set the "zgodaMarketing" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setZgodaMarketing($value)
    {
        if (!isset($this->data['fields']['zgodaMarketing'])) {
            if (!$this->isNew()) {
                $this->getZgodaMarketing();
                if ($value === $this->data['fields']['zgodaMarketing']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['zgodaMarketing'] = null;
                $this->data['fields']['zgodaMarketing'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['zgodaMarketing']) {
            return $this;
        }

        if (!isset($this->fieldsModified['zgodaMarketing']) && !array_key_exists('zgodaMarketing', $this->fieldsModified)) {
            $this->fieldsModified['zgodaMarketing'] = $this->data['fields']['zgodaMarketing'];
        } elseif ($value === $this->fieldsModified['zgodaMarketing']) {
            unset($this->fieldsModified['zgodaMarketing']);
        }

        $this->data['fields']['zgodaMarketing'] = $value;

        return $this;
    }

    /**
     * Returns the "zgodaMarketing" field.
     *
     * @return mixed The $name field.
     */
    public function getZgodaMarketing()
    {
        if (!isset($this->data['fields']['zgodaMarketing'])) {
            if ($this->isNew()) {
                $this->data['fields']['zgodaMarketing'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('zgodaMarketing', $this->data['fields'])) {
                $this->addFieldCache('zgodaMarketing');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('zgodaMarketing' => 1));
                if (isset($data['zgodaMarketing'])) {
                    $this->data['fields']['zgodaMarketing'] = (int) $data['zgodaMarketing'];
                } else {
                    $this->data['fields']['zgodaMarketing'] = null;
                }
            }
        }

        return $this->data['fields']['zgodaMarketing'];
    }

    /**
     * Set the "typAktywacji" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setTypAktywacji($value)
    {
        if (!isset($this->data['fields']['typAktywacji'])) {
            if (!$this->isNew()) {
                $this->getTypAktywacji();
                if ($value === $this->data['fields']['typAktywacji']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['typAktywacji'] = null;
                $this->data['fields']['typAktywacji'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['typAktywacji']) {
            return $this;
        }

        if (!isset($this->fieldsModified['typAktywacji']) && !array_key_exists('typAktywacji', $this->fieldsModified)) {
            $this->fieldsModified['typAktywacji'] = $this->data['fields']['typAktywacji'];
        } elseif ($value === $this->fieldsModified['typAktywacji']) {
            unset($this->fieldsModified['typAktywacji']);
        }

        $this->data['fields']['typAktywacji'] = $value;

        return $this;
    }

    /**
     * Returns the "typAktywacji" field.
     *
     * @return mixed The $name field.
     */
    public function getTypAktywacji()
    {
        if (!isset($this->data['fields']['typAktywacji'])) {
            if ($this->isNew()) {
                $this->data['fields']['typAktywacji'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('typAktywacji', $this->data['fields'])) {
                $this->addFieldCache('typAktywacji');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('typAktywacji' => 1));
                if (isset($data['typAktywacji'])) {
                    $this->data['fields']['typAktywacji'] = (string) $data['typAktywacji'];
                } else {
                    $this->data['fields']['typAktywacji'] = null;
                }
            }
        }

        return $this->data['fields']['typAktywacji'];
    }

    /**
     * Set the "numerKontaBankowego" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setNumerKontaBankowego($value)
    {
        if (!isset($this->data['fields']['numerKontaBankowego'])) {
            if (!$this->isNew()) {
                $this->getNumerKontaBankowego();
                if ($value === $this->data['fields']['numerKontaBankowego']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['numerKontaBankowego'] = null;
                $this->data['fields']['numerKontaBankowego'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['numerKontaBankowego']) {
            return $this;
        }

        if (!isset($this->fieldsModified['numerKontaBankowego']) && !array_key_exists('numerKontaBankowego', $this->fieldsModified)) {
            $this->fieldsModified['numerKontaBankowego'] = $this->data['fields']['numerKontaBankowego'];
        } elseif ($value === $this->fieldsModified['numerKontaBankowego']) {
            unset($this->fieldsModified['numerKontaBankowego']);
        }

        $this->data['fields']['numerKontaBankowego'] = $value;

        return $this;
    }

    /**
     * Returns the "numerKontaBankowego" field.
     *
     * @return mixed The $name field.
     */
    public function getNumerKontaBankowego()
    {
        if (!isset($this->data['fields']['numerKontaBankowego'])) {
            if ($this->isNew()) {
                $this->data['fields']['numerKontaBankowego'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('numerKontaBankowego', $this->data['fields'])) {
                $this->addFieldCache('numerKontaBankowego');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('numerKontaBankowego' => 1));
                if (isset($data['numerKontaBankowego'])) {
                    $this->data['fields']['numerKontaBankowego'] = (string) $data['numerKontaBankowego'];
                } else {
                    $this->data['fields']['numerKontaBankowego'] = null;
                }
            }
        }

        return $this->data['fields']['numerKontaBankowego'];
    }

    /**
     * Set the "numerUmowy" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setNumerUmowy($value)
    {
        if (!isset($this->data['fields']['numerUmowy'])) {
            if (!$this->isNew()) {
                $this->getNumerUmowy();
                if ($value === $this->data['fields']['numerUmowy']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['numerUmowy'] = null;
                $this->data['fields']['numerUmowy'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['numerUmowy']) {
            return $this;
        }

        if (!isset($this->fieldsModified['numerUmowy']) && !array_key_exists('numerUmowy', $this->fieldsModified)) {
            $this->fieldsModified['numerUmowy'] = $this->data['fields']['numerUmowy'];
        } elseif ($value === $this->fieldsModified['numerUmowy']) {
            unset($this->fieldsModified['numerUmowy']);
        }

        $this->data['fields']['numerUmowy'] = $value;

        return $this;
    }

    /**
     * Returns the "numerUmowy" field.
     *
     * @return mixed The $name field.
     */
    public function getNumerUmowy()
    {
        if (!isset($this->data['fields']['numerUmowy'])) {
            if ($this->isNew()) {
                $this->data['fields']['numerUmowy'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('numerUmowy', $this->data['fields'])) {
                $this->addFieldCache('numerUmowy');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('numerUmowy' => 1));
                if (isset($data['numerUmowy'])) {
                    $this->data['fields']['numerUmowy'] = (string) $data['numerUmowy'];
                } else {
                    $this->data['fields']['numerUmowy'] = null;
                }
            }
        }

        return $this->data['fields']['numerUmowy'];
    }

    /**
     * Set the "mapaSzerokosc" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setMapaSzerokosc($value)
    {
        if (!isset($this->data['fields']['mapaSzerokosc'])) {
            if (!$this->isNew()) {
                $this->getMapaSzerokosc();
                if ($value === $this->data['fields']['mapaSzerokosc']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['mapaSzerokosc'] = null;
                $this->data['fields']['mapaSzerokosc'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['mapaSzerokosc']) {
            return $this;
        }

        if (!isset($this->fieldsModified['mapaSzerokosc']) && !array_key_exists('mapaSzerokosc', $this->fieldsModified)) {
            $this->fieldsModified['mapaSzerokosc'] = $this->data['fields']['mapaSzerokosc'];
        } elseif ($value === $this->fieldsModified['mapaSzerokosc']) {
            unset($this->fieldsModified['mapaSzerokosc']);
        }

        $this->data['fields']['mapaSzerokosc'] = $value;

        return $this;
    }

    /**
     * Returns the "mapaSzerokosc" field.
     *
     * @return mixed The $name field.
     */
    public function getMapaSzerokosc()
    {
        if (!isset($this->data['fields']['mapaSzerokosc'])) {
            if ($this->isNew()) {
                $this->data['fields']['mapaSzerokosc'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('mapaSzerokosc', $this->data['fields'])) {
                $this->addFieldCache('mapaSzerokosc');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('mapaSzerokosc' => 1));
                if (isset($data['mapaSzerokosc'])) {
                    $this->data['fields']['mapaSzerokosc'] = (string) $data['mapaSzerokosc'];
                } else {
                    $this->data['fields']['mapaSzerokosc'] = null;
                }
            }
        }

        return $this->data['fields']['mapaSzerokosc'];
    }

    /**
     * Set the "mapaDlugosc" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function setMapaDlugosc($value)
    {
        if (!isset($this->data['fields']['mapaDlugosc'])) {
            if (!$this->isNew()) {
                $this->getMapaDlugosc();
                if ($value === $this->data['fields']['mapaDlugosc']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['mapaDlugosc'] = null;
                $this->data['fields']['mapaDlugosc'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['mapaDlugosc']) {
            return $this;
        }

        if (!isset($this->fieldsModified['mapaDlugosc']) && !array_key_exists('mapaDlugosc', $this->fieldsModified)) {
            $this->fieldsModified['mapaDlugosc'] = $this->data['fields']['mapaDlugosc'];
        } elseif ($value === $this->fieldsModified['mapaDlugosc']) {
            unset($this->fieldsModified['mapaDlugosc']);
        }

        $this->data['fields']['mapaDlugosc'] = $value;

        return $this;
    }

    /**
     * Returns the "mapaDlugosc" field.
     *
     * @return mixed The $name field.
     */
    public function getMapaDlugosc()
    {
        if (!isset($this->data['fields']['mapaDlugosc'])) {
            if ($this->isNew()) {
                $this->data['fields']['mapaDlugosc'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('mapaDlugosc', $this->data['fields'])) {
                $this->addFieldCache('mapaDlugosc');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('mapaDlugosc' => 1));
                if (isset($data['mapaDlugosc'])) {
                    $this->data['fields']['mapaDlugosc'] = (string) $data['mapaDlugosc'];
                } else {
                    $this->data['fields']['mapaDlugosc'] = null;
                }
            }
        }

        return $this->data['fields']['mapaDlugosc'];
    }

    /**
     * Process onDelete.
     */
    public function processOnDelete()
    {
    }

    private function processOnDeleteCascade($class, array $criteria)
    {
        $repository = $this->getMandango()->getRepository($class);
        $documents = $repository->createQuery($criteria)->all();
        if (count($documents)) {
            $repository->delete($documents);
        }
    }

    private function processOnDeleteUnset($class, array $criteria, array $update)
    {
        $this->getMandango()->getRepository($class)->update($criteria, $update, array('multiple' => true));
    }

    /**
     * Set a document data value by data name as string.
     *
     * @param string $name  The data name.
     * @param mixed  $value The value.
     *
     * @return mixed the data name setter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function set($name, $value)
    {
        if ('dataWersji' == $name) {
            return $this->setDataWersji($value);
        }
        if ('idTworzacegoWersje' == $name) {
            return $this->setIdTworzacegoWersje($value);
        }
        if ('idObiektu' == $name) {
            return $this->setIdObiektu($value);
        }
        if ('idProjektu' == $name) {
            return $this->setIdProjektu($value);
        }
        if ('login' == $name) {
            return $this->setLogin($value);
        }
        if ('haslo' == $name) {
            return $this->setHaslo($value);
        }
        if ('email' == $name) {
            return $this->setEmail($value);
        }
        if ('dataDodania' == $name) {
            return $this->setDataDodania($value);
        }
        if ('dataAktywacji' == $name) {
            return $this->setDataAktywacji($value);
        }
        if ('token' == $name) {
            return $this->setToken($value);
        }
        if ('czyAdmin' == $name) {
            return $this->setCzyAdmin($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('imie' == $name) {
            return $this->setImie($value);
        }
        if ('nazwisko' == $name) {
            return $this->setNazwisko($value);
        }
        if ('dataUrodzenia' == $name) {
            return $this->setDataUrodzenia($value);
        }
        if ('plec' == $name) {
            return $this->setPlec($value);
        }
        if ('kontaktTelefon' == $name) {
            return $this->setKontaktTelefon($value);
        }
        if ('kontaktKomorka' == $name) {
            return $this->setKontaktKomorka($value);
        }
        if ('kontaktFax' == $name) {
            return $this->setKontaktFax($value);
        }
        if ('kontaktWWW' == $name) {
            return $this->setKontaktWWW($value);
        }
        if ('kontaktNazwa' == $name) {
            return $this->setKontaktNazwa($value);
        }
        if ('kontaktAdres' == $name) {
            return $this->setKontaktAdres($value);
        }
        if ('kontaktKodPocztowy' == $name) {
            return $this->setKontaktKodPocztowy($value);
        }
        if ('kontaktMiasto' == $name) {
            return $this->setKontaktMiasto($value);
        }
        if ('firmaNazwa' == $name) {
            return $this->setFirmaNazwa($value);
        }
        if ('firmaNip' == $name) {
            return $this->setFirmaNip($value);
        }
        if ('firmaAdres' == $name) {
            return $this->setFirmaAdres($value);
        }
        if ('firmaKodPocztowy' == $name) {
            return $this->setFirmaKodPocztowy($value);
        }
        if ('firmaMiasto' == $name) {
            return $this->setFirmaMiasto($value);
        }
        if ('pocztaHost' == $name) {
            return $this->setPocztaHost($value);
        }
        if ('pocztaPort' == $name) {
            return $this->setPocztaPort($value);
        }
        if ('pocztaLogin' == $name) {
            return $this->setPocztaLogin($value);
        }
        if ('pocztaHaslo' == $name) {
            return $this->setPocztaHaslo($value);
        }
        if ('jezyk' == $name) {
            return $this->setJezyk($value);
        }
        if ('zgodaMailing' == $name) {
            return $this->setZgodaMailing($value);
        }
        if ('zgodaMarketing' == $name) {
            return $this->setZgodaMarketing($value);
        }
        if ('typAktywacji' == $name) {
            return $this->setTypAktywacji($value);
        }
        if ('numerKontaBankowego' == $name) {
            return $this->setNumerKontaBankowego($value);
        }
        if ('numerUmowy' == $name) {
            return $this->setNumerUmowy($value);
        }
        if ('mapaSzerokosc' == $name) {
            return $this->setMapaSzerokosc($value);
        }
        if ('mapaDlugosc' == $name) {
            return $this->setMapaDlugosc($value);
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Returns a document data by data name as string.
     *
     * @param string $name The data name.
     *
     * @return mixed The data name getter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function get($name)
    {
        if ('dataWersji' == $name) {
            return $this->getDataWersji();
        }
        if ('idTworzacegoWersje' == $name) {
            return $this->getIdTworzacegoWersje();
        }
        if ('idObiektu' == $name) {
            return $this->getIdObiektu();
        }
        if ('idProjektu' == $name) {
            return $this->getIdProjektu();
        }
        if ('login' == $name) {
            return $this->getLogin();
        }
        if ('haslo' == $name) {
            return $this->getHaslo();
        }
        if ('email' == $name) {
            return $this->getEmail();
        }
        if ('dataDodania' == $name) {
            return $this->getDataDodania();
        }
        if ('dataAktywacji' == $name) {
            return $this->getDataAktywacji();
        }
        if ('token' == $name) {
            return $this->getToken();
        }
        if ('czyAdmin' == $name) {
            return $this->getCzyAdmin();
        }
        if ('status' == $name) {
            return $this->getStatus();
        }
        if ('imie' == $name) {
            return $this->getImie();
        }
        if ('nazwisko' == $name) {
            return $this->getNazwisko();
        }
        if ('dataUrodzenia' == $name) {
            return $this->getDataUrodzenia();
        }
        if ('plec' == $name) {
            return $this->getPlec();
        }
        if ('kontaktTelefon' == $name) {
            return $this->getKontaktTelefon();
        }
        if ('kontaktKomorka' == $name) {
            return $this->getKontaktKomorka();
        }
        if ('kontaktFax' == $name) {
            return $this->getKontaktFax();
        }
        if ('kontaktWWW' == $name) {
            return $this->getKontaktWWW();
        }
        if ('kontaktNazwa' == $name) {
            return $this->getKontaktNazwa();
        }
        if ('kontaktAdres' == $name) {
            return $this->getKontaktAdres();
        }
        if ('kontaktKodPocztowy' == $name) {
            return $this->getKontaktKodPocztowy();
        }
        if ('kontaktMiasto' == $name) {
            return $this->getKontaktMiasto();
        }
        if ('firmaNazwa' == $name) {
            return $this->getFirmaNazwa();
        }
        if ('firmaNip' == $name) {
            return $this->getFirmaNip();
        }
        if ('firmaAdres' == $name) {
            return $this->getFirmaAdres();
        }
        if ('firmaKodPocztowy' == $name) {
            return $this->getFirmaKodPocztowy();
        }
        if ('firmaMiasto' == $name) {
            return $this->getFirmaMiasto();
        }
        if ('pocztaHost' == $name) {
            return $this->getPocztaHost();
        }
        if ('pocztaPort' == $name) {
            return $this->getPocztaPort();
        }
        if ('pocztaLogin' == $name) {
            return $this->getPocztaLogin();
        }
        if ('pocztaHaslo' == $name) {
            return $this->getPocztaHaslo();
        }
        if ('jezyk' == $name) {
            return $this->getJezyk();
        }
        if ('zgodaMailing' == $name) {
            return $this->getZgodaMailing();
        }
        if ('zgodaMarketing' == $name) {
            return $this->getZgodaMarketing();
        }
        if ('typAktywacji' == $name) {
            return $this->getTypAktywacji();
        }
        if ('numerKontaBankowego' == $name) {
            return $this->getNumerKontaBankowego();
        }
        if ('numerUmowy' == $name) {
            return $this->getNumerUmowy();
        }
        if ('mapaSzerokosc' == $name) {
            return $this->getMapaSzerokosc();
        }
        if ('mapaDlugosc' == $name) {
            return $this->getMapaDlugosc();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Generic\ModelNosql\UzytkownikWersja The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['dataWersji'])) {
            $this->setDataWersji($array['dataWersji']);
        }
        if (isset($array['idTworzacegoWersje'])) {
            $this->setIdTworzacegoWersje($array['idTworzacegoWersje']);
        }
        if (isset($array['idObiektu'])) {
            $this->setIdObiektu($array['idObiektu']);
        }
        if (isset($array['idProjektu'])) {
            $this->setIdProjektu($array['idProjektu']);
        }
        if (isset($array['login'])) {
            $this->setLogin($array['login']);
        }
        if (isset($array['haslo'])) {
            $this->setHaslo($array['haslo']);
        }
        if (isset($array['email'])) {
            $this->setEmail($array['email']);
        }
        if (isset($array['dataDodania'])) {
            $this->setDataDodania($array['dataDodania']);
        }
        if (isset($array['dataAktywacji'])) {
            $this->setDataAktywacji($array['dataAktywacji']);
        }
        if (isset($array['token'])) {
            $this->setToken($array['token']);
        }
        if (isset($array['czyAdmin'])) {
            $this->setCzyAdmin($array['czyAdmin']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['imie'])) {
            $this->setImie($array['imie']);
        }
        if (isset($array['nazwisko'])) {
            $this->setNazwisko($array['nazwisko']);
        }
        if (isset($array['dataUrodzenia'])) {
            $this->setDataUrodzenia($array['dataUrodzenia']);
        }
        if (isset($array['plec'])) {
            $this->setPlec($array['plec']);
        }
        if (isset($array['kontaktTelefon'])) {
            $this->setKontaktTelefon($array['kontaktTelefon']);
        }
        if (isset($array['kontaktKomorka'])) {
            $this->setKontaktKomorka($array['kontaktKomorka']);
        }
        if (isset($array['kontaktFax'])) {
            $this->setKontaktFax($array['kontaktFax']);
        }
        if (isset($array['kontaktWWW'])) {
            $this->setKontaktWWW($array['kontaktWWW']);
        }
        if (isset($array['kontaktNazwa'])) {
            $this->setKontaktNazwa($array['kontaktNazwa']);
        }
        if (isset($array['kontaktAdres'])) {
            $this->setKontaktAdres($array['kontaktAdres']);
        }
        if (isset($array['kontaktKodPocztowy'])) {
            $this->setKontaktKodPocztowy($array['kontaktKodPocztowy']);
        }
        if (isset($array['kontaktMiasto'])) {
            $this->setKontaktMiasto($array['kontaktMiasto']);
        }
        if (isset($array['firmaNazwa'])) {
            $this->setFirmaNazwa($array['firmaNazwa']);
        }
        if (isset($array['firmaNip'])) {
            $this->setFirmaNip($array['firmaNip']);
        }
        if (isset($array['firmaAdres'])) {
            $this->setFirmaAdres($array['firmaAdres']);
        }
        if (isset($array['firmaKodPocztowy'])) {
            $this->setFirmaKodPocztowy($array['firmaKodPocztowy']);
        }
        if (isset($array['firmaMiasto'])) {
            $this->setFirmaMiasto($array['firmaMiasto']);
        }
        if (isset($array['pocztaHost'])) {
            $this->setPocztaHost($array['pocztaHost']);
        }
        if (isset($array['pocztaPort'])) {
            $this->setPocztaPort($array['pocztaPort']);
        }
        if (isset($array['pocztaLogin'])) {
            $this->setPocztaLogin($array['pocztaLogin']);
        }
        if (isset($array['pocztaHaslo'])) {
            $this->setPocztaHaslo($array['pocztaHaslo']);
        }
        if (isset($array['jezyk'])) {
            $this->setJezyk($array['jezyk']);
        }
        if (isset($array['zgodaMailing'])) {
            $this->setZgodaMailing($array['zgodaMailing']);
        }
        if (isset($array['zgodaMarketing'])) {
            $this->setZgodaMarketing($array['zgodaMarketing']);
        }
        if (isset($array['typAktywacji'])) {
            $this->setTypAktywacji($array['typAktywacji']);
        }
        if (isset($array['numerKontaBankowego'])) {
            $this->setNumerKontaBankowego($array['numerKontaBankowego']);
        }
        if (isset($array['numerUmowy'])) {
            $this->setNumerUmowy($array['numerUmowy']);
        }
        if (isset($array['mapaSzerokosc'])) {
            $this->setMapaSzerokosc($array['mapaSzerokosc']);
        }
        if (isset($array['mapaDlugosc'])) {
            $this->setMapaDlugosc($array['mapaDlugosc']);
        }

        return $this;
    }

    /**
     * Export the document data to an array.
     *
     * @param Boolean $withReferenceFields Whether include the fields of references or not (false by default).
     *
     * @return array An array with the document data.
     */
    public function toArray($withReferenceFields = false)
    {
        $array = array('id' => $this->getId());

        $array['dataWersji'] = $this->getDataWersji();
        $array['idTworzacegoWersje'] = $this->getIdTworzacegoWersje();
        $array['idObiektu'] = $this->getIdObiektu();
        $array['idProjektu'] = $this->getIdProjektu();
        $array['login'] = $this->getLogin();
        $array['haslo'] = $this->getHaslo();
        $array['email'] = $this->getEmail();
        $array['dataDodania'] = $this->getDataDodania();
        $array['dataAktywacji'] = $this->getDataAktywacji();
        $array['token'] = $this->getToken();
        $array['czyAdmin'] = $this->getCzyAdmin();
        $array['status'] = $this->getStatus();
        $array['imie'] = $this->getImie();
        $array['nazwisko'] = $this->getNazwisko();
        $array['dataUrodzenia'] = $this->getDataUrodzenia();
        $array['plec'] = $this->getPlec();
        $array['kontaktTelefon'] = $this->getKontaktTelefon();
        $array['kontaktKomorka'] = $this->getKontaktKomorka();
        $array['kontaktFax'] = $this->getKontaktFax();
        $array['kontaktWWW'] = $this->getKontaktWWW();
        $array['kontaktNazwa'] = $this->getKontaktNazwa();
        $array['kontaktAdres'] = $this->getKontaktAdres();
        $array['kontaktKodPocztowy'] = $this->getKontaktKodPocztowy();
        $array['kontaktMiasto'] = $this->getKontaktMiasto();
        $array['firmaNazwa'] = $this->getFirmaNazwa();
        $array['firmaNip'] = $this->getFirmaNip();
        $array['firmaAdres'] = $this->getFirmaAdres();
        $array['firmaKodPocztowy'] = $this->getFirmaKodPocztowy();
        $array['firmaMiasto'] = $this->getFirmaMiasto();
        $array['pocztaHost'] = $this->getPocztaHost();
        $array['pocztaPort'] = $this->getPocztaPort();
        $array['pocztaLogin'] = $this->getPocztaLogin();
        $array['pocztaHaslo'] = $this->getPocztaHaslo();
        $array['jezyk'] = $this->getJezyk();
        $array['zgodaMailing'] = $this->getZgodaMailing();
        $array['zgodaMarketing'] = $this->getZgodaMarketing();
        $array['typAktywacji'] = $this->getTypAktywacji();
        $array['numerKontaBankowego'] = $this->getNumerKontaBankowego();
        $array['numerUmowy'] = $this->getNumerUmowy();
        $array['mapaSzerokosc'] = $this->getMapaSzerokosc();
        $array['mapaDlugosc'] = $this->getMapaDlugosc();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave()
    {
        $isNew = $this->isNew();
        $query = array();
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['dataWersji'])) {
                    $query['dataWersji'] = $this->data['fields']['dataWersji']; if ($query['dataWersji'] instanceof \DateTime) { $query['dataWersji'] = $this->data['fields']['dataWersji']->getTimestamp(); } elseif (is_string($query['dataWersji'])) { $query['dataWersji'] = strtotime($this->data['fields']['dataWersji']); } $query['dataWersji'] = new \MongoDate($query['dataWersji']);
                }
                if (isset($this->data['fields']['idTworzacegoWersje'])) {
                    $query['idTworzacegoWersje'] = (int) $this->data['fields']['idTworzacegoWersje'];
                }
                if (isset($this->data['fields']['idObiektu'])) {
                    $query['idObiektu'] = (int) $this->data['fields']['idObiektu'];
                }
                if (isset($this->data['fields']['idProjektu'])) {
                    $query['idProjektu'] = (int) $this->data['fields']['idProjektu'];
                }
                if (isset($this->data['fields']['login'])) {
                    $query['login'] = (string) $this->data['fields']['login'];
                }
                if (isset($this->data['fields']['haslo'])) {
                    $query['haslo'] = (string) $this->data['fields']['haslo'];
                }
                if (isset($this->data['fields']['email'])) {
                    $query['email'] = (string) $this->data['fields']['email'];
                }
                if (isset($this->data['fields']['dataDodania'])) {
                    $query['dataDodania'] = $this->data['fields']['dataDodania']; if ($query['dataDodania'] instanceof \DateTime) { $query['dataDodania'] = $this->data['fields']['dataDodania']->getTimestamp(); } elseif (is_string($query['dataDodania'])) { $query['dataDodania'] = strtotime($this->data['fields']['dataDodania']); } $query['dataDodania'] = new \MongoDate($query['dataDodania']);
                }
                if (isset($this->data['fields']['dataAktywacji'])) {
                    $query['dataAktywacji'] = $this->data['fields']['dataAktywacji']; if ($query['dataAktywacji'] instanceof \DateTime) { $query['dataAktywacji'] = $this->data['fields']['dataAktywacji']->getTimestamp(); } elseif (is_string($query['dataAktywacji'])) { $query['dataAktywacji'] = strtotime($this->data['fields']['dataAktywacji']); } $query['dataAktywacji'] = new \MongoDate($query['dataAktywacji']);
                }
                if (isset($this->data['fields']['token'])) {
                    $query['token'] = (string) $this->data['fields']['token'];
                }
                if (isset($this->data['fields']['czyAdmin'])) {
                    $query['czyAdmin'] = (bool) $this->data['fields']['czyAdmin'];
                }
                if (isset($this->data['fields']['status'])) {
                    $query['status'] = (string) $this->data['fields']['status'];
                }
                if (isset($this->data['fields']['imie'])) {
                    $query['imie'] = (string) $this->data['fields']['imie'];
                }
                if (isset($this->data['fields']['nazwisko'])) {
                    $query['nazwisko'] = (string) $this->data['fields']['nazwisko'];
                }
                if (isset($this->data['fields']['dataUrodzenia'])) {
                    $query['dataUrodzenia'] = $this->data['fields']['dataUrodzenia']; if ($query['dataUrodzenia'] instanceof \DateTime) { $query['dataUrodzenia'] = $this->data['fields']['dataUrodzenia']->getTimestamp(); } elseif (is_string($query['dataUrodzenia'])) { $query['dataUrodzenia'] = strtotime($this->data['fields']['dataUrodzenia']); } $query['dataUrodzenia'] = new \MongoDate($query['dataUrodzenia']);
                }
                if (isset($this->data['fields']['plec'])) {
                    $query['plec'] = (string) $this->data['fields']['plec'];
                }
                if (isset($this->data['fields']['kontaktTelefon'])) {
                    $query['kontaktTelefon'] = (string) $this->data['fields']['kontaktTelefon'];
                }
                if (isset($this->data['fields']['kontaktKomorka'])) {
                    $query['kontaktKomorka'] = (string) $this->data['fields']['kontaktKomorka'];
                }
                if (isset($this->data['fields']['kontaktFax'])) {
                    $query['kontaktFax'] = (string) $this->data['fields']['kontaktFax'];
                }
                if (isset($this->data['fields']['kontaktWWW'])) {
                    $query['kontaktWWW'] = (string) $this->data['fields']['kontaktWWW'];
                }
                if (isset($this->data['fields']['kontaktNazwa'])) {
                    $query['kontaktNazwa'] = (string) $this->data['fields']['kontaktNazwa'];
                }
                if (isset($this->data['fields']['kontaktAdres'])) {
                    $query['kontaktAdres'] = (string) $this->data['fields']['kontaktAdres'];
                }
                if (isset($this->data['fields']['kontaktKodPocztowy'])) {
                    $query['kontaktKodPocztowy'] = (string) $this->data['fields']['kontaktKodPocztowy'];
                }
                if (isset($this->data['fields']['kontaktMiasto'])) {
                    $query['kontaktMiasto'] = (string) $this->data['fields']['kontaktMiasto'];
                }
                if (isset($this->data['fields']['firmaNazwa'])) {
                    $query['firmaNazwa'] = (string) $this->data['fields']['firmaNazwa'];
                }
                if (isset($this->data['fields']['firmaNip'])) {
                    $query['firmaNip'] = (string) $this->data['fields']['firmaNip'];
                }
                if (isset($this->data['fields']['firmaAdres'])) {
                    $query['firmaAdres'] = (string) $this->data['fields']['firmaAdres'];
                }
                if (isset($this->data['fields']['firmaKodPocztowy'])) {
                    $query['firmaKodPocztowy'] = (string) $this->data['fields']['firmaKodPocztowy'];
                }
                if (isset($this->data['fields']['firmaMiasto'])) {
                    $query['firmaMiasto'] = (string) $this->data['fields']['firmaMiasto'];
                }
                if (isset($this->data['fields']['pocztaHost'])) {
                    $query['pocztaHost'] = (string) $this->data['fields']['pocztaHost'];
                }
                if (isset($this->data['fields']['pocztaPort'])) {
                    $query['pocztaPort'] = (int) $this->data['fields']['pocztaPort'];
                }
                if (isset($this->data['fields']['pocztaLogin'])) {
                    $query['pocztaLogin'] = (string) $this->data['fields']['pocztaLogin'];
                }
                if (isset($this->data['fields']['pocztaHaslo'])) {
                    $query['pocztaHaslo'] = (string) $this->data['fields']['pocztaHaslo'];
                }
                if (isset($this->data['fields']['jezyk'])) {
                    $query['jezyk'] = (string) $this->data['fields']['jezyk'];
                }
                if (isset($this->data['fields']['zgodaMailing'])) {
                    $query['zgodaMailing'] = (int) $this->data['fields']['zgodaMailing'];
                }
                if (isset($this->data['fields']['zgodaMarketing'])) {
                    $query['zgodaMarketing'] = (int) $this->data['fields']['zgodaMarketing'];
                }
                if (isset($this->data['fields']['typAktywacji'])) {
                    $query['typAktywacji'] = (string) $this->data['fields']['typAktywacji'];
                }
                if (isset($this->data['fields']['numerKontaBankowego'])) {
                    $query['numerKontaBankowego'] = (string) $this->data['fields']['numerKontaBankowego'];
                }
                if (isset($this->data['fields']['numerUmowy'])) {
                    $query['numerUmowy'] = (string) $this->data['fields']['numerUmowy'];
                }
                if (isset($this->data['fields']['mapaSzerokosc'])) {
                    $query['mapaSzerokosc'] = (string) $this->data['fields']['mapaSzerokosc'];
                }
                if (isset($this->data['fields']['mapaDlugosc'])) {
                    $query['mapaDlugosc'] = (string) $this->data['fields']['mapaDlugosc'];
                }
            } else {
                if (isset($this->data['fields']['dataWersji']) || array_key_exists('dataWersji', $this->data['fields'])) {
                    $value = $this->data['fields']['dataWersji'];
                    $originalValue = $this->getOriginalFieldValue('dataWersji');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['dataWersji'] = $this->data['fields']['dataWersji']; if ($query['$set']['dataWersji'] instanceof \DateTime) { $query['$set']['dataWersji'] = $this->data['fields']['dataWersji']->getTimestamp(); } elseif (is_string($query['$set']['dataWersji'])) { $query['$set']['dataWersji'] = strtotime($this->data['fields']['dataWersji']); } $query['$set']['dataWersji'] = new \MongoDate($query['$set']['dataWersji']);
                        } else {
                            $query['$unset']['dataWersji'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['idTworzacegoWersje']) || array_key_exists('idTworzacegoWersje', $this->data['fields'])) {
                    $value = $this->data['fields']['idTworzacegoWersje'];
                    $originalValue = $this->getOriginalFieldValue('idTworzacegoWersje');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['idTworzacegoWersje'] = (int) $this->data['fields']['idTworzacegoWersje'];
                        } else {
                            $query['$unset']['idTworzacegoWersje'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['idObiektu']) || array_key_exists('idObiektu', $this->data['fields'])) {
                    $value = $this->data['fields']['idObiektu'];
                    $originalValue = $this->getOriginalFieldValue('idObiektu');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['idObiektu'] = (int) $this->data['fields']['idObiektu'];
                        } else {
                            $query['$unset']['idObiektu'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['idProjektu']) || array_key_exists('idProjektu', $this->data['fields'])) {
                    $value = $this->data['fields']['idProjektu'];
                    $originalValue = $this->getOriginalFieldValue('idProjektu');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['idProjektu'] = (int) $this->data['fields']['idProjektu'];
                        } else {
                            $query['$unset']['idProjektu'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['login']) || array_key_exists('login', $this->data['fields'])) {
                    $value = $this->data['fields']['login'];
                    $originalValue = $this->getOriginalFieldValue('login');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['login'] = (string) $this->data['fields']['login'];
                        } else {
                            $query['$unset']['login'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['haslo']) || array_key_exists('haslo', $this->data['fields'])) {
                    $value = $this->data['fields']['haslo'];
                    $originalValue = $this->getOriginalFieldValue('haslo');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['haslo'] = (string) $this->data['fields']['haslo'];
                        } else {
                            $query['$unset']['haslo'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['email']) || array_key_exists('email', $this->data['fields'])) {
                    $value = $this->data['fields']['email'];
                    $originalValue = $this->getOriginalFieldValue('email');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['email'] = (string) $this->data['fields']['email'];
                        } else {
                            $query['$unset']['email'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['dataDodania']) || array_key_exists('dataDodania', $this->data['fields'])) {
                    $value = $this->data['fields']['dataDodania'];
                    $originalValue = $this->getOriginalFieldValue('dataDodania');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['dataDodania'] = $this->data['fields']['dataDodania']; if ($query['$set']['dataDodania'] instanceof \DateTime) { $query['$set']['dataDodania'] = $this->data['fields']['dataDodania']->getTimestamp(); } elseif (is_string($query['$set']['dataDodania'])) { $query['$set']['dataDodania'] = strtotime($this->data['fields']['dataDodania']); } $query['$set']['dataDodania'] = new \MongoDate($query['$set']['dataDodania']);
                        } else {
                            $query['$unset']['dataDodania'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['dataAktywacji']) || array_key_exists('dataAktywacji', $this->data['fields'])) {
                    $value = $this->data['fields']['dataAktywacji'];
                    $originalValue = $this->getOriginalFieldValue('dataAktywacji');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['dataAktywacji'] = $this->data['fields']['dataAktywacji']; if ($query['$set']['dataAktywacji'] instanceof \DateTime) { $query['$set']['dataAktywacji'] = $this->data['fields']['dataAktywacji']->getTimestamp(); } elseif (is_string($query['$set']['dataAktywacji'])) { $query['$set']['dataAktywacji'] = strtotime($this->data['fields']['dataAktywacji']); } $query['$set']['dataAktywacji'] = new \MongoDate($query['$set']['dataAktywacji']);
                        } else {
                            $query['$unset']['dataAktywacji'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['token']) || array_key_exists('token', $this->data['fields'])) {
                    $value = $this->data['fields']['token'];
                    $originalValue = $this->getOriginalFieldValue('token');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['token'] = (string) $this->data['fields']['token'];
                        } else {
                            $query['$unset']['token'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['czyAdmin']) || array_key_exists('czyAdmin', $this->data['fields'])) {
                    $value = $this->data['fields']['czyAdmin'];
                    $originalValue = $this->getOriginalFieldValue('czyAdmin');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['czyAdmin'] = (bool) $this->data['fields']['czyAdmin'];
                        } else {
                            $query['$unset']['czyAdmin'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['status']) || array_key_exists('status', $this->data['fields'])) {
                    $value = $this->data['fields']['status'];
                    $originalValue = $this->getOriginalFieldValue('status');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['status'] = (string) $this->data['fields']['status'];
                        } else {
                            $query['$unset']['status'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['imie']) || array_key_exists('imie', $this->data['fields'])) {
                    $value = $this->data['fields']['imie'];
                    $originalValue = $this->getOriginalFieldValue('imie');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['imie'] = (string) $this->data['fields']['imie'];
                        } else {
                            $query['$unset']['imie'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['nazwisko']) || array_key_exists('nazwisko', $this->data['fields'])) {
                    $value = $this->data['fields']['nazwisko'];
                    $originalValue = $this->getOriginalFieldValue('nazwisko');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['nazwisko'] = (string) $this->data['fields']['nazwisko'];
                        } else {
                            $query['$unset']['nazwisko'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['dataUrodzenia']) || array_key_exists('dataUrodzenia', $this->data['fields'])) {
                    $value = $this->data['fields']['dataUrodzenia'];
                    $originalValue = $this->getOriginalFieldValue('dataUrodzenia');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['dataUrodzenia'] = $this->data['fields']['dataUrodzenia']; if ($query['$set']['dataUrodzenia'] instanceof \DateTime) { $query['$set']['dataUrodzenia'] = $this->data['fields']['dataUrodzenia']->getTimestamp(); } elseif (is_string($query['$set']['dataUrodzenia'])) { $query['$set']['dataUrodzenia'] = strtotime($this->data['fields']['dataUrodzenia']); } $query['$set']['dataUrodzenia'] = new \MongoDate($query['$set']['dataUrodzenia']);
                        } else {
                            $query['$unset']['dataUrodzenia'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['plec']) || array_key_exists('plec', $this->data['fields'])) {
                    $value = $this->data['fields']['plec'];
                    $originalValue = $this->getOriginalFieldValue('plec');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['plec'] = (string) $this->data['fields']['plec'];
                        } else {
                            $query['$unset']['plec'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktTelefon']) || array_key_exists('kontaktTelefon', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktTelefon'];
                    $originalValue = $this->getOriginalFieldValue('kontaktTelefon');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktTelefon'] = (string) $this->data['fields']['kontaktTelefon'];
                        } else {
                            $query['$unset']['kontaktTelefon'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktKomorka']) || array_key_exists('kontaktKomorka', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktKomorka'];
                    $originalValue = $this->getOriginalFieldValue('kontaktKomorka');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktKomorka'] = (string) $this->data['fields']['kontaktKomorka'];
                        } else {
                            $query['$unset']['kontaktKomorka'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktFax']) || array_key_exists('kontaktFax', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktFax'];
                    $originalValue = $this->getOriginalFieldValue('kontaktFax');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktFax'] = (string) $this->data['fields']['kontaktFax'];
                        } else {
                            $query['$unset']['kontaktFax'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktWWW']) || array_key_exists('kontaktWWW', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktWWW'];
                    $originalValue = $this->getOriginalFieldValue('kontaktWWW');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktWWW'] = (string) $this->data['fields']['kontaktWWW'];
                        } else {
                            $query['$unset']['kontaktWWW'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktNazwa']) || array_key_exists('kontaktNazwa', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktNazwa'];
                    $originalValue = $this->getOriginalFieldValue('kontaktNazwa');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktNazwa'] = (string) $this->data['fields']['kontaktNazwa'];
                        } else {
                            $query['$unset']['kontaktNazwa'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktAdres']) || array_key_exists('kontaktAdres', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktAdres'];
                    $originalValue = $this->getOriginalFieldValue('kontaktAdres');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktAdres'] = (string) $this->data['fields']['kontaktAdres'];
                        } else {
                            $query['$unset']['kontaktAdres'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktKodPocztowy']) || array_key_exists('kontaktKodPocztowy', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktKodPocztowy'];
                    $originalValue = $this->getOriginalFieldValue('kontaktKodPocztowy');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktKodPocztowy'] = (string) $this->data['fields']['kontaktKodPocztowy'];
                        } else {
                            $query['$unset']['kontaktKodPocztowy'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['kontaktMiasto']) || array_key_exists('kontaktMiasto', $this->data['fields'])) {
                    $value = $this->data['fields']['kontaktMiasto'];
                    $originalValue = $this->getOriginalFieldValue('kontaktMiasto');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['kontaktMiasto'] = (string) $this->data['fields']['kontaktMiasto'];
                        } else {
                            $query['$unset']['kontaktMiasto'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['firmaNazwa']) || array_key_exists('firmaNazwa', $this->data['fields'])) {
                    $value = $this->data['fields']['firmaNazwa'];
                    $originalValue = $this->getOriginalFieldValue('firmaNazwa');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['firmaNazwa'] = (string) $this->data['fields']['firmaNazwa'];
                        } else {
                            $query['$unset']['firmaNazwa'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['firmaNip']) || array_key_exists('firmaNip', $this->data['fields'])) {
                    $value = $this->data['fields']['firmaNip'];
                    $originalValue = $this->getOriginalFieldValue('firmaNip');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['firmaNip'] = (string) $this->data['fields']['firmaNip'];
                        } else {
                            $query['$unset']['firmaNip'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['firmaAdres']) || array_key_exists('firmaAdres', $this->data['fields'])) {
                    $value = $this->data['fields']['firmaAdres'];
                    $originalValue = $this->getOriginalFieldValue('firmaAdres');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['firmaAdres'] = (string) $this->data['fields']['firmaAdres'];
                        } else {
                            $query['$unset']['firmaAdres'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['firmaKodPocztowy']) || array_key_exists('firmaKodPocztowy', $this->data['fields'])) {
                    $value = $this->data['fields']['firmaKodPocztowy'];
                    $originalValue = $this->getOriginalFieldValue('firmaKodPocztowy');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['firmaKodPocztowy'] = (string) $this->data['fields']['firmaKodPocztowy'];
                        } else {
                            $query['$unset']['firmaKodPocztowy'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['firmaMiasto']) || array_key_exists('firmaMiasto', $this->data['fields'])) {
                    $value = $this->data['fields']['firmaMiasto'];
                    $originalValue = $this->getOriginalFieldValue('firmaMiasto');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['firmaMiasto'] = (string) $this->data['fields']['firmaMiasto'];
                        } else {
                            $query['$unset']['firmaMiasto'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['pocztaHost']) || array_key_exists('pocztaHost', $this->data['fields'])) {
                    $value = $this->data['fields']['pocztaHost'];
                    $originalValue = $this->getOriginalFieldValue('pocztaHost');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['pocztaHost'] = (string) $this->data['fields']['pocztaHost'];
                        } else {
                            $query['$unset']['pocztaHost'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['pocztaPort']) || array_key_exists('pocztaPort', $this->data['fields'])) {
                    $value = $this->data['fields']['pocztaPort'];
                    $originalValue = $this->getOriginalFieldValue('pocztaPort');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['pocztaPort'] = (int) $this->data['fields']['pocztaPort'];
                        } else {
                            $query['$unset']['pocztaPort'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['pocztaLogin']) || array_key_exists('pocztaLogin', $this->data['fields'])) {
                    $value = $this->data['fields']['pocztaLogin'];
                    $originalValue = $this->getOriginalFieldValue('pocztaLogin');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['pocztaLogin'] = (string) $this->data['fields']['pocztaLogin'];
                        } else {
                            $query['$unset']['pocztaLogin'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['pocztaHaslo']) || array_key_exists('pocztaHaslo', $this->data['fields'])) {
                    $value = $this->data['fields']['pocztaHaslo'];
                    $originalValue = $this->getOriginalFieldValue('pocztaHaslo');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['pocztaHaslo'] = (string) $this->data['fields']['pocztaHaslo'];
                        } else {
                            $query['$unset']['pocztaHaslo'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['jezyk']) || array_key_exists('jezyk', $this->data['fields'])) {
                    $value = $this->data['fields']['jezyk'];
                    $originalValue = $this->getOriginalFieldValue('jezyk');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['jezyk'] = (string) $this->data['fields']['jezyk'];
                        } else {
                            $query['$unset']['jezyk'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['zgodaMailing']) || array_key_exists('zgodaMailing', $this->data['fields'])) {
                    $value = $this->data['fields']['zgodaMailing'];
                    $originalValue = $this->getOriginalFieldValue('zgodaMailing');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['zgodaMailing'] = (int) $this->data['fields']['zgodaMailing'];
                        } else {
                            $query['$unset']['zgodaMailing'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['zgodaMarketing']) || array_key_exists('zgodaMarketing', $this->data['fields'])) {
                    $value = $this->data['fields']['zgodaMarketing'];
                    $originalValue = $this->getOriginalFieldValue('zgodaMarketing');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['zgodaMarketing'] = (int) $this->data['fields']['zgodaMarketing'];
                        } else {
                            $query['$unset']['zgodaMarketing'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['typAktywacji']) || array_key_exists('typAktywacji', $this->data['fields'])) {
                    $value = $this->data['fields']['typAktywacji'];
                    $originalValue = $this->getOriginalFieldValue('typAktywacji');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['typAktywacji'] = (string) $this->data['fields']['typAktywacji'];
                        } else {
                            $query['$unset']['typAktywacji'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['numerKontaBankowego']) || array_key_exists('numerKontaBankowego', $this->data['fields'])) {
                    $value = $this->data['fields']['numerKontaBankowego'];
                    $originalValue = $this->getOriginalFieldValue('numerKontaBankowego');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['numerKontaBankowego'] = (string) $this->data['fields']['numerKontaBankowego'];
                        } else {
                            $query['$unset']['numerKontaBankowego'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['numerUmowy']) || array_key_exists('numerUmowy', $this->data['fields'])) {
                    $value = $this->data['fields']['numerUmowy'];
                    $originalValue = $this->getOriginalFieldValue('numerUmowy');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['numerUmowy'] = (string) $this->data['fields']['numerUmowy'];
                        } else {
                            $query['$unset']['numerUmowy'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['mapaSzerokosc']) || array_key_exists('mapaSzerokosc', $this->data['fields'])) {
                    $value = $this->data['fields']['mapaSzerokosc'];
                    $originalValue = $this->getOriginalFieldValue('mapaSzerokosc');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['mapaSzerokosc'] = (string) $this->data['fields']['mapaSzerokosc'];
                        } else {
                            $query['$unset']['mapaSzerokosc'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['mapaDlugosc']) || array_key_exists('mapaDlugosc', $this->data['fields'])) {
                    $value = $this->data['fields']['mapaDlugosc'];
                    $originalValue = $this->getOriginalFieldValue('mapaDlugosc');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['mapaDlugosc'] = (string) $this->data['fields']['mapaDlugosc'];
                        } else {
                            $query['$unset']['mapaDlugosc'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }

        return $query;
    }

    /**
     * Set data in the document.
     *
     * @param string $name  The data name.
     * @param mixed  $value The value.
     *
     * @throws \InvalidArgumentException If the data name does not exists.
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Returns data of the document.
     *
     * @param string $name The data name.
     *
     * @return mixed Some data.
     *
     * @throws \InvalidArgumentException If the data name does not exists.
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Throws an \LogicException because you cannot check if data exists.
     *
     * @throws \LogicException
     */
    public function offsetExists($name)
    {
        throw new \LogicException('You cannot check if data exists.');
    }

    /**
     * Set data in the document.
     *
     * @param string $name  The data name.
     * @param mixed  $value The value.
     *
     * @throws \InvalidArgumentException If the data name does not exists.
     */
    public function offsetSet($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Returns data of the document.
     *
     * @param string $name The data name.
     *
     * @return mixed Some data.
     *
     * @throws \InvalidArgumentException If the data name does not exists.
     */
    public function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * Throws a \LogicException because you cannot unset data through ArrayAccess.
     *
     * @throws \LogicException
     */
    public function offsetUnset($name)
    {
        throw new \LogicException('You cannot unset data.');
    }
}