<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;
use Aws\Sdk;

class AwsClient
{
    /** @var Sdk */
    protected $sdk;

    public function __construct(
        string $region,
        string $version,
        string $dynamoDbCredentialKey,
        string $dynamoDbCredentialSecretKey
    ) {
        $this->sdk = new Sdk([
            'region'   => $region,
            'version'  => $version,
            'Dynamodb' => [
                'credentials' => [
                    'key' => $dynamoDbCredentialKey,
                    'secret' => $dynamoDbCredentialSecretKey
                ]
            ]
        ]);
    }

    public function dynamoDbClient(): DynamoDbClient
    {
        return $this->sdk->createDynamoDb();
    }

    public function s3Client(): S3Client
    {
        return $this->sdk->createS3();
    }
}