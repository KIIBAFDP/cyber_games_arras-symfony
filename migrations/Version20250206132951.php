<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206132951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, computer_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDEA426D518 (computer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, processor VARCHAR(255) NOT NULL, memory VARCHAR(255) NOT NULL, os VARCHAR(255) NOT NULL, installed_games JSON NOT NULL, purchase_date DATETIME NOT NULL, last_maintenance_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, computer_id INT NOT NULL, maintenance_date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_2F84F8E9A426D518 (computer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA426D518 FOREIGN KEY (computer_id) REFERENCES computer (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9A426D518 FOREIGN KEY (computer_id) REFERENCES computer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA426D518');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9A426D518');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE computer');
        $this->addSql('DROP TABLE maintenance');
    }
}
