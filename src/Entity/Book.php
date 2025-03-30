<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Core\User;
use App\Entity\EntityListener\BookListener;
use App\Enum\StatusBook;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\EntityListeners([BookListener::class])]
#[ApiResource(
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']],
)]
#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'table_book', schema: 'schema_books')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $author = null;

    #[ORM\Column]
    #[Groups(['book:read', 'book:write'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['book:read', 'book:write'])]
    private ?int $category = null;

    #[ORM\Column(name: 'is_interchangeable')]
    #[Groups(['book:read', 'book:write'])]
    private ?bool $isInterchangeable = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'ubicated_in')]
    #[Groups(['book:read', 'book:write'])]
    private ?float $ubicatedIn = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $description = null;

    #[ORM\Column(type: "string", enumType: StatusBook::class, name: "status_book")]
    #[Groups(['book:read', 'book:write'])]
    private ?StatusBook $status = null;
    
    

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'books', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:read'])]
    private ?User $owner = null;

    #[Groups(['book:write'],)] // Add this to the serialization groups
    private ?int $ownerId = null;

    
    #[Groups(['book:read'])]
    private ?string $image = null;
    
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;

    }


    
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }
    public function setOwnerId(?int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @var Collection<int, FavoriteBook>
     */
    #[ORM\OneToMany(targetEntity: FavoriteBook::class, mappedBy: 'book')]
    private Collection $favoriteBooks;

    /**
     * @var Collection<int, BookTransaction>
     */
    #[ORM\OneToMany(targetEntity: BookTransaction::class, mappedBy: 'book')]
    private Collection $bookTransactions;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'fromBook')]
    private Collection $messages;

   
    public function __construct()
    {
        $this->favoriteBooks = new ArrayCollection();
        $this->bookTransactions = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->image = "testImage";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isInterchangeable(): ?bool
    {
        return $this->isInterchangeable;
    }

    public function setIsInterchangeable(bool $isInterchangeable): static
    {
        $this->isInterchangeable = $isInterchangeable;

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

    public function getUbicatedIn(): ?float
    {
        return $this->ubicatedIn;
    }

    public function setUbicatedIn(float $ubicatedIn): static
    {
        $this->ubicatedIn = $ubicatedIn;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getStatus(): ?StatusBook
    {
        return $this->status;
    }

    public function setStatus(StatusBook $status): static
    {
        $this->status = $status;

        return $this;
    }

   

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteBook>
     */
    public function getFavoriteBooks(): Collection
    {
        return $this->favoriteBooks;
    }

    public function addFavoriteBook(FavoriteBook $favoriteBook): static
    {
        if (!$this->favoriteBooks->contains($favoriteBook)) {
            $this->favoriteBooks->add($favoriteBook);
            $favoriteBook->setBook($this);
        }

        return $this;
    }

    public function removeFavoriteBook(FavoriteBook $favoriteBook): static
    {
        if ($this->favoriteBooks->removeElement($favoriteBook)) {
            // set the owning side to null (unless already changed)
            if ($favoriteBook->getBook() === $this) {
                $favoriteBook->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookTransaction>
     */
    public function getBookTransactions(): Collection
    {
        return $this->bookTransactions;
    }

    public function addBookTransaction(BookTransaction $bookTransaction): static
    {
        if (!$this->bookTransactions->contains($bookTransaction)) {
            $this->bookTransactions->add($bookTransaction);
            $bookTransaction->setBook($this);
        }

        return $this;
    }

    public function removeBookTransaction(BookTransaction $bookTransaction): static
    {
        if ($this->bookTransactions->removeElement($bookTransaction)) {
            // set the owning side to null (unless already changed)
            if ($bookTransaction->getBook() === $this) {
                $bookTransaction->setBook($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setFromBook($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getFromBook() === $this) {
                $message->setFromBook(null);
            }
        }

        return $this;
    }

   
}
