<?php

/**
 * @see https://npowest.ru
 * @license Shareware
 * @copyright (c) 2019-2024 NPOWest
 */

declare(strict_types=1);

namespace Npowest\MTSBusinessApi;

use const CURLOPT_HTTPHEADER;
use const CURLOPT_POST;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_RETURNTRANSFER;

final class Send
{
	public static function post(string $url, array $data, array $options = [])
	{
		$ch = curl_init($url);

		$optionsDef = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => [
				'Content-Type: application/x-www-form-urlencoded',
				'Accept: application/json',
			],
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => http_build_query($data),
		];
		$optionsDef += $options;
		curl_setopt_array($ch, $optionsDef);

		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response);
	}//end post()

	public static function get(string $url, array $data, array $options = []): void
	{
		$ch = curl_init($url.'?'.http_build_query($data));

		$optionsDef = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => [
				'Content-Type: application/json',
				'Accept: application/json',
			],
		];
		$optionsDef += $options;
		curl_setopt_array($ch, $optionsDef);

		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);
	}//end get()
}//end class
