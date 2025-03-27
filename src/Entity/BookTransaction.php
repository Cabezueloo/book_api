<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
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

    #[ORM\Column(name:'buyer_id')]
    private ?int $buyerId = null;

    #[ORM\Column(name:'seller_id')]
    private ?int $sellerId = null;

    #[ORM\Column(name:'book_id')]
    private ?int $bookId = null;

    #[ORM\Column(enumType: TransactionType::class,name:"transaction_type")]
    private ?TransactionType $transactionType = null;

    #[ORM\Column(enumType: StatusTransaction::class,name:"status_transaction")]
    private ?StatusTransaction $statusTransaction = null;

    #[ORM\Column(name:"created_at")]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyerId(): ?int
    {
        return $this->buyerId;
    }

    public function setBuyerId(int $buyerId): static
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    public function getSellerId(): ?int
    {
        return $this->sellerId;
    }

    public function setSellerId(int $sellerId): static
    {
        $this->sellerId = $sellerId;

        return $this;
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): static
    {
        $this->bookId = $bookId;

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
}
