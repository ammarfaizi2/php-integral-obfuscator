<?php

namespace IntegralObfuscator;

use Exception;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

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
	 * @var resource
	 */
	private $outHandle;

	/**
	 * @var string
	 */
	private $inputContent;

	/**
	 * @param string $inputFile
	 * @param string $outputFile
	 * @throws \Exception
	 *
	 * Constructor.
	 */
	public function __construct(string $inputFile, string $outputFile)
	{
		$this->inputFile = $inputFile;
		$this->outputFile = $outputFile;

		if (!file_exists($inputFile)) {
			throw new Exception("Input file does not exist: {$inputFile}");
		}

		if (!is_readable($inputFile)) {
			throw new Exception("Input file is not readable: {$inputFile}");
		}

		$this->inputContent = file_get_contents($inputFile);

		if (!is_string($this->inputContent)) {
			throw new Exception("An error occured when opening the input file: {$inputFile}");
		}

		$this->outHandle = fopen($outputFile, "w");
		if (!is_resource($this->outHandle)) {
			throw new Exception("Cannot open output file: {$outputFile}");
		}
	}

	/**
	 * @return void
	 */
	public function execute(): void
	{
		$this->initParser();
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	private function initParser(): void
	{
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		try {
		    $ast = $parser->parse($code);
		} catch (Error $error) {
		    throw new Exception("Parse error: {$error->getMessage()}");
		}
		var_dump($ast);
	}

	/**
	 * @return void
	 */
	private function skeletonBuild(): void
	{

	}

	/**
	 * @param string $str
	 * @param string $key
	 * @return string
	 */
	private function decrypt(string $str, string $key): string
	{

	}

	/**
	 * @param string $str
	 * @param string $key
	 * @return string
	 */
	private function encrypt(string $str, string $key): string
	{

	}
}
