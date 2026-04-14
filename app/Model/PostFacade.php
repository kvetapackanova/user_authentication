<?php

namespace App\Model;

use Nette\Database\Explorer;

final class PostFacade
{
    public function __construct(
        private Explorer $database
    ) {}

    public function findAll()
    {
        return $this->database->table('posts')
            ->order('created_at DESC');
    }

    public function findById(int $id)
    {
        return $this->database->table('posts')
            ->get($id);
    }
}