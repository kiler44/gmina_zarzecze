<?php

namespace Generic\ModelNosql\Base;

/**
 * Base class of Generic\ModelNosql\LogZdarzen document.
 */
abstract class LogZdarzen extends \Mandango\Document\Document implements \ArrayAccess
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
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
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
        if (isset($data['timestamp'])) {
            $this->data['fields']['timestamp'] = new \DateTime(); $this->data['fields']['timestamp']->setTimestamp($data['timestamp']->sec);
        } elseif (isset($data['_fields']['timestamp'])) {
            $this->data['fields']['timestamp'] = null;
        }
        if (isset($data['idPracownika'])) {
            $this->data['fields']['idPracownika'] = (int) $data['idPracownika'];
        } elseif (isset($data['_fields']['idPracownika'])) {
            $this->data['fields']['idPracownika'] = null;
        }
        if (isset($data['idObiektuGlownego'])) {
            $this->data['fields']['idObiektuGlownego'] = (int) $data['idObiektuGlownego'];
        } elseif (isset($data['_fields']['idObiektuGlownego'])) {
            $this->data['fields']['idObiektuGlownego'] = null;
        }
        if (isset($data['typObiektuGlownego'])) {
            $this->data['fields']['typObiektuGlownego'] = (string) $data['typObiektuGlownego'];
        } elseif (isset($data['_fields']['typObiektuGlownego'])) {
            $this->data['fields']['typObiektuGlownego'] = null;
        }
        if (isset($data['danePomocnicze'])) {
            $this->data['fields']['danePomocnicze'] = unserialize($data['danePomocnicze']);
        } elseif (isset($data['_fields']['danePomocnicze'])) {
            $this->data['fields']['danePomocnicze'] = null;
        }
        if (isset($data['nazwa'])) {
            $this->data['fields']['nazwa'] = (string) $data['nazwa'];
        } elseif (isset($data['_fields']['nazwa'])) {
            $this->data['fields']['nazwa'] = null;
        }
        if (isset($data['tokenProcesu'])) {
            $this->data['fields']['tokenProcesu'] = (string) $data['tokenProcesu'];
        } elseif (isset($data['_fields']['tokenProcesu'])) {
            $this->data['fields']['tokenProcesu'] = null;
        }

        return $this;
    }

    /**
     * Set the "timestamp" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setTimestamp($value)
    {
        if (!isset($this->data['fields']['timestamp'])) {
            if (!$this->isNew()) {
                $this->getTimestamp();
                if ($value === $this->data['fields']['timestamp']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['timestamp'] = null;
                $this->data['fields']['timestamp'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['timestamp']) {
            return $this;
        }

        if (!isset($this->fieldsModified['timestamp']) && !array_key_exists('timestamp', $this->fieldsModified)) {
            $this->fieldsModified['timestamp'] = $this->data['fields']['timestamp'];
        } elseif ($value === $this->fieldsModified['timestamp']) {
            unset($this->fieldsModified['timestamp']);
        }

        $this->data['fields']['timestamp'] = $value;

        return $this;
    }

    /**
     * Returns the "timestamp" field.
     *
     * @return mixed The $name field.
     */
    public function getTimestamp()
    {
        if (!isset($this->data['fields']['timestamp'])) {
            if ($this->isNew()) {
                $this->data['fields']['timestamp'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('timestamp', $this->data['fields'])) {
                $this->addFieldCache('timestamp');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('timestamp' => 1));
                if (isset($data['timestamp'])) {
                    $this->data['fields']['timestamp'] = new \DateTime(); $this->data['fields']['timestamp']->setTimestamp($data['timestamp']->sec);
                } else {
                    $this->data['fields']['timestamp'] = null;
                }
            }
        }

        return $this->data['fields']['timestamp'];
    }

    /**
     * Set the "idPracownika" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setIdPracownika($value)
    {
        if (!isset($this->data['fields']['idPracownika'])) {
            if (!$this->isNew()) {
                $this->getIdPracownika();
                if ($value === $this->data['fields']['idPracownika']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['idPracownika'] = null;
                $this->data['fields']['idPracownika'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['idPracownika']) {
            return $this;
        }

        if (!isset($this->fieldsModified['idPracownika']) && !array_key_exists('idPracownika', $this->fieldsModified)) {
            $this->fieldsModified['idPracownika'] = $this->data['fields']['idPracownika'];
        } elseif ($value === $this->fieldsModified['idPracownika']) {
            unset($this->fieldsModified['idPracownika']);
        }

        $this->data['fields']['idPracownika'] = $value;

        return $this;
    }

    /**
     * Returns the "idPracownika" field.
     *
     * @return mixed The $name field.
     */
    public function getIdPracownika()
    {
        if (!isset($this->data['fields']['idPracownika'])) {
            if ($this->isNew()) {
                $this->data['fields']['idPracownika'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('idPracownika', $this->data['fields'])) {
                $this->addFieldCache('idPracownika');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('idPracownika' => 1));
                if (isset($data['idPracownika'])) {
                    $this->data['fields']['idPracownika'] = (int) $data['idPracownika'];
                } else {
                    $this->data['fields']['idPracownika'] = null;
                }
            }
        }

        return $this->data['fields']['idPracownika'];
    }

    /**
     * Set the "idObiektuGlownego" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setIdObiektuGlownego($value)
    {
        if (!isset($this->data['fields']['idObiektuGlownego'])) {
            if (!$this->isNew()) {
                $this->getIdObiektuGlownego();
                if ($value === $this->data['fields']['idObiektuGlownego']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['idObiektuGlownego'] = null;
                $this->data['fields']['idObiektuGlownego'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['idObiektuGlownego']) {
            return $this;
        }

        if (!isset($this->fieldsModified['idObiektuGlownego']) && !array_key_exists('idObiektuGlownego', $this->fieldsModified)) {
            $this->fieldsModified['idObiektuGlownego'] = $this->data['fields']['idObiektuGlownego'];
        } elseif ($value === $this->fieldsModified['idObiektuGlownego']) {
            unset($this->fieldsModified['idObiektuGlownego']);
        }

        $this->data['fields']['idObiektuGlownego'] = $value;

        return $this;
    }

    /**
     * Returns the "idObiektuGlownego" field.
     *
     * @return mixed The $name field.
     */
    public function getIdObiektuGlownego()
    {
        if (!isset($this->data['fields']['idObiektuGlownego'])) {
            if ($this->isNew()) {
                $this->data['fields']['idObiektuGlownego'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('idObiektuGlownego', $this->data['fields'])) {
                $this->addFieldCache('idObiektuGlownego');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('idObiektuGlownego' => 1));
                if (isset($data['idObiektuGlownego'])) {
                    $this->data['fields']['idObiektuGlownego'] = (int) $data['idObiektuGlownego'];
                } else {
                    $this->data['fields']['idObiektuGlownego'] = null;
                }
            }
        }

        return $this->data['fields']['idObiektuGlownego'];
    }

    /**
     * Set the "typObiektuGlownego" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setTypObiektuGlownego($value)
    {
        if (!isset($this->data['fields']['typObiektuGlownego'])) {
            if (!$this->isNew()) {
                $this->getTypObiektuGlownego();
                if ($value === $this->data['fields']['typObiektuGlownego']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['typObiektuGlownego'] = null;
                $this->data['fields']['typObiektuGlownego'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['typObiektuGlownego']) {
            return $this;
        }

        if (!isset($this->fieldsModified['typObiektuGlownego']) && !array_key_exists('typObiektuGlownego', $this->fieldsModified)) {
            $this->fieldsModified['typObiektuGlownego'] = $this->data['fields']['typObiektuGlownego'];
        } elseif ($value === $this->fieldsModified['typObiektuGlownego']) {
            unset($this->fieldsModified['typObiektuGlownego']);
        }

        $this->data['fields']['typObiektuGlownego'] = $value;

        return $this;
    }

    /**
     * Returns the "typObiektuGlownego" field.
     *
     * @return mixed The $name field.
     */
    public function getTypObiektuGlownego()
    {
        if (!isset($this->data['fields']['typObiektuGlownego'])) {
            if ($this->isNew()) {
                $this->data['fields']['typObiektuGlownego'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('typObiektuGlownego', $this->data['fields'])) {
                $this->addFieldCache('typObiektuGlownego');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('typObiektuGlownego' => 1));
                if (isset($data['typObiektuGlownego'])) {
                    $this->data['fields']['typObiektuGlownego'] = (string) $data['typObiektuGlownego'];
                } else {
                    $this->data['fields']['typObiektuGlownego'] = null;
                }
            }
        }

        return $this->data['fields']['typObiektuGlownego'];
    }

    /**
     * Set the "danePomocnicze" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setDanePomocnicze($value)
    {
        if (!isset($this->data['fields']['danePomocnicze'])) {
            if (!$this->isNew()) {
                $this->getDanePomocnicze();
                if ($value === $this->data['fields']['danePomocnicze']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['danePomocnicze'] = null;
                $this->data['fields']['danePomocnicze'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['danePomocnicze']) {
            return $this;
        }

        if (!isset($this->fieldsModified['danePomocnicze']) && !array_key_exists('danePomocnicze', $this->fieldsModified)) {
            $this->fieldsModified['danePomocnicze'] = $this->data['fields']['danePomocnicze'];
        } elseif ($value === $this->fieldsModified['danePomocnicze']) {
            unset($this->fieldsModified['danePomocnicze']);
        }

        $this->data['fields']['danePomocnicze'] = $value;

        return $this;
    }

    /**
     * Returns the "danePomocnicze" field.
     *
     * @return mixed The $name field.
     */
    public function getDanePomocnicze()
    {
        if (!isset($this->data['fields']['danePomocnicze'])) {
            if ($this->isNew()) {
                $this->data['fields']['danePomocnicze'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('danePomocnicze', $this->data['fields'])) {
                $this->addFieldCache('danePomocnicze');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('danePomocnicze' => 1));
                if (isset($data['danePomocnicze'])) {
                    $this->data['fields']['danePomocnicze'] = unserialize($data['danePomocnicze']);
                } else {
                    $this->data['fields']['danePomocnicze'] = null;
                }
            }
        }

        return $this->data['fields']['danePomocnicze'];
    }

    /**
     * Set the "nazwa" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setNazwa($value)
    {
        if (!isset($this->data['fields']['nazwa'])) {
            if (!$this->isNew()) {
                $this->getNazwa();
                if ($value === $this->data['fields']['nazwa']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['nazwa'] = null;
                $this->data['fields']['nazwa'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['nazwa']) {
            return $this;
        }

        if (!isset($this->fieldsModified['nazwa']) && !array_key_exists('nazwa', $this->fieldsModified)) {
            $this->fieldsModified['nazwa'] = $this->data['fields']['nazwa'];
        } elseif ($value === $this->fieldsModified['nazwa']) {
            unset($this->fieldsModified['nazwa']);
        }

        $this->data['fields']['nazwa'] = $value;

        return $this;
    }

    /**
     * Returns the "nazwa" field.
     *
     * @return mixed The $name field.
     */
    public function getNazwa()
    {
        if (!isset($this->data['fields']['nazwa'])) {
            if ($this->isNew()) {
                $this->data['fields']['nazwa'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('nazwa', $this->data['fields'])) {
                $this->addFieldCache('nazwa');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('nazwa' => 1));
                if (isset($data['nazwa'])) {
                    $this->data['fields']['nazwa'] = (string) $data['nazwa'];
                } else {
                    $this->data['fields']['nazwa'] = null;
                }
            }
        }

        return $this->data['fields']['nazwa'];
    }

    /**
     * Set the "tokenProcesu" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function setTokenProcesu($value)
    {
        if (!isset($this->data['fields']['tokenProcesu'])) {
            if (!$this->isNew()) {
                $this->getTokenProcesu();
                if ($value === $this->data['fields']['tokenProcesu']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['tokenProcesu'] = null;
                $this->data['fields']['tokenProcesu'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['tokenProcesu']) {
            return $this;
        }

        if (!isset($this->fieldsModified['tokenProcesu']) && !array_key_exists('tokenProcesu', $this->fieldsModified)) {
            $this->fieldsModified['tokenProcesu'] = $this->data['fields']['tokenProcesu'];
        } elseif ($value === $this->fieldsModified['tokenProcesu']) {
            unset($this->fieldsModified['tokenProcesu']);
        }

        $this->data['fields']['tokenProcesu'] = $value;

        return $this;
    }

    /**
     * Returns the "tokenProcesu" field.
     *
     * @return mixed The $name field.
     */
    public function getTokenProcesu()
    {
        if (!isset($this->data['fields']['tokenProcesu'])) {
            if ($this->isNew()) {
                $this->data['fields']['tokenProcesu'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('tokenProcesu', $this->data['fields'])) {
                $this->addFieldCache('tokenProcesu');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('tokenProcesu' => 1));
                if (isset($data['tokenProcesu'])) {
                    $this->data['fields']['tokenProcesu'] = (string) $data['tokenProcesu'];
                } else {
                    $this->data['fields']['tokenProcesu'] = null;
                }
            }
        }

        return $this->data['fields']['tokenProcesu'];
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
        if ('timestamp' == $name) {
            return $this->setTimestamp($value);
        }
        if ('idPracownika' == $name) {
            return $this->setIdPracownika($value);
        }
        if ('idObiektuGlownego' == $name) {
            return $this->setIdObiektuGlownego($value);
        }
        if ('typObiektuGlownego' == $name) {
            return $this->setTypObiektuGlownego($value);
        }
        if ('danePomocnicze' == $name) {
            return $this->setDanePomocnicze($value);
        }
        if ('nazwa' == $name) {
            return $this->setNazwa($value);
        }
        if ('tokenProcesu' == $name) {
            return $this->setTokenProcesu($value);
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
        if ('timestamp' == $name) {
            return $this->getTimestamp();
        }
        if ('idPracownika' == $name) {
            return $this->getIdPracownika();
        }
        if ('idObiektuGlownego' == $name) {
            return $this->getIdObiektuGlownego();
        }
        if ('typObiektuGlownego' == $name) {
            return $this->getTypObiektuGlownego();
        }
        if ('danePomocnicze' == $name) {
            return $this->getDanePomocnicze();
        }
        if ('nazwa' == $name) {
            return $this->getNazwa();
        }
        if ('tokenProcesu' == $name) {
            return $this->getTokenProcesu();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Generic\ModelNosql\LogZdarzen The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['timestamp'])) {
            $this->setTimestamp($array['timestamp']);
        }
        if (isset($array['idPracownika'])) {
            $this->setIdPracownika($array['idPracownika']);
        }
        if (isset($array['idObiektuGlownego'])) {
            $this->setIdObiektuGlownego($array['idObiektuGlownego']);
        }
        if (isset($array['typObiektuGlownego'])) {
            $this->setTypObiektuGlownego($array['typObiektuGlownego']);
        }
        if (isset($array['danePomocnicze'])) {
            $this->setDanePomocnicze($array['danePomocnicze']);
        }
        if (isset($array['nazwa'])) {
            $this->setNazwa($array['nazwa']);
        }
        if (isset($array['tokenProcesu'])) {
            $this->setTokenProcesu($array['tokenProcesu']);
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

        $array['timestamp'] = $this->getTimestamp();
        $array['idPracownika'] = $this->getIdPracownika();
        $array['idObiektuGlownego'] = $this->getIdObiektuGlownego();
        $array['typObiektuGlownego'] = $this->getTypObiektuGlownego();
        $array['danePomocnicze'] = $this->getDanePomocnicze();
        $array['nazwa'] = $this->getNazwa();
        $array['tokenProcesu'] = $this->getTokenProcesu();

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
                if (isset($this->data['fields']['timestamp'])) {
                    $query['timestamp'] = $this->data['fields']['timestamp']; if ($query['timestamp'] instanceof \DateTime) { $query['timestamp'] = $this->data['fields']['timestamp']->getTimestamp(); } elseif (is_string($query['timestamp'])) { $query['timestamp'] = strtotime($this->data['fields']['timestamp']); } $query['timestamp'] = new \MongoDate($query['timestamp']);
                }
                if (isset($this->data['fields']['idPracownika'])) {
                    $query['idPracownika'] = (int) $this->data['fields']['idPracownika'];
                }
                if (isset($this->data['fields']['idObiektuGlownego'])) {
                    $query['idObiektuGlownego'] = (int) $this->data['fields']['idObiektuGlownego'];
                }
                if (isset($this->data['fields']['typObiektuGlownego'])) {
                    $query['typObiektuGlownego'] = (string) $this->data['fields']['typObiektuGlownego'];
                }
                if (isset($this->data['fields']['danePomocnicze'])) {
                    $query['danePomocnicze'] = serialize($this->data['fields']['danePomocnicze']);
                }
                if (isset($this->data['fields']['nazwa'])) {
                    $query['nazwa'] = (string) $this->data['fields']['nazwa'];
                }
                if (isset($this->data['fields']['tokenProcesu'])) {
                    $query['tokenProcesu'] = (string) $this->data['fields']['tokenProcesu'];
                }
            } else {
                if (isset($this->data['fields']['timestamp']) || array_key_exists('timestamp', $this->data['fields'])) {
                    $value = $this->data['fields']['timestamp'];
                    $originalValue = $this->getOriginalFieldValue('timestamp');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['timestamp'] = $this->data['fields']['timestamp']; if ($query['$set']['timestamp'] instanceof \DateTime) { $query['$set']['timestamp'] = $this->data['fields']['timestamp']->getTimestamp(); } elseif (is_string($query['$set']['timestamp'])) { $query['$set']['timestamp'] = strtotime($this->data['fields']['timestamp']); } $query['$set']['timestamp'] = new \MongoDate($query['$set']['timestamp']);
                        } else {
                            $query['$unset']['timestamp'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['idPracownika']) || array_key_exists('idPracownika', $this->data['fields'])) {
                    $value = $this->data['fields']['idPracownika'];
                    $originalValue = $this->getOriginalFieldValue('idPracownika');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['idPracownika'] = (int) $this->data['fields']['idPracownika'];
                        } else {
                            $query['$unset']['idPracownika'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['idObiektuGlownego']) || array_key_exists('idObiektuGlownego', $this->data['fields'])) {
                    $value = $this->data['fields']['idObiektuGlownego'];
                    $originalValue = $this->getOriginalFieldValue('idObiektuGlownego');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['idObiektuGlownego'] = (int) $this->data['fields']['idObiektuGlownego'];
                        } else {
                            $query['$unset']['idObiektuGlownego'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['typObiektuGlownego']) || array_key_exists('typObiektuGlownego', $this->data['fields'])) {
                    $value = $this->data['fields']['typObiektuGlownego'];
                    $originalValue = $this->getOriginalFieldValue('typObiektuGlownego');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['typObiektuGlownego'] = (string) $this->data['fields']['typObiektuGlownego'];
                        } else {
                            $query['$unset']['typObiektuGlownego'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['danePomocnicze']) || array_key_exists('danePomocnicze', $this->data['fields'])) {
                    $value = $this->data['fields']['danePomocnicze'];
                    $originalValue = $this->getOriginalFieldValue('danePomocnicze');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['danePomocnicze'] = serialize($this->data['fields']['danePomocnicze']);
                        } else {
                            $query['$unset']['danePomocnicze'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['nazwa']) || array_key_exists('nazwa', $this->data['fields'])) {
                    $value = $this->data['fields']['nazwa'];
                    $originalValue = $this->getOriginalFieldValue('nazwa');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['nazwa'] = (string) $this->data['fields']['nazwa'];
                        } else {
                            $query['$unset']['nazwa'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['tokenProcesu']) || array_key_exists('tokenProcesu', $this->data['fields'])) {
                    $value = $this->data['fields']['tokenProcesu'];
                    $originalValue = $this->getOriginalFieldValue('tokenProcesu');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['tokenProcesu'] = (string) $this->data['fields']['tokenProcesu'];
                        } else {
                            $query['$unset']['tokenProcesu'] = 1;
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