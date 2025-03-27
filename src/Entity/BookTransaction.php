<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Core\User;
use App\Enum\StatusTransaction;
use App\Enum\TransactionType;
use App\Repository\BookTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookTransactionRepository::class)]
#[ApiResource]
#[ORM\Table(name: 'table_book_transaction', schema: 'schema_books')]
class BookTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(enumType: TransactionType::class,name:"transaction_type")]
    private ?TransactionType $transactionType = null;

    #[ORM\Column(enumType: StatusTransaction::class,name:"status_transaction")]
    private ?StatusTransaction $statusTransaction = null;

    #[ORM\Column(name:"created_at")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'bookTransactions')]
    #[ORM\JoinColumn]
    private ?User $buyer = null;

    #[ORM\ManyToOne(inversedBy: 'bookTransactionsSeller')]
    #[ORM\JoinColumn(name:'seller_id',nullable: false)]
    private ?User $seller = null;

    #[ORM\ManyToOne(inversedBy: 'bookTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(User $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }


    public function getTransactionType(): ?TransactionType
    {
        return $this->transactionType;
    }

    public function setTransactionType(TransactionType $transactionType): static
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    public function getStatusTransaction(): ?StatusTransaction
    {
        return $this->statusTransaction;
    }

    public function setStatusTransaction(StatusTransaction $statusTransaction): static
    {
        $this->statusTransaction = $statusTransaction;

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

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): static
    {
        $this->seller = $seller;

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
