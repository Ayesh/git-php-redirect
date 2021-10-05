<?php
declare(strict_types = 1);

require __DIR__ . '/src/Redirector.php';
$redirector = new Redirector($_SERVER['REQUEST_URI']);
$url = $redirector->getTargetUrl();

//echo $url;
http_response_code(301);
header('Location: ' . $url);
die();
