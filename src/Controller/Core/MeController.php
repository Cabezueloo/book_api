<?php

namespace App\Controller\Core;

use App\Entity\Core\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\ORM\EntityManagerInterface;


#[AsController]
class MeController extends AbstractController
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager

    ) {}

    public function __invoke(): User
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('Full authentication required');
        }
        
        $user->setLastLogin(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        return $user;
    }
}
