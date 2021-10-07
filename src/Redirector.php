<?php

final class Redirector {
	private string $targetUrl;
	private const GITHUB_ORG_URL = 'https://github.com/php';
	private const GIT_REPO_MAPPING = [
		'php-src.git' => 'php-src',
	];

	public function __construct(string $originUrl) {
		$this->targetUrl = $this->getGitHubUrl($originUrl);
	}

	public function getTargetUrl(): string {
		return $this->targetUrl;
	}

	private function getGitHubUrl(string $originUrl): string {
		$params = $this->getUrlParams($originUrl);

		// No URL params, or no repo set: redirect to org.
		if ($params === [] || !isset($params['p'])) {
			return self::GITHUB_ORG_URL;
		}

		// Unknown repo, redirect to org.
		if (!isset(self::GIT_REPO_MAPPING[$params['p']])) {
			return self::GITHUB_ORG_URL;
		}

		$url = self::GITHUB_ORG_URL . '/' . self::GIT_REPO_MAPPING[$params['p']];

		// FROM: http://git.php.net/?p=php-src.git;a=commit;h=5af586be
		// TO:   https://github.com/php/php-src/commit/5af586be
		if (isset($params['h']) && preg_match('/[a-f0-9]{7,}$/i', $params['h'])) {
			return $url . '/commit/' . $params['h'];
		}

		// FROM: https://git.php.net/?p=php-src.git;a=shortlog;h=refs/tags/php-8.0.0RC2
		// TO:   https://github.com/php/php-src/releases/tag/php-8.1.0RC3
		if (isset($params['h']) && preg_match('|refs/tags/(?<tag>[a-z0-9.-]+)|i', $params['h'], $matches)) {
			return $url . '/releases/tag/' . $matches['tag'];
		}

		// FROM: https://git.php.net/?p=php-src.git;a={tree,log,shortlog};h=refs/heads/master;hb=refs/heads/master
		// TO:   https://github.com/php/php-src/{tree,commits,commits}/php-8.1.0RC3
		if (isset($params['h'], $params['a']) && preg_match('|refs/heads/(?<branch>[a-z0-9.-]+)|i', $params['h'], $matches)) {
			return match ($params['a']) {
				'shortlog', 'log' => $url . '/commits/' . $matches['branch'],
				'tree'            => $url . '/tree/' . $matches['branch'],
				default           => $url,
			};
		}

		// FROM: http://git.php.net/?p=php-src.git;a=log
		// TO:   https://github.com/php/php-src
		if (!isset($params['h']) && isset($params['a'])) {
			return match ($params['a']) {
				'shortlog', 'log' => $url . '/commits',
				default           => $url,
			};
		}

		return $url;
	}

	private function getUrlParams(string $url): array {
		$params = parse_url($url, PHP_URL_QUERY);
		if ($params === null) {
			return [];
		}

		$return = [];
		$params = explode(';', $params);
		foreach ($params as $param) {
			$split_params = explode('=', $param, 2);
			if (isset($split_params[1])) {
				$return[$split_params[0]] = $split_params[1];
				continue;
			}

			$return[] = $split_params;
		}

		return $return;
	}
}
