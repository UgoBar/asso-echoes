<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240311104139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE press ADD pdf_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE press ADD CONSTRAINT FK_7DC47CBD511FC912 FOREIGN KEY (pdf_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_7DC47CBD511FC912 ON press (pdf_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE press DROP FOREIGN KEY FK_7DC47CBD511FC912');
        $this->addSql('DROP INDEX IDX_7DC47CBD511FC912 ON press');
        $this->addSql('ALTER TABLE press DROP pdf_id');
    }
}
