<?php

namespace Generic\ModelNosql;

/**
 * Repository of Generic\ModelNosql\LogZdarzen document.
 */
class LogZdarzenRepository extends \Generic\ModelNosql\Base\LogZdarzenRepository
{
	use \Generic\Biblioteka\Mandango\Repository;

	protected static $identyfikatorBazy = 'mongo';
}