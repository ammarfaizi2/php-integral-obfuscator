
# PHP Integral Obfuscator
PHP Integral Obfuscator is a tool to obfuscates PHP code. It compiles a PHP code to a binary file.

### Advantage(s) of Using Obfuscator
1. Make your PHP code not human readable. It is good for protecting your private code against people and script kiddies.

### Disadvantages of Using Obfuscator
1. Obfuscator may slow down your application in the start process (it does not affect your application runtime performance). But, if you are using it on a web-based application, the start process is done for every request. So, code obfuscation is only good for a CLI based application, not a web-based application.
2. The obfuscated file size is larger than the non-obfuscated file.
3. An obfuscated application may not be started properly due to inaccurate analyses, bugs in internal obfuscator, or any other possibilities.

# History
I created a PHP obfuscator that called IceTea Obfuscator (https://github.com/ammarfaizi2/icetea_obfuscator). But, it was not a good obfuscator, since the obfuscated code was really easy to be reversed. So here, I create a better obfuscator and named it PHP Integral Obfuscator.

# License
This software is licensed under MIT License.

# Usage
```
Usage: ./integralobf [option] <file>

	-k <key>		Give a key to encrypt the input file (default: abc123).
	--key <key>		Give a key to encrypt the input file (default: abc123).
	-o <file>		Save obfuscated PHP code to <file> (default: a.out).
	--output <file>		Save obfuscated PHP code to <file> (default: a.out).
	-s <shebang>		Add a shebang into obfuscated PHP file (default: (no shebang)).
	--shebang <shebang>	Add a shebang into obfuscated PHP file (default: (no shebang)).
	-h			Show this message.
	--help			Show this message.


Example usage:
	./integralobf --output output.php --key mypassword123 --shebang '/usr/bin/env php' input.php
```

# Contribution
I would be happy to receive issues and pull requests. Please provide the problem in details if you have an issue to be submitted.
