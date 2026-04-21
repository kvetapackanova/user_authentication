<?php

namespace App\Presentation\Post;

use Nette\Application\UI\Presenter;
use App\Model\PostFacade;
use App\Security\RequireLoggedUser;

final class PostPresenter extends Presenter
{
    public function actionShow(int $id): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }
    public function __construct(
        private PostFacade $postFacade
    ) {}

    public function renderShow(int $id): void
    {
        $post = $this->postFacade->findById($id);

        if (!$post) {
            $this->error('Příspěvek nenalezen');
        }

        $this->template->post = $post;
            $this->template->rating = $this->postFacade->getRatingCount($id);
    }
    public function handleLiked(int $postId, int $liked): void
{
    // musí být přihlášen
    if (!$this->getUser()->isLoggedIn()) {
        $this->flashMessage('Musíte být přihlášen.');
        $this->redirect('Sign:in');
    }

    $userId = $this->getUser()->getId();

    $this->postFacade->updateRating($userId, $postId, $liked);
    // refresh stránky
    $this->redirect('this');
}
public function handleUnlike(int $postId): void
{
    if (!$this->getUser()->isLoggedIn()) {
        $this->flashMessage('Musíte být přihlášen.');
        $this->redirect('Sign:in');
    }

    $userId = $this->getUser()->getId();

    $this->postFacade->removeRating($userId, $postId);

    $this->redirect('this');
}
}