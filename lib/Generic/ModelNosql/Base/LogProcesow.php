<?php

namespace Generic\ModelNosql\Base;

/**
 * Base class of Generic\ModelNosql\LogProcesow document.
 */
abstract class LogProcesow extends \Mandango\Document\Document implements \ArrayAccess
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
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
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
        if (isset($data['start'])) {
            $this->data['fields']['start'] = new \DateTime(); $this->data['fields']['start']->setTimestamp($data['start']->sec);
        } elseif (isset($data['_fields']['start'])) {
            $this->data['fields']['start'] = null;
        }
        if (isset($data['stop'])) {
            $this->data['fields']['stop'] = new \DateTime(); $this->data['fields']['stop']->setTimestamp($data['stop']->sec);
        } elseif (isset($data['_fields']['stop'])) {
            $this->data['fields']['stop'] = null;
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
        if (isset($data['nazwaProcesu'])) {
            $this->data['fields']['nazwaProcesu'] = (string) $data['nazwaProcesu'];
        } elseif (isset($data['_fields']['nazwaProcesu'])) {
            $this->data['fields']['nazwaProcesu'] = null;
        }

        return $this;
    }

    /**
     * Set the "start" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
     */
    public function setStart($value)
    {
        if (!isset($this->data['fields']['start'])) {
            if (!$this->isNew()) {
                $this->getStart();
                if ($value === $this->data['fields']['start']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['start'] = null;
                $this->data['fields']['start'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['start']) {
            return $this;
        }

        if (!isset($this->fieldsModified['start']) && !array_key_exists('start', $this->fieldsModified)) {
            $this->fieldsModified['start'] = $this->data['fields']['start'];
        } elseif ($value === $this->fieldsModified['start']) {
            unset($this->fieldsModified['start']);
        }

        $this->data['fields']['start'] = $value;

        return $this;
    }

    /**
     * Returns the "start" field.
     *
     * @return mixed The $name field.
     */
    public function getStart()
    {
        if (!isset($this->data['fields']['start'])) {
            if ($this->isNew()) {
                $this->data['fields']['start'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('start', $this->data['fields'])) {
                $this->addFieldCache('start');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('start' => 1));
                if (isset($data['start'])) {
                    $this->data['fields']['start'] = new \DateTime(); $this->data['fields']['start']->setTimestamp($data['start']->sec);
                } else {
                    $this->data['fields']['start'] = null;
                }
            }
        }

        return $this->data['fields']['start'];
    }

    /**
     * Set the "stop" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
     */
    public function setStop($value)
    {
        if (!isset($this->data['fields']['stop'])) {
            if (!$this->isNew()) {
                $this->getStop();
                if ($value === $this->data['fields']['stop']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['stop'] = null;
                $this->data['fields']['stop'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['stop']) {
            return $this;
        }

        if (!isset($this->fieldsModified['stop']) && !array_key_exists('stop', $this->fieldsModified)) {
            $this->fieldsModified['stop'] = $this->data['fields']['stop'];
        } elseif ($value === $this->fieldsModified['stop']) {
            unset($this->fieldsModified['stop']);
        }

        $this->data['fields']['stop'] = $value;

        return $this;
    }

    /**
     * Returns the "stop" field.
     *
     * @return mixed The $name field.
     */
    public function getStop()
    {
        if (!isset($this->data['fields']['stop'])) {
            if ($this->isNew()) {
                $this->data['fields']['stop'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('stop', $this->data['fields'])) {
                $this->addFieldCache('stop');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('stop' => 1));
                if (isset($data['stop'])) {
                    $this->data['fields']['stop'] = new \DateTime(); $this->data['fields']['stop']->setTimestamp($data['stop']->sec);
                } else {
                    $this->data['fields']['stop'] = null;
                }
            }
        }

        return $this->data['fields']['stop'];
    }

    /**
     * Set the "idPracownika" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
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
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
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
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
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
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
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
     * Set the "nazwaProcesu" field.
     *
     * @param mixed $value The value.
     *
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
     */
    public function setNazwaProcesu($value)
    {
        if (!isset($this->data['fields']['nazwaProcesu'])) {
            if (!$this->isNew()) {
                $this->getNazwaProcesu();
                if ($value === $this->data['fields']['nazwaProcesu']) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['nazwaProcesu'] = null;
                $this->data['fields']['nazwaProcesu'] = $value;
                return $this;
            }
        } elseif ($value === $this->data['fields']['nazwaProcesu']) {
            return $this;
        }

        if (!isset($this->fieldsModified['nazwaProcesu']) && !array_key_exists('nazwaProcesu', $this->fieldsModified)) {
            $this->fieldsModified['nazwaProcesu'] = $this->data['fields']['nazwaProcesu'];
        } elseif ($value === $this->fieldsModified['nazwaProcesu']) {
            unset($this->fieldsModified['nazwaProcesu']);
        }

        $this->data['fields']['nazwaProcesu'] = $value;

        return $this;
    }

    /**
     * Returns the "nazwaProcesu" field.
     *
     * @return mixed The $name field.
     */
    public function getNazwaProcesu()
    {
        if (!isset($this->data['fields']['nazwaProcesu'])) {
            if ($this->isNew()) {
                $this->data['fields']['nazwaProcesu'] = null;
            } elseif (!isset($this->data['fields']) || !array_key_exists('nazwaProcesu', $this->data['fields'])) {
                $this->addFieldCache('nazwaProcesu');
                $data = $this->getRepository()->getCollection()->findOne(array('_id' => $this->getId()), array('nazwaProcesu' => 1));
                if (isset($data['nazwaProcesu'])) {
                    $this->data['fields']['nazwaProcesu'] = (string) $data['nazwaProcesu'];
                } else {
                    $this->data['fields']['nazwaProcesu'] = null;
                }
            }
        }

        return $this->data['fields']['nazwaProcesu'];
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
        if ('start' == $name) {
            return $this->setStart($value);
        }
        if ('stop' == $name) {
            return $this->setStop($value);
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
        if ('nazwaProcesu' == $name) {
            return $this->setNazwaProcesu($value);
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
        if ('start' == $name) {
            return $this->getStart();
        }
        if ('stop' == $name) {
            return $this->getStop();
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
        if ('nazwaProcesu' == $name) {
            return $this->getNazwaProcesu();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Generic\ModelNosql\LogProcesow The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['start'])) {
            $this->setStart($array['start']);
        }
        if (isset($array['stop'])) {
            $this->setStop($array['stop']);
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
        if (isset($array['nazwaProcesu'])) {
            $this->setNazwaProcesu($array['nazwaProcesu']);
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

        $array['start'] = $this->getStart();
        $array['stop'] = $this->getStop();
        $array['idPracownika'] = $this->getIdPracownika();
        $array['idObiektuGlownego'] = $this->getIdObiektuGlownego();
        $array['typObiektuGlownego'] = $this->getTypObiektuGlownego();
        $array['danePomocnicze'] = $this->getDanePomocnicze();
        $array['nazwaProcesu'] = $this->getNazwaProcesu();

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
                if (isset($this->data['fields']['start'])) {
                    $query['start'] = $this->data['fields']['start']; if ($query['start'] instanceof \DateTime) { $query['start'] = $this->data['fields']['start']->getTimestamp(); } elseif (is_string($query['start'])) { $query['start'] = strtotime($this->data['fields']['start']); } $query['start'] = new \MongoDate($query['start']);
                }
                if (isset($this->data['fields']['stop'])) {
                    $query['stop'] = $this->data['fields']['stop']; if ($query['stop'] instanceof \DateTime) { $query['stop'] = $this->data['fields']['stop']->getTimestamp(); } elseif (is_string($query['stop'])) { $query['stop'] = strtotime($this->data['fields']['stop']); } $query['stop'] = new \MongoDate($query['stop']);
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
                if (isset($this->data['fields']['nazwaProcesu'])) {
                    $query['nazwaProcesu'] = (string) $this->data['fields']['nazwaProcesu'];
                }
            } else {
                if (isset($this->data['fields']['start']) || array_key_exists('start', $this->data['fields'])) {
                    $value = $this->data['fields']['start'];
                    $originalValue = $this->getOriginalFieldValue('start');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['start'] = $this->data['fields']['start']; if ($query['$set']['start'] instanceof \DateTime) { $query['$set']['start'] = $this->data['fields']['start']->getTimestamp(); } elseif (is_string($query['$set']['start'])) { $query['$set']['start'] = strtotime($this->data['fields']['start']); } $query['$set']['start'] = new \MongoDate($query['$set']['start']);
                        } else {
                            $query['$unset']['start'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['stop']) || array_key_exists('stop', $this->data['fields'])) {
                    $value = $this->data['fields']['stop'];
                    $originalValue = $this->getOriginalFieldValue('stop');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['stop'] = $this->data['fields']['stop']; if ($query['$set']['stop'] instanceof \DateTime) { $query['$set']['stop'] = $this->data['fields']['stop']->getTimestamp(); } elseif (is_string($query['$set']['stop'])) { $query['$set']['stop'] = strtotime($this->data['fields']['stop']); } $query['$set']['stop'] = new \MongoDate($query['$set']['stop']);
                        } else {
                            $query['$unset']['stop'] = 1;
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
                if (isset($this->data['fields']['nazwaProcesu']) || array_key_exists('nazwaProcesu', $this->data['fields'])) {
                    $value = $this->data['fields']['nazwaProcesu'];
                    $originalValue = $this->getOriginalFieldValue('nazwaProcesu');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['nazwaProcesu'] = (string) $this->data['fields']['nazwaProcesu'];
                        } else {
                            $query['$unset']['nazwaProcesu'] = 1;
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