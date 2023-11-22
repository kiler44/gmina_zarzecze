<?php

namespace Generic\ModelNosql;

/**
 * Repository of Generic\ModelNosql\UzytkownikWersja document.
 */
class UzytkownikWersjaRepository extends \Generic\ModelNosql\Base\UzytkownikWersjaRepository
{
	use \Generic\Biblioteka\Mandango\Repository;

	protected static $identyfikatorBazy = 'mongo';
}