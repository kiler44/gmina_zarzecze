<?php

namespace Generic\ModelNosql\Mapping;

class MetadataFactoryInfo
{
    public function getGenericModelNosqlLogZdarzenClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'modelnosql_logzdarzen',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'timestamp' => array(
                    'type' => 'date',
                    'dbName' => 'timestamp',
                ),
                'idPracownika' => array(
                    'type' => 'integer',
                    'dbName' => 'idPracownika',
                ),
                'idObiektuGlownego' => array(
                    'type' => 'integer',
                    'dbName' => 'idObiektuGlownego',
                ),
                'typObiektuGlownego' => array(
                    'type' => 'string',
                    'dbName' => 'typObiektuGlownego',
                ),
                'danePomocnicze' => array(
                    'type' => 'serialized',
                    'dbName' => 'danePomocnicze',
                ),
                'nazwa' => array(
                    'type' => 'string',
                    'dbName' => 'nazwa',
                ),
                'tokenProcesu' => array(
                    'type' => 'string',
                    'dbName' => 'tokenProcesu',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getGenericModelNosqlLogProcesowClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'modelnosql_logprocesow',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'start' => array(
                    'type' => 'date',
                    'dbName' => 'start',
                ),
                'stop' => array(
                    'type' => 'date',
                    'dbName' => 'stop',
                ),
                'idPracownika' => array(
                    'type' => 'integer',
                    'dbName' => 'idPracownika',
                ),
                'idObiektuGlownego' => array(
                    'type' => 'integer',
                    'dbName' => 'idObiektuGlownego',
                ),
                'typObiektuGlownego' => array(
                    'type' => 'string',
                    'dbName' => 'typObiektuGlownego',
                ),
                'danePomocnicze' => array(
                    'type' => 'serialized',
                    'dbName' => 'danePomocnicze',
                ),
                'nazwaProcesu' => array(
                    'type' => 'string',
                    'dbName' => 'nazwaProcesu',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }

    public function getGenericModelNosqlUzytkownikWersjaClass()
    {
        return array(
            'isEmbedded' => false,
            'mandango' => null,
            'connection' => '',
            'collection' => 'modelnosql_uzytkownikwersja',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'dataWersji' => array(
                    'type' => 'date',
                    'dbName' => 'dataWersji',
                ),
                'idTworzacegoWersje' => array(
                    'type' => 'integer',
                    'dbName' => 'idTworzacegoWersje',
                ),
                'idObiektu' => array(
                    'type' => 'integer',
                    'dbName' => 'idObiektu',
                ),
                'idProjektu' => array(
                    'type' => 'integer',
                    'dbName' => 'idProjektu',
                ),
                'login' => array(
                    'type' => 'string',
                    'dbName' => 'login',
                ),
                'haslo' => array(
                    'type' => 'string',
                    'dbName' => 'haslo',
                ),
                'email' => array(
                    'type' => 'string',
                    'dbName' => 'email',
                ),
                'dataDodania' => array(
                    'type' => 'date',
                    'dbName' => 'dataDodania',
                ),
                'dataAktywacji' => array(
                    'type' => 'date',
                    'dbName' => 'dataAktywacji',
                ),
                'token' => array(
                    'type' => 'string',
                    'dbName' => 'token',
                ),
                'czyAdmin' => array(
                    'type' => 'boolean',
                    'dbName' => 'czyAdmin',
                ),
                'status' => array(
                    'type' => 'string',
                    'dbName' => 'status',
                ),
                'imie' => array(
                    'type' => 'string',
                    'dbName' => 'imie',
                ),
                'nazwisko' => array(
                    'type' => 'string',
                    'dbName' => 'nazwisko',
                ),
                'dataUrodzenia' => array(
                    'type' => 'date',
                    'dbName' => 'dataUrodzenia',
                ),
                'plec' => array(
                    'type' => 'string',
                    'dbName' => 'plec',
                ),
                'kontaktTelefon' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktTelefon',
                ),
                'kontaktKomorka' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktKomorka',
                ),
                'kontaktFax' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktFax',
                ),
                'kontaktWWW' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktWWW',
                ),
                'kontaktNazwa' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktNazwa',
                ),
                'kontaktAdres' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktAdres',
                ),
                'kontaktKodPocztowy' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktKodPocztowy',
                ),
                'kontaktMiasto' => array(
                    'type' => 'string',
                    'dbName' => 'kontaktMiasto',
                ),
                'firmaNazwa' => array(
                    'type' => 'string',
                    'dbName' => 'firmaNazwa',
                ),
                'firmaNip' => array(
                    'type' => 'string',
                    'dbName' => 'firmaNip',
                ),
                'firmaAdres' => array(
                    'type' => 'string',
                    'dbName' => 'firmaAdres',
                ),
                'firmaKodPocztowy' => array(
                    'type' => 'string',
                    'dbName' => 'firmaKodPocztowy',
                ),
                'firmaMiasto' => array(
                    'type' => 'string',
                    'dbName' => 'firmaMiasto',
                ),
                'pocztaHost' => array(
                    'type' => 'string',
                    'dbName' => 'pocztaHost',
                ),
                'pocztaPort' => array(
                    'type' => 'integer',
                    'dbName' => 'pocztaPort',
                ),
                'pocztaLogin' => array(
                    'type' => 'string',
                    'dbName' => 'pocztaLogin',
                ),
                'pocztaHaslo' => array(
                    'type' => 'string',
                    'dbName' => 'pocztaHaslo',
                ),
                'jezyk' => array(
                    'type' => 'string',
                    'dbName' => 'jezyk',
                ),
                'zgodaMailing' => array(
                    'type' => 'integer',
                    'dbName' => 'zgodaMailing',
                ),
                'zgodaMarketing' => array(
                    'type' => 'integer',
                    'dbName' => 'zgodaMarketing',
                ),
                'typAktywacji' => array(
                    'type' => 'string',
                    'dbName' => 'typAktywacji',
                ),
                'numerKontaBankowego' => array(
                    'type' => 'string',
                    'dbName' => 'numerKontaBankowego',
                ),
                'numerUmowy' => array(
                    'type' => 'string',
                    'dbName' => 'numerUmowy',
                ),
                'mapaSzerokosc' => array(
                    'type' => 'string',
                    'dbName' => 'mapaSzerokosc',
                ),
                'mapaDlugosc' => array(
                    'type' => 'string',
                    'dbName' => 'mapaDlugosc',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
        );
    }
}