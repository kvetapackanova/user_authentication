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
    }
}