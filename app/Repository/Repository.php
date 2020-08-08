<?php
namespace App\Repository;

interface Repository
{
    public function findBy(array $data);
    public function save(array $data): bool;
}
