<?php

namespace Generic\ModelNosql;

/**
 * Repository of Generic\ModelNosql\LogProcesow document.
 */
class LogProcesowRepository extends \Generic\ModelNosql\Base\LogProcesowRepository
{
	use \Generic\Biblioteka\Mandango\Repository;

	protected static $identyfikatorBazy = 'mongo';
}