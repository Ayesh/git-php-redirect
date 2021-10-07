<?php

declare(strict_types = 1);

$tests = array(
	'http://git.php.net/?p=php-src.git;a=commit;h=3c939e3f69955d087e0bb671868f7267dfb2a502' => 'https://github.com/php/php-src/commit/3c939e3f69955d087e0bb671868f7267dfb2a502',
	'http://git.php.net/?p=php-src.git;a=commit;h=3c939e3' => 'https://github.com/php/php-src/commit/3c939e3',
	'http://git.php.net/?p=php-src.git;a=commit;h=5af586be' => 'https://github.com/php/php-src/commit/5af586be',
	'https://git.php.net/?p=php-src.git;a=shortlog;h=refs/tags/php-8.0.0RC2' => 'https://github.com/php/php-src/releases/tag/php-8.0.0RC2',
	// - FROM: https://git.php.net/?p=php-src.git;a={tree,log,shortlog};h=refs/heads/master;hb=refs/heads/master
	// TO: https://github.com/php/php-src/{tree,commits,commits}/master
	'https://git.php.net/?p=php-src.git;a=tree;h=refs/heads/master;hb=refs/heads/master' => 'https://github.com/php/php-src/tree/master',
	'https://git.php.net/?p=php-src.git;a=log;h=refs/heads/master;hb=refs/heads/master' => 'https://github.com/php/php-src/commits/master',
	'https://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/master;hb=refs/heads/master' => 'https://github.com/php/php-src/commits/master',
	//
	'http://git.php.net/?p=php-src.git;a=log' => 'https://github.com/php/php-src/',
	'http://git.php.net/?p=php-src.git;a=commitdiff;h=c730aa26bd52829a49f2ad284b181b7e82a68d7d' => 'https://github.com/php/php-src/commit/c730aa26bd52829a49f2ad284b181b7e82a68d7d',
);

return $tests;
