<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240311101954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE press ADD position SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE site ADD press_review_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E46D7EFFE8 FOREIGN KEY (press_review_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_694309E46D7EFFE8 ON site (press_review_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE press DROP position');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E46D7EFFE8');
        $this->addSql('DROP INDEX IDX_694309E46D7EFFE8 ON site');
        $this->addSql('ALTER TABLE site DROP press_review_id');
    }
}
