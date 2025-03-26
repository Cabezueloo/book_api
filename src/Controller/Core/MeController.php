<?php

namespace App\Controller\Core;

use App\Entity\Core\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class MeController extends AbstractController
{
    public function __construct(private Security $security)
    {}

    public function __invoke(): User
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new UnauthorizedHttpException('Full authentication required');
        }

        return $user;
    }
}
