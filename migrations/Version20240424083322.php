<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424083322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_detail ADD podcast_id INT DEFAULT NULL, ADD artist VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE music_detail ADD CONSTRAINT FK_BBDEBC6A786136AB FOREIGN KEY (podcast_id) REFERENCES podcast (id)');
        $this->addSql('CREATE INDEX IDX_BBDEBC6A786136AB ON music_detail (podcast_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_detail DROP FOREIGN KEY FK_BBDEBC6A786136AB');
        $this->addSql('DROP INDEX IDX_BBDEBC6A786136AB ON music_detail');
        $this->addSql('ALTER TABLE music_detail DROP podcast_id, DROP artist');
    }
}
