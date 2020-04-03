<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\AwsClient;
use Aws\DynamoDb\Marshaler;

class UserRepository
{
    protected $dynamoDbClient;

    protected $tableName;

    public function __construct(AwsClient $awsClient, string $tableName)
    {
        $this->dynamoDbClient = $awsClient->dynamoDbClient();
        $this->tableName = $tableName;
    }

    public function insert(User $user): User
    {
        $item = (new Marshaler())
            ->marshalJson((string) json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'roles' => $user->getRoles()
            ]));

        $this->dynamoDbClient->putItem([
            'TableName' => $this->tableName,
            'Item' => $item,
        ]);

        return $user;
    }

    public function findOneByEmail(string $email): ?User
    {
        $key = (new Marshaler())
            ->marshalJson((string) json_encode(['email' => $email]));

        $userDocument = $this->dynamoDbClient
            ->getItem([
                'TableName' => $this->tableName,
                'Key' => $key,
            ])
            ->get('Item')
        ;

        if ($userDocument === null) {
            return null;
        }

        $userArray = (new Marshaler())->unmarshalItem($userDocument);

        return (new User())
            ->setEmail($userArray['email'])
            ->setPassword($userArray['password'])
            ->setRoles($userArray['roles'])
        ;
    }
}