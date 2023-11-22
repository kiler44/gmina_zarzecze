<?php

namespace Generic\ModelNosql\Mapping;

class MetadataFactory extends \Mandango\MetadataFactory
{
    protected $classes = array(
        'Generic\\ModelNosql\\LogZdarzen' => false,
        'Generic\\ModelNosql\\LogProcesow' => false,
        'Generic\\ModelNosql\\UzytkownikWersja' => false,
    );
}