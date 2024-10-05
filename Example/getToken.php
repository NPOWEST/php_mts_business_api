<?php

/**
 * @see https://npowest.ru
 * @license Shareware
 * @copyright (c) 2019-2024 NPOWest
 */

declare(strict_types=1);

use Npowest\MTSBusinessApi\Command\Token;

require '../vendor/autoload.php';

$consumerKey    = 'Логин, сгенерированный при получении доступа к подписке';
$consumerSecret = 'Пароль, сгенерированный при получении доступа к подписке';

$token = new Token();
$token->setConsumerKey($consumerKey)->setConsumerSecret($consumerSecret);
echo $token->getToken();
