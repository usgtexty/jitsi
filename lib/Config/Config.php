<?php

declare(strict_types=1);

namespace OCA\jitsi\Config;

use OCA\jitsi\AppInfo\Application;
use OCP\IConfig;

class Config {
	public const KEY_JITSI_SERVER_URL = 'jitsi_server_url';
	public const KEY_JWT_SECRET = 'jwt_secret';
	public const KEY_JWT_APP_ID = 'jwt_app_id';
	public const KEY_JWT_AUDIENCE = 'jwt_audience';
	public const KEY_JWT_ISSUER = 'jwt_issuer';
	public const KEY_HELP_LINK = 'help_link';
	public const KEY_IS_JAAS = 'is_jaas';
	public const KEY_JAAS_APP_ID = 'jaas_app_id';
	public const KEY_JAAS_KEY_ID = 'jaas_key_id';
	public const KEY_JAAS_PRIVATE_KEY = 'jaas_private_key';
	public const KEY_JAAS_AUDIENCE = 'jaas_audience';
	public const KEY_JAAS_ISSUER = 'jaas_issuer';
	public const KEY_DISPLAY_JOIN_USING_THE_JITSI_APP = 'display_join_using_the_jitsi_app';

	public const BOOL_TRUE = '1';
	public const BOOL_FALSE = '0';

	/**
	 * @var IConfig
	 */
	private $config;

	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	public function jitsiServerUrl(): ?string {
		return $this->readString(self::KEY_JITSI_SERVER_URL);
	}

	public function updateJitsiServerUrl(string $serverUrl): void {
		$this->config->setAppValue(Application::APP_ID, self::KEY_JITSI_SERVER_URL, $serverUrl);
	}

	public function jwtSecret(): ?string {
		return $this->readString(self::KEY_JWT_SECRET);
	}

	public function jwtAppId(): ?string {
		return $this->readString(self::KEY_JWT_APP_ID);
	}

	public function jwtAudience(): ?string {
		$jwtAudience = $this->readString(self::KEY_JWT_AUDIENCE);
		return empty($jwtAudience) ? $this->jwtAppId() : $jwtAudience;
	}

	public function jwtIssuer(): ?string {
		$jwtIssuer = $this->readString(self::KEY_JWT_ISSUER);
		return empty($jwtIssuer) ? $this->jwtAppId() : $jwtIssuer;
	}

	public function helpLink(): ?string {
		return $this->readString(self::KEY_HELP_LINK);
	}

	public function isJaaS(): bool {
		return $this->readBool(self::KEY_IS_JAAS);
	}

	public function jaasAppId(): ?string {
		return $this->readString(self::KEY_JAAS_APP_ID);
	}

	public function jaasKeyId(): ?string {
		return $this->readString(self::KEY_JAAS_KEY_ID);
	}

	public function jaasPrivateKey(): ?string {
		return $this->readString(self::KEY_JAAS_PRIVATE_KEY);
	}

	public function jaasAudience(): ?string {
		$jaasAudience = $this->readString(self::KEY_JAAS_AUDIENCE);
		return empty($jaasAudience) ? 'jitsi' : $jaasAudience;
	}

	public function jaasIssuer(): ?string {
		$jaasIssuer = $this->readString(self::KEY_JAAS_ISSUER);
		return empty($jaasIssuer) ? 'chat' : $jaasIssuer;
	}

	public function displayJoinUsingTheJitsiApp(): bool {
		// @phpstan-ignore-next-line
		return $this->readBool(self::KEY_DISPLAY_JOIN_USING_THE_JITSI_APP, true);
	}

	private function readBool(string $key, ?bool $default = null): ?bool {
		$value = $this->config->getAppValue(
			Application::APP_ID,
			$key,
			''
		);

		return $value === '' ? $default : $value === self::BOOL_TRUE;
	}

	private function readString(string $key): ?string {
		$value = $this->config->getAppValue(
			Application::APP_ID,
			$key,
			''
		);

		return $value === '' ? null : $value;
	}
}
