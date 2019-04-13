<?php

namespace IntegralObfuscator;

defined("TMP_DIR") or exit("TMP_DIR is not defined!\n");

use Exception;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\EncapsedStringPart;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 * @package \IntegralObfuscator
 */
final class IntegralObfuscator
{
	/**
	 * @var string
	 */
	private $inputFile;

	/**
	 * @var string
	 */
	private $outputFile;


	/**
	 * @param string $inputFile
	 * @param string $outputFile
	 *
	 * Constructor.
	 */
	public function __construct(string $inputFile, string $outputFile)
	{
		$this->inputFile = $inputFile;
		$this->outputFile = $outputFile;
	}

	/**
	 * @return void
	 */
	public function execute(): void
	{
		
	}
}
