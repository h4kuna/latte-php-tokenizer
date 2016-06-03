<?php

namespace h4kuna\Template;

use ArrayIterator,
	Latte;

class LattePhpTokenizer
{

	/** @var array */
	private static $args = [];

	/** @var ArrayIterator */
	private static $tokens;

	public static function toArray(Latte\MacroNode $node)
	{
		self::$args = [];
		self::$tokens = new ArrayIterator(array_slice(token_get_all('<?php ord(' . $node->args . ');'), 3, -2));
		foreach (self::$tokens as $foo) {
			$val = self::param();
			if ($val) {
				self::$args[] = $val;
			}
		}
		return self::$args;
	}

	private static function param()
	{
		$param = NULL;
		$inner = 0;
		do {
			$current = self::$tokens->current();
			if (is_array($current)) {
				if ($current[0] == T_WHITESPACE) {
					continue;
				}
				$param .= $current[1];
			} else {
				if ($current == '(') {
					++$inner;
				} elseif ($inner > 0 && $current == ')') {
					--$inner;
				} elseif ($current == ',' && !$inner) {
					break;
				}
				$param .= $current;
			}
		} while ((self::$tokens->next() || 1) && self::$tokens->valid());
		return $param;
	}

}
