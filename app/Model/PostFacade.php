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
    public function updateRating(int $userId, int $postId, int $liked): void
{
    $row = $this->database->table('rating')
        ->where('user_id', $userId)
        ->where('post_id', $postId)
        ->fetch();

    if ($row) {
        // už existuje → update
        $this->database->table('rating')
            ->where('user_id', $userId)
            ->where('post_id', $postId)
            ->update([
                'liked' => $liked,
            ]);
    } else {
        // neexistuje → insert
        $this->database->table('rating')
            ->insert([
                'user_id' => $userId,
                'post_id' => $postId,
                'liked' => $liked,
            ]);
    }
}
public function getRatingCount(int $postId): array
{
    $likes = $this->database->table('rating')
        ->where('post_id', $postId)
        ->where('liked', 1)
        ->count('*');

    $dislikes = $this->database->table('rating')
        ->where('post_id', $postId)
        ->where('liked', 0)
        ->count('*');

    return [
        'likes' => $likes,
        'dislikes' => $dislikes,
    ];
}
public function removeRating(int $userId, int $postId): void
{
    $this->database->table('rating')
        ->where('user_id', $userId)
        ->where('post_id', $postId)
        ->delete();
}
}