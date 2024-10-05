<?php

/**
 * @see https://npowest.ru
 * @license Shareware
 * @copyright (c) 2019-2024 NPOWest
 */

declare(strict_types=1);

namespace Npowest\MTSBusinessApi\Command;

use Exception;
use Npowest\MTSBusinessApi\Send;

use const CURLAUTH_BASIC;
use const CURLOPT_HTTPAUTH;
use const CURLOPT_USERPWD;

final class Token
{
    private readonly string $url;

    private string $token;

    private int $expires = 0;

    private string $consumerKey;

    private string $consumerSecret;

    public function __construct(string $url = 'https://api.mts.ru/token')
    {
        $this->url = $url;
    }//end __construct()

    public function getToken(): string
    {
        if ($this->expires < time())
        {
            $this->loadToken();
        }

        return $this->token;
    }//end getToken()

    private function loadToken(): void
    {
        $result = Send::post(
            $this->url,
            ['grant_type' => 'client_credentials'],
            [
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => "{$this->consumerKey}:{$this->consumerSecret}"
            ]
        );
        if ('am_application_scope default' != $result->scope || 'Bearer' != $result->token_type)
        {
            throw new Exception('Invalid token');
        }
        $this->token   = $result->access_token;
        $this->expires = time() + $result->expires_in;
    }//end loadToken()

    /**
     * Set the value of consumerKey.
     */
    public function setConsumerKey(mixed $consumerKey): self
    {
        $this->consumerKey = $consumerKey;

        return $this;
    }//end setConsumerKey()

    /**
     * Set the value of consumerSecret.
     */
    public function setConsumerSecret(mixed $consumerSecret): self
    {
        $this->consumerSecret = $consumerSecret;

        return $this;
    }//end setConsumerSecret()
}//end class
