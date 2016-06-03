<?php

namespace h4kuna\Template;

use Latte,
	Tester,
	Tester\Assert;

$container = require_once __DIR__ . '/../bootstrap.php';

class LattePhpTokenizerTest extends Tester\TestCase
{

	public function testArgs()
	{
		$node = new Latte\MacroNode(new \Latte\Macros\MacroSet(new \Latte\Compiler()), 'foo');

		$node->args = "'Ahoj jak se (máš) \' lála\"\"', 'sdasdasad', 6, \$ahoj, \$template->helper('n', \$a1, foo('ahoj2')), strstr('a', \$a, 5), \$f(), \$template->helper('n', \$a1, foo('ahoj2'))";



		Assert::equal([
			"'Ahoj jak se (máš) \' lála\"\"'",
			"'sdasdasad'",
			"6",
			"\$ahoj",
			"\$template->helper('n',\$a1,foo('ahoj2'))",
			"strstr('a',\$a,5)",
			"\$f()",
			"\$template->helper('n',\$a1,foo('ahoj2'))",
			], LattePhpTokenizer::toArray($node));
	}

}

(new LattePhpTokenizerTest())->run();
