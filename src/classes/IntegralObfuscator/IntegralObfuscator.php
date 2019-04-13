<?php

namespace IntegralObfuscator;

defined("TMP_DIR") or exit("TMP_DIR is not defined!\n");

use Exception;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\NodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

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
	 * @var string
	 */
	private $sheBang;

	/**
	 * @var string
	 */
	private $hash;

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
		$this->hash = sha1($this->inputContent);

		if (!is_string($this->inputContent)) {
			throw new Exception("An error occured when opening the input file: {$inputFile}");
		}

		$this->outHandle = fopen($outputFile, "w");
		if (!is_resource($this->outHandle)) {
			throw new Exception("Cannot open output file: {$outputFile}");
		}
	}

	/**
	 * @param string $sheBang
	 * @return void
	 */
	public function setShebang(string $sheBang): void
	{
		$this->sheBang = $sheBang;
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
		    $ast = $parser->parse($this->inputContent);
		} catch (Error $error) {
		    throw new Exception("Parse error: {$error->getMessage()}");
		}

		$traverser = new NodeTraverser;
		$traverser->addVisitor(new IntegralVisitor($this));
		$ast = $traverser->traverse($ast);
		$prettyPrinter = new PrettyPrinter\Standard;
		file_put_contents(TMP_DIR."/integralobf_{$this->hash}.tmp", $prettyPrinter->prettyPrintFile($ast));
		$ast = shell_exec(PHP_BINARY." -w ".escapeshellarg(TMP_DIR."/integralobf_{$this->hash}.tmp"));
		unlink(TMP_DIR."/integralobf_{$this->hash}.tmp");
		print $ast;
	}

	/**
	 * @param int $n
	 * @param int $type
	 * @return string
	 */
	public function gen(int $n, int $type = 0, $rw = ""): string
	{
		$r = "";
		if ($type === 0) {
			$w = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
		} else if ($type === 1) {
			$w = ["\x0", "\x1", "\x2", "\x3", "\x4", "\x5", "\x6", "\x7", "\x8", "\x9", "\xa", "\xb", "\xc", "\xd", "\xe", "\xf", "\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", "\x18", "\x19", "\x1a", "\x1b", "\x1c", "\x1d", "\x1e", "\x1f", "\x20", "\x21", "\x22", "\x23", "\x24", "\x25", "\x26", "\x27", "\x28", "\x29", "\x2a", "\x2b", "\x2c", "\x2d", "\x2e", "\x2f", "\x30", "\x31", "\x32", "\x33", "\x34", "\x35", "\x36", "\x37", "\x38", "\x39", "\x3a", "\x3b", "\x3c", "\x3d", "\x3e", "\x3f", "\x40", "\x41", "\x42", "\x43", "\x44", "\x45", "\x46", "\x47", "\x48", "\x49", "\x4a", "\x4b", "\x4c", "\x4d", "\x4e", "\x4f", "\x50", "\x51", "\x52", "\x53", "\x54", "\x55", "\x56", "\x57", "\x58", "\x59", "\x5a", "\x5b", "\x5c", "\x5d", "\x5e", "\x5f", "\x60", "\x61", "\x62", "\x63", "\x64", "\x65", "\x66", "\x67", "\x68", "\x69", "\x6a", "\x6b", "\x6c", "\x6d", "\x6e", "\x6f", "\x70", "\x71", "\x72", "\x73", "\x74", "\x75", "\x76", "\x77", "\x78", "\x79", "\x7a", "\x7b", "\x7c", "\x7d", "\x7e", "\x7f", "\x80", "\x81", "\x82", "\x83", "\x84", "\x85", "\x86", "\x87", "\x88", "\x89", "\x8a", "\x8b", "\x8c", "\x8d", "\x8e", "\x8f", "\x90", "\x91", "\x92", "\x93", "\x94", "\x95", "\x96", "\x97", "\x98", "\x99", "\x9a", "\x9b", "\x9c", "\x9d", "\x9e", "\x9f", "\xa0", "\xa1", "\xa2", "\xa3", "\xa4", "\xa5", "\xa6", "\xa7", "\xa8", "\xa9", "\xaa", "\xab", "\xac", "\xad", "\xae", "\xaf", "\xb0", "\xb1", "\xb2", "\xb3", "\xb4", "\xb5", "\xb6", "\xb7", "\xb8", "\xb9", "\xba", "\xbb", "\xbc", "\xbd", "\xbe", "\xbf", "\xc0", "\xc1", "\xc2", "\xc3", "\xc4", "\xc5", "\xc6", "\xc7", "\xc8", "\xc9", "\xca", "\xcb", "\xcc", "\xcd", "\xce", "\xcf", "\xd0", "\xd1", "\xd2", "\xd3", "\xd4", "\xd5", "\xd6", "\xd7", "\xd8", "\xd9", "\xda", "\xdb", "\xdc", "\xdd", "\xde", "\xdf", "\xe0", "\xe1", "\xe2", "\xe3", "\xe4", "\xe5", "\xe6", "\xe7", "\xe8", "\xe9", "\xea", "\xeb", "\xec", "\xed", "\xee", "\xef", "\xf0", "\xf1", "\xf2", "\xf3", "\xf4", "\xf5", "\xf6", "\xf7", "\xf8", "\xf9", "\xfa", "\xfb", "\xfc", "\xfd", "\xfe", "\xff"];
		} else if ($type === 2) {
			$w = ["\x0", "\x1", "\x2", "\x3", "\x4", "\x5", "\x6", "\x7", "\x8", "\x9", "\xa", "\xb", "\xc", "\xd", "\xe", "\xf", "\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", "\x18", "\x19", "\x1a", "\x1b", "\x1c", "\x1d", "\x1e", "\x1f", "\x20", "\x80", "\x81", "\x82", "\x83", "\x84", "\x85", "\x86", "\x87", "\x88", "\x89", "\x8a", "\x8b", "\x8c", "\x8d", "\x8e", "\x8f", "\x90", "\x91", "\x92", "\x93", "\x94", "\x95", "\x96", "\x97", "\x98", "\x99", "\x9a", "\x9b", "\x9c", "\x9d", "\x9e", "\x9f", "\xa0", "\xa1", "\xa2", "\xa3", "\xa4", "\xa5", "\xa6", "\xa7", "\xa8", "\xa9", "\xaa", "\xab", "\xac", "\xad", "\xae", "\xaf", "\xb0", "\xb1", "\xb2", "\xb3", "\xb4", "\xb5", "\xb6", "\xb7", "\xb8", "\xb9", "\xba", "\xbb", "\xbc", "\xbd", "\xbe", "\xbf", "\xc0", "\xc1", "\xc2", "\xc3", "\xc4", "\xc5", "\xc6", "\xc7", "\xc8", "\xc9", "\xca", "\xcb", "\xcc", "\xcd", "\xce", "\xcf", "\xd0", "\xd1", "\xd2", "\xd3", "\xd4", "\xd5", "\xd6", "\xd7", "\xd8", "\xd9", "\xda", "\xdb", "\xdc", "\xdd", "\xde", "\xdf", "\xe0", "\xe1", "\xe2", "\xe3", "\xe4", "\xe5", "\xe6", "\xe7", "\xe8", "\xe9", "\xea", "\xeb", "\xec", "\xed", "\xee", "\xef", "\xf0", "\xf1", "\xf2", "\xf3", "\xf4", "\xf5", "\xf6", "\xf7", "\xf8", "\xf9", "\xfa", "\xfb", "\xfc", "\xfd", "\xfe", "\xff"];
		} else if ($type === 3) {
			$w = is_string($rw) ? str_split($rw) : $rw;
		} else {
			throw new Exception("Unknown type {$type}");
		}

		$c = count($w) - 1;
		for ($i=0; $i < $n; $i++) { 
			$r .= $w[rand(0, $c)];
		}

		return $r;
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
