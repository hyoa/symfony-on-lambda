<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\SessionHandler;

class DynamoDbSessionHandlerFactory
{
    public static function build(DynamoDbClient $dbClient, string $resourceSPrefix): SessionHandler
    {
        return SessionHandler::fromClient($dbClient, ['table_name' => $resourceSPrefix.'-sessionsTable']);
    }
}