<?php

namespace App\Entity\EntityListener;

use App\Entity\Book;
use App\Entity\Core\User;
use Doctrine\ORM\EntityManagerInterface;

class BookListener
{

    public function __construct(private EntityManagerInterface  $em) {}
    // Example conversion function

    #POST
    public function prePersist(Book $book)
    {

        

        if ($book->getOwnerId() !== null) {

            
            $user = $this->em->getRepository(User::class)->find($book->getOwnerId());
            
            if (!$user) {
                throw new \InvalidArgumentException('User not found for ID: ' . $book->getOwnerId());
            }

            $book->setOwner($user);
            //Get the image book
            //$book->setImageBook($book->setImageBook(base64ToResource($book->getImageBook())));
        }
    }
}

function base64ToResource(string $base64Image)
{
    // Remove the data URI scheme if present (e.g., "data:image/jpeg;base64,")
    if (strpos($base64Image, ',') !== false) {
        $base64Image = explode(',', $base64Image)[1];
    }
    $binaryData = base64_decode($base64Image);
    $stream = fopen('php://memory', 'r+');
    fwrite($stream, $binaryData);
    rewind($stream);
    return $stream;
}
