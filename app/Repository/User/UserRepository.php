<?php
namespace App\Repository\User;

use App\Repository\Repository;
use App\User;

class UserRepository implements Repository
{
    private User $dataInstance;
    public function __construct(User $dataInstance)
    {
        $this->dataInstance = $dataInstance;

    }

    public function findBy(array $data)
    {
        $field = $data['field'];
        $option = $data['option'] ?? '=';
        $value = $data['value'];
        $onlyFirst = $data['first'] ?? false;

        $users = $this->dataInstance->where($field, $option, $value);

        if (is_null($users)) {
            return [];
        }

        if ($onlyFirst) {
            $user = $users->first();
            return $user;
        }

        return $users;
    }

    public function save(array $data): bool
    {
        $result = $this->dataInstance->create($data);
        return !empty($result);
    }
}
