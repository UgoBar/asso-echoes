<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308105431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE radiobox ADD mobile_banner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE radiobox ADD CONSTRAINT FK_357C20D8E450836C FOREIGN KEY (mobile_banner_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_357C20D8E450836C ON radiobox (mobile_banner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE radiobox DROP FOREIGN KEY FK_357C20D8E450836C');
        $this->addSql('DROP INDEX IDX_357C20D8E450836C ON radiobox');
        $this->addSql('ALTER TABLE radiobox DROP mobile_banner_id');
    }
}
