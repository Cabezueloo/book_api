<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407084135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schema_books.table_book ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schema_books.table_book ADD CONSTRAINT FK_9DEC648B3DA5256D FOREIGN KEY (image_id) REFERENCES schema_books.media_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9DEC648B3DA5256D ON schema_books.table_book (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA schema_boo');
        $this->addSql('ALTER TABLE schema_books.table_book DROP CONSTRAINT FK_9DEC648B3DA5256D');
        $this->addSql('DROP INDEX IDX_9DEC648B3DA5256D');
        $this->addSql('ALTER TABLE schema_books.table_book DROP image_id');
    }
}
