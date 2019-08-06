<?php

namespace IntegralObfuscator;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\NodeTraverser;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Const_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\ClassConst;

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
        if (
        	($node instanceof Variable) &&
        	($node->name !== "_POST") &&
        	($node->name !== "_GET") &&
        	($node->name !== "_SERVER")
        ) {
        	if (!isset($this->varHash[$node->name])) {
        		do {
        			$varName = IntegralObfuscator::rstr(true, 8, IntegralObfuscator::UNPRINT_ELI_CHARS);
        		} while (array_search($varName, $this->varHash) !== false);
        		$this->varHash[$node->name] = $varName;
        	}
        	$node->name = $this->varHash[$node->name];
            return;
        } else if (($node instanceof String_) && (!isset($node->skipMe))) {
            $str = $node->value;
            $name = new Name($this->m->stringDecryptor);
            $node = new FuncCall($name);
            $str = new String_(($this->m->stringEncryptor)($str));
            $node->args = [new Arg($str)];
            $str->skipMe = true;
            unset($str, $name);
            return $node;
        } else if ($node instanceof Param) {
            if (!isset($this->varHash[$node->var->name])) {
                do {
                    $varName = IntegralObfuscator::rstr(true, 8, IntegralObfuscator::UNPRINT_ELI_CHARS);
                } while (array_search($varName, $this->varHash) !== false);
                $this->varHash[$node->var->name] = $varName;
            }
            $node->var->name = $this->varHash[$node->var->name];
            return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        } else if (
            ($node instanceof Property) ||
            ($node instanceof ClassConst) ||
            ($node instanceof Const_)
        ) {
        	return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
    }

    public function leaveNode(Node $node)
    {
    }
}
