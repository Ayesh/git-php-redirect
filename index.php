<?php
declare(strict_types = 1);

require __DIR__ . '/src/Redirector.php';
$uri = $_SERVER['REQUEST_URI'] ?? $argv[1] ?? null;
assert($uri !== null);
$redirector = new Redirector($uri);
$url = $redirector->getTargetUrl();

//echo $url;
http_response_code(301);
header('Location: ' . $url);
// setting content-type text/plain ensures there's no possibility of xss/javascript injection.. probably not needed with the Location header above though.
header("Content-Type: text/plain; charset=UTF-8");
echo "you are being redirected to: {$url}";
die();
