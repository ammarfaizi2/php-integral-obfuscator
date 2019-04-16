<?php ob_start(); ?><!DOCTYPE html>
<html>
<head>
	<title>PHP Integral Obfuscator</title>
	<style type="text/css">
		* {
			font-family:Arial;
		}
		.cg {
			border: 1px solid #000;
			width: 500px;
			height: 350px;
		}
		.cgf {
			margin-top: 40px;
		}
		input[type=file] {
			cursor: pointer;
		}
		button{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<center>
		<h1>PHP Integral Obfuscator</h1>
		<div class="cg">
			<div class="cgf">
				<h2>Upload your PHP code!</h2>
				<form method="POST" action="obfuscate.php" enctype="multipart/form-data">
					<table>
						<tbody>
							<tr><td>Upload File</td><td>:</td><td><input type="file" name="file" required/></td></tr>
							<tr><td>Key</td><td>:</td><td><input type="text" name="key" value="abc123" required/></td></tr>
							<tr><td>Shebang</td><td>:</td>
								<td>
									<select name="shebang">
										<option value="">None</option>
										<option>#!/usr/bin/php</option>
										<option>#!/usr/bin/php7.3</option>
										<option>#!/usr/bin/php7.2</option>
										<option>#!/usr/bin/php7.1</option>
										<option>#!/usr/bin/php7.0</option>
										<option>#!/usr/bin/env php</option>
										<option>#!/usr/bin/env php7.3</option>
										<option>#!/usr/bin/env php7.2</option>
										<option>#!/usr/bin/env php7.1</option>
										<option>#!/usr/bin/env php7.0</option>
									</select>
								</td>
							</tr>
							<tr><td colspan="3" align="center"><button type="submit">Submit</button></td></tr>
						</tbody>
						<tbody>
							<tr><td colspan="3"><div style="margin-top: 20px;"></div></td></tr>
							<tr><td colspan="3" align="center">Note: Key is used for encryption key.</td></tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<div style="margin-top:50px;">
			<a target="_blank" style="color:blue;" href="https://github.com/ammarfaizi2/php-integral-obfuscator">https://github.com/ammarfaizi2/php-integral-obfuscator</a>
		</div>
	</center>
</body>
</html><?php print str_replace(["\t", "\n"], "", ob_get_clean()); ?>