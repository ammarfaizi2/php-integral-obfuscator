<?php

if (
	isset(
		$_FILES["file"]["tmp_name"],
		$_POST["key"],
		$_POST["shebang"]
	) &&
	is_string($_FILES["file"]["tmp_name"]) &&
	is_string($_POST["key"]) &&
	is_string($_POST["shebang"])
) {
	header("Content-Type: text/plain");

	if (!file_exists($_FILES["file"]["tmp_name"])) {
		printf("Upload file error!\n");
		exit;
	}

	if (substr($_POST["shebang"], 0, 2) === "#!") {
		$_POST["shebang"] = substr($_POST["shebang"], 2);
	}

	if ($_POST["key"] === "") {
		printf("Key is empty, fallback to default: abc123\n");
		$_POST["key"];
	}

	$hash = sha1_file($_FILES["file"]["tmp_name"]);
	$inputFile = escapeshellarg(realpath(__DIR__."/../storage/raw/")."/{$hash}.tmp");
	$commands = [
		"mv -vf ".escapeshellarg($_FILES["file"]["tmp_name"])." {$inputFile}",
"/usr/bin/php ../integralobf \\
	-o ".escapeshellarg($outputFile = realpath(__DIR__."/../storage/obfuscated")."/{$hash}.phx")." \\
	-k ".escapeshellarg($_POST["key"])." \\\n	".($_POST["shebang"]!==""?"-s ".escapeshellarg($_POST["shebang"])." \\":"")."
	{$inputFile}"
	];
	foreach ($commands as $k => $cmd) {
		printf("- %s\n", $cmd);
		flush();
		print shell_exec($cmd." 2>&1")."\n";
		flush();
	}

	if (file_exists($outputFile)) {
		printf("Obfuscation success!\n");
		printf("Download obfuscated file: %s\n",
			"http".(isset($_SERVER["HTTPS"])?"s":"")."://".$_SERVER["HTTP_HOST"]."/obfuscated/{$hash}.phx"
		);
	}
} else {
	header("Location: /");
}
