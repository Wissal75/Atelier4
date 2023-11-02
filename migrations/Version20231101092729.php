<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101092729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (ref INT AUTO_INCREMENT NOT NULL, many_to_one_id INT NOT NULL, title VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, published TINYINT(1) NOT NULL, INDEX IDX_CBE5A331EAB5DEB (many_to_one_id), PRIMARY KEY(ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331EAB5DEB FOREIGN KEY (many_to_one_id) REFERENCES author (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331EAB5DEB');
        $this->addSql('DROP TABLE book');
    }
}
