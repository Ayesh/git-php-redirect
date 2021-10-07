<?php

/**
 * @throws Exception
 */
function test(string $uri, string $expected): void {
	$redirector = new Redirector($uri);
	$redirect = $redirector->getTargetUrl();
	if ($redirect !== $expected) {
		throw new Exception(sprintf("Expected and actual values mismatch. URL, Expected, Returned:\r\n%s\r\n%s\r\n%s", $uri, $expected, $redirect));
	}
}

require __DIR__ . '/../src/Redirector.php';
$tests = include __DIR__ .'/tests.php';

$fails = 0;
foreach ($tests as $from => $to) {
	try {
		test($from, $to);
	}
	catch (Exception $exception) {
		echo "\e[31mFailed: \e[0m". $exception->getMessage() . PHP_EOL . PHP_EOL;
		++$fails;
	}
}

if ($fails !== 0) {
	die(1);
}

echo "All tests passed successfully";
die(0);
