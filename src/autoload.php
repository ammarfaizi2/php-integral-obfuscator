<?php


if (!defined("__INIT")):
define("__INIT", true);

/**
 * @param string $class
 * @return void
 */
function internalAutoloader(string $class): void
{
	if (file_exists($f = __DIR__."/classes/".str_replace("\\", "/", $class).".php")) {
		require $f;
	} else {
		if (file_exists(__DIR__."/../vendor/autoload.php")) {
			require __DIR__."/../vendor/autoload.php";
		}
	}
}

spl_autoload_register("internalAutoloader");

endif;
