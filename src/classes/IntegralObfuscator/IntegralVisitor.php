<?php

namespace IntegralObfuscator;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\Node\Stmt\Class_;
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
        			$varName = "";
        			for ($i=0; $i < 7; $i++) { 
        				$varName .= str_repeat($this->m->gen(1, 3, range(chr(128), chr(255))), 8);
        			}
        			$varName .= $this->m->gen(8, 3, range(chr(128), chr(255)));
        		} while (array_search($varName, $this->varHash) !== false);
        		$this->varHash[$node->name] = $varName;
        	}
        	$node->name = $this->varHash[$node->name];
            return;
        } else if ($node instanceof Class_) {
        	return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
    }
}
