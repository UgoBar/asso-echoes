<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423153101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_detail (id INT AUTO_INCREMENT NOT NULL, music_session_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, youtube_link VARCHAR(255) DEFAULT NULL, INDEX IDX_BBDEBC6AC03CB537 (music_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_detail_picture (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, music_detail_id INT NOT NULL, INDEX IDX_8B4E7309EA9FDD75 (media_id), INDEX IDX_8B4E7309A1A951A (music_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_session (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE music_detail ADD CONSTRAINT FK_BBDEBC6AC03CB537 FOREIGN KEY (music_session_id) REFERENCES music_session (id)');
        $this->addSql('ALTER TABLE music_detail_picture ADD CONSTRAINT FK_8B4E7309EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE music_detail_picture ADD CONSTRAINT FK_8B4E7309A1A951A FOREIGN KEY (music_detail_id) REFERENCES music_detail (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_detail DROP FOREIGN KEY FK_BBDEBC6AC03CB537');
        $this->addSql('ALTER TABLE music_detail_picture DROP FOREIGN KEY FK_8B4E7309EA9FDD75');
        $this->addSql('ALTER TABLE music_detail_picture DROP FOREIGN KEY FK_8B4E7309A1A951A');
        $this->addSql('DROP TABLE music_detail');
        $this->addSql('DROP TABLE music_detail_picture');
        $this->addSql('DROP TABLE music_session');
    }
}
