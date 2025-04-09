<?php

namespace App\Entity\Core;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Book;
use App\Entity\BookTransaction;
use App\Entity\FavoriteBook;
use App\Entity\Message;
use App\Repository\Core\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\Core\MeController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    operations: [
    new Get(),
    new GetCollection(),
    new Post(),
    new Put(),
    new Patch(),
    new Delete(),
    new Get(
        name: 'me',
        uriTemplate: "me",
        controller: MeController::class,
        read: false
    )
],)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'table_user', schema: 'schema_books')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $surname = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?string $password = null;  // Password should be hashed

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'last_login', type: 'datetime')]
    private ?\DateTime $lastLogin = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'owner')]
    private Collection $books;

    /**
     * @var Collection<int, FavoriteBook>
     */
    #[ORM\OneToMany(targetEntity: FavoriteBook::class, mappedBy: 'user')]
    #[Groups(['user:read'])]
    private Collection $favoriteBooks;

    /**
     * @var Collection<int, BookTransaction>
     */
    #[ORM\OneToMany(targetEntity: BookTransaction::class, mappedBy: 'buyer')]
    private Collection $bookTransactions;

    /**
     * @var Collection<int, BookTransaction>
     */
    #[ORM\OneToMany(targetEntity: BookTransaction::class, mappedBy: 'seller')]
    private Collection $bookTransactionsSeller;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'sender')]
    private Collection $messages;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'receiver')]
    private Collection $receivedMessages;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->favoriteBooks = new ArrayCollection();
        $this->bookTransactions = new ArrayCollection();
        $this->bookTransactionsSeller = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->lastLogin = new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
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

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTime $lastLogin): static
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    // Required methods from UserInterface
    public function getRoles(): array
    {
        return ['ROLE_USER']; // Default role
    }

    public function eraseCredentials()
    {
        // If needed, clear sensitive data
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setOwner($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getOwner() === $this) {
                $book->setOwner(null);
            }
        }

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
            $favoriteBook->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteBook(FavoriteBook $favoriteBook): static
    {
        if ($this->favoriteBooks->removeElement($favoriteBook)) {
            // set the owning side to null (unless already changed)
            if ($favoriteBook->getUser() === $this) {
                $favoriteBook->setUser(null);
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
            $bookTransaction->setBuyer($this);
        }

        return $this;
    }

    public function removeBookTransaction(BookTransaction $bookTransaction): static
    {
        if ($this->bookTransactions->removeElement($bookTransaction)) {
            // set the owning side to null (unless already changed)
            if ($bookTransaction->getBuyer() === $this) {
                $bookTransaction->setBuyer($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookTransaction>
     */
    public function getBookTransactionsSeller(): Collection
    {
        return $this->bookTransactionsSeller;
    }

    public function addBookTransactionsSeller(BookTransaction $bookTransactionsSeller): static
    {
        if (!$this->bookTransactionsSeller->contains($bookTransactionsSeller)) {
            $this->bookTransactionsSeller->add($bookTransactionsSeller);
            $bookTransactionsSeller->setSeller($this);
        }

        return $this;
    }

    public function removeBookTransactionsSeller(BookTransaction $bookTransactionsSeller): static
    {
        if ($this->bookTransactionsSeller->removeElement($bookTransactionsSeller)) {
            // set the owning side to null (unless already changed)
            if ($bookTransactionsSeller->getSeller() === $this) {
                $bookTransactionsSeller->setSeller(null);
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
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageReciveds(): Collection
    {
        return $this->receivedMessages;
    }

    public function addMessageRecived(Message $messageRecived): static
    {
        if (!$this->receivedMessages->contains($messageRecived)) {
            $this->receivedMessages->add($messageRecived);
            $messageRecived->setReceiver($this);
        }

        return $this;
    }

    public function removeMessageRecived(Message $messageRecived): static
    {
        if ($this->receivedMessages->removeElement($messageRecived)) {
            // set the owning side to null (unless already changed)
            if ($messageRecived->getReceiver() === $this) {
                $messageRecived->setReceiver($this);
            }
        }

        return $this;
    }
}
