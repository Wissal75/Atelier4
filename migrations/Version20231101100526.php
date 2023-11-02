<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101100526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331EAB5DEB');
        $this->addSql('DROP INDEX IDX_CBE5A331EAB5DEB ON book');
        $this->addSql('ALTER TABLE book CHANGE many_to_one_id authors_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3316DE2013A FOREIGN KEY (authors_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3316DE2013A ON book (authors_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3316DE2013A');
        $this->addSql('DROP INDEX IDX_CBE5A3316DE2013A ON book');
        $this->addSql('ALTER TABLE book CHANGE authors_id many_to_one_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331EAB5DEB FOREIGN KEY (many_to_one_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331EAB5DEB ON book (many_to_one_id)');
    }
}
