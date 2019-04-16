<?php

namespace test;

class test {

	private $meee;

	public function __construct() {
		echo "123123123123\n";
		$this->meee = "qweqweqweqwe\n";
	}

	public function execute() {
		print $this->meee;
	}
}

for ($i=0; $i < 1000; $i++) { 
	(new test)->execute();
}