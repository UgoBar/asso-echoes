<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301105533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_2D76CF8FEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_4C62E638EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, credit VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_472B783AEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logo_black (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, INDEX IDX_BE24A044EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logo_white (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, INDEX IDX_756ED7C8EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memorybox (id INT AUTO_INCREMENT NOT NULL, banner_id INT DEFAULT NULL, media_id INT DEFAULT NULL, subtitle VARCHAR(255) DEFAULT NULL, first_text LONGTEXT DEFAULT NULL, second_text LONGTEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_A22081B9684EC833 (banner_id), INDEX IDX_A22081B9EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, number INT NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_96901F54EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organize (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_D24AB957EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, type SMALLINT NOT NULL, position INT NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_312B3E16EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcast (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, position INT NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_D7E805BDEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE press (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, date VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_7DC47CBDEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE radiobox (id INT AUTO_INCREMENT NOT NULL, banner_id INT DEFAULT NULL, media_id INT DEFAULT NULL, subtitle VARCHAR(255) DEFAULT NULL, first_text LONGTEXT DEFAULT NULL, second_text LONGTEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_357C20D8684EC833 (banner_id), INDEX IDX_357C20D8EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_2784DCCEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, location VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_info (id INT AUTO_INCREMENT NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_member (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_6FFBDA1EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso ADD CONSTRAINT FK_2D76CF8FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE logo_black ADD CONSTRAINT FK_BE24A044EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE logo_white ADD CONSTRAINT FK_756ED7C8EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE memorybox ADD CONSTRAINT FK_A22081B9684EC833 FOREIGN KEY (banner_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE memorybox ADD CONSTRAINT FK_A22081B9EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE number ADD CONSTRAINT FK_96901F54EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE organize ADD CONSTRAINT FK_D24AB957EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE podcast ADD CONSTRAINT FK_D7E805BDEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE press ADD CONSTRAINT FK_7DC47CBDEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE radiobox ADD CONSTRAINT FK_357C20D8684EC833 FOREIGN KEY (banner_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE radiobox ADD CONSTRAINT FK_357C20D8EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA1EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asso DROP FOREIGN KEY FK_2D76CF8FEA9FDD75');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638EA9FDD75');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AEA9FDD75');
        $this->addSql('ALTER TABLE logo_black DROP FOREIGN KEY FK_BE24A044EA9FDD75');
        $this->addSql('ALTER TABLE logo_white DROP FOREIGN KEY FK_756ED7C8EA9FDD75');
        $this->addSql('ALTER TABLE memorybox DROP FOREIGN KEY FK_A22081B9684EC833');
        $this->addSql('ALTER TABLE memorybox DROP FOREIGN KEY FK_A22081B9EA9FDD75');
        $this->addSql('ALTER TABLE number DROP FOREIGN KEY FK_96901F54EA9FDD75');
        $this->addSql('ALTER TABLE organize DROP FOREIGN KEY FK_D24AB957EA9FDD75');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16EA9FDD75');
        $this->addSql('ALTER TABLE podcast DROP FOREIGN KEY FK_D7E805BDEA9FDD75');
        $this->addSql('ALTER TABLE press DROP FOREIGN KEY FK_7DC47CBDEA9FDD75');
        $this->addSql('ALTER TABLE radiobox DROP FOREIGN KEY FK_357C20D8684EC833');
        $this->addSql('ALTER TABLE radiobox DROP FOREIGN KEY FK_357C20D8EA9FDD75');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCEA9FDD75');
        $this->addSql('ALTER TABLE team_member DROP FOREIGN KEY FK_6FFBDA1EA9FDD75');
        $this->addSql('DROP TABLE asso');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE logo_black');
        $this->addSql('DROP TABLE logo_white');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE memorybox');
        $this->addSql('DROP TABLE number');
        $this->addSql('DROP TABLE organize');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('DROP TABLE press');
        $this->addSql('DROP TABLE radiobox');
        $this->addSql('DROP TABLE rent');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE team_info');
        $this->addSql('DROP TABLE team_member');
    }
}
