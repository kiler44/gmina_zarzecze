<?php

/*
 * This file is not part of the Symfony package.
 *
 * (c) Konrad Rudowski <poczta@konradrudowski.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation;

/**
 *
 *
 * @author Konrad Rudowski <poczta@konradrudowski.pl>
 */
class Variable
{
    /**
     * Tests if the given value matches any variables.
     *
     * @param string $value   A value
     * @param string  $variable An interval
     */
    public static function test($value, $variable)
    {
		$variable = str_replace(array('{', '}'), '', $variable);

		foreach (explode(',', $variable) as $var)
		{
			if ($value == trim($var))
			{
				return true;
			}
		}

        return false;
    }

    /**
     * Returns a Regexp that matches valid values.
     *
     * @return string A Regexp (without the delimiters)
     */
    public static function getIntervalRegexp()
    {
        return <<<EOF
        ({[a-zA-z0-9]+([,a-zA-Z0-9])*})
EOF;
    }
}
