<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Core\User;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource]
#[ORM\Table(name: 'table_message', schema: 'schema_books')]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;


    #[ORM\Column(name:'created_at')]
    private ?\DateTimeImmutable $createdAt = null;


    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false,name:"from_book_id")]
    private ?Book $fromBook = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(name:'sender_id',nullable: false)]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'receivedMessages')]
    #[ORM\JoinColumn(name:"receiver_id",nullable: false)]
    private ?User $receiver = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

   

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(User $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
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

    public function getFromBook(): ?Book
    {
        return $this->fromBook;
    }

    public function setFromBook(?Book $fromBook): static
    {
        $this->fromBook = $fromBook;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    
}
