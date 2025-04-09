<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Core\User;
use App\Repository\FavoriteBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FavoriteBookRepository::class)]
#[ApiResource]
#[ORM\Table(name: 'table_favorite_book', schema: 'schema_books')]
class FavoriteBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteBooks')]
    #[ORM\JoinColumn(name:'user_id',nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteBooks')]
    #[ORM\JoinColumn(name:'book_id')]
    #[Groups(['user:read'])]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();

    }
    

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
