<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328124150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE schema_books.media_object_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE schema_books.table_book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schema_books.table_book_transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schema_books.table_favorite_book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schema_books.table_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schema_books.table_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE schema_books.table_book (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, category INT NOT NULL, is_interchangeable BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ubicated_in DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, status_book VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DEC648B7E3C61F9 ON schema_books.table_book (owner_id)');
        $this->addSql('COMMENT ON COLUMN schema_books.table_book.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE schema_books.table_book_transaction (id INT NOT NULL, buyer_id INT DEFAULT NULL, seller_id INT NOT NULL, book_id INT NOT NULL, transaction_type VARCHAR(255) NOT NULL, status_transaction VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBD6D1ED6C755722 ON schema_books.table_book_transaction (buyer_id)');
        $this->addSql('CREATE INDEX IDX_CBD6D1ED8DE820D9 ON schema_books.table_book_transaction (seller_id)');
        $this->addSql('CREATE INDEX IDX_CBD6D1ED16A2B381 ON schema_books.table_book_transaction (book_id)');
        $this->addSql('COMMENT ON COLUMN schema_books.table_book_transaction.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE schema_books.table_favorite_book (id INT NOT NULL, user_id INT NOT NULL, book_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C785101AA76ED395 ON schema_books.table_favorite_book (user_id)');
        $this->addSql('CREATE INDEX IDX_C785101A16A2B381 ON schema_books.table_favorite_book (book_id)');
        $this->addSql('COMMENT ON COLUMN schema_books.table_favorite_book.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE schema_books.table_message (id INT NOT NULL, from_book_id INT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, text VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8313B2C290FC502E ON schema_books.table_message (from_book_id)');
        $this->addSql('CREATE INDEX IDX_8313B2C2F624B39D ON schema_books.table_message (sender_id)');
        $this->addSql('CREATE INDEX IDX_8313B2C2CD53EDB6 ON schema_books.table_message (receiver_id)');
        $this->addSql('COMMENT ON COLUMN schema_books.table_message.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE schema_books.table_user (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB9A11F3F85E0677 ON schema_books.table_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB9A11F3E7927C74 ON schema_books.table_user (email)');
        $this->addSql('COMMENT ON COLUMN schema_books.table_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE schema_books.table_book ADD CONSTRAINT FK_9DEC648B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction ADD CONSTRAINT FK_CBD6D1ED6C755722 FOREIGN KEY (buyer_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction ADD CONSTRAINT FK_CBD6D1ED8DE820D9 FOREIGN KEY (seller_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction ADD CONSTRAINT FK_CBD6D1ED16A2B381 FOREIGN KEY (book_id) REFERENCES schema_books.table_book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_favorite_book ADD CONSTRAINT FK_C785101AA76ED395 FOREIGN KEY (user_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_favorite_book ADD CONSTRAINT FK_C785101A16A2B381 FOREIGN KEY (book_id) REFERENCES schema_books.table_book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_message ADD CONSTRAINT FK_8313B2C290FC502E FOREIGN KEY (from_book_id) REFERENCES schema_books.table_book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_message ADD CONSTRAINT FK_8313B2C2F624B39D FOREIGN KEY (sender_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schema_books.table_message ADD CONSTRAINT FK_8313B2C2CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES schema_books.table_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE schema_books.media_object');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA schema_boo');
        $this->addSql('DROP SEQUENCE schema_books.table_book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schema_books.table_book_transaction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schema_books.table_favorite_book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schema_books.table_message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schema_books.table_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE schema_books.media_object_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE schema_books.media_object (id INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE schema_books.table_book DROP CONSTRAINT FK_9DEC648B7E3C61F9');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction DROP CONSTRAINT FK_CBD6D1ED6C755722');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction DROP CONSTRAINT FK_CBD6D1ED8DE820D9');
        $this->addSql('ALTER TABLE schema_books.table_book_transaction DROP CONSTRAINT FK_CBD6D1ED16A2B381');
        $this->addSql('ALTER TABLE schema_books.table_favorite_book DROP CONSTRAINT FK_C785101AA76ED395');
        $this->addSql('ALTER TABLE schema_books.table_favorite_book DROP CONSTRAINT FK_C785101A16A2B381');
        $this->addSql('ALTER TABLE schema_books.table_message DROP CONSTRAINT FK_8313B2C290FC502E');
        $this->addSql('ALTER TABLE schema_books.table_message DROP CONSTRAINT FK_8313B2C2F624B39D');
        $this->addSql('ALTER TABLE schema_books.table_message DROP CONSTRAINT FK_8313B2C2CD53EDB6');
        $this->addSql('DROP TABLE schema_books.table_book');
        $this->addSql('DROP TABLE schema_books.table_book_transaction');
        $this->addSql('DROP TABLE schema_books.table_favorite_book');
        $this->addSql('DROP TABLE schema_books.table_message');
        $this->addSql('DROP TABLE schema_books.table_user');
    }
}
