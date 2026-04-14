<?php

declare(strict_types=1);

namespace App\Presentation\Dashboard;

use App\Model\PostFacade;
use App\Presentation\Accessory\RequireLoggedUser;
use Nette;

final class DashboardPresenter extends Nette\Application\UI\Presenter
{
	use RequireLoggedUser;

	public function __construct(
		private PostFacade $postFacade
	) {}

	public function renderDefault(): void
	{
		$this->template->posts = $this->postFacade->findAll();
	}
}