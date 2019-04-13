<?php

namespace IntegralObfuscator;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeVisitorAbstract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 * @package \IntegralObfuscator
 */
class IntegralVisitor extends NodeVisitorAbstract
{
	/**
	 * @var \IntegralObfuscator\IntegralObfuscator
	 */
	private $m;

	/**
	 * @var array
	 */
	private $varHash = [];

	/**
	 * @param \IntegralObfuscator\IntegralObfuscator
	 */
	public function __construct(IntegralObfuscator $m)
	{
		$this->m = $m;
	}

	/**
	 * @param \PhpParser\Node
	 */
	public function enterNode(Node $node) {
        if ($node instanceof Variable) {
        	if (!isset($this->varHash[$node->name])) {
        		do {
        			$varName = $this->m->gen(64, 3, range(chr(128), chr(255)));
        		} while (array_search($varName, $this->varHash) !== false);
        		$this->varHash[$node->name] = $varName;
        	}
        	$node->name = $this->varHash[$node->name];
            return;
        }
    }
}
