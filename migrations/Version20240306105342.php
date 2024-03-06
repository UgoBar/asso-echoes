<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306105342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE gallery CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE memorybox CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE number CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE organize CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE podcast CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE press CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE radiobox CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rent CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE team_info CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE team_member CHANGE title title VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE memorybox CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE number CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organize CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE partner CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE press CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE radiobox CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rent CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE team_info CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE team_member CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
