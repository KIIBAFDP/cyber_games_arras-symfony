<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206095837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add pseudo field to user and ensure uniqueness, Create booking table';
    }

    public function up(Schema $schema): void
    {
        // Check if the table 'admin' already exists
        $schemaManager = $this->connection->createSchemaManager();
        if (!$schemaManager->tablesExist(['admin'])) {
            $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        // Check if the column 'pseudo' already exists
        $columns = $schemaManager->listTableColumns('user');
        if (!array_key_exists('pseudo', $columns)) {
            $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(180) NOT NULL');
        }

        // Ensure all existing pseudo values are unique
        $this->addSql("UPDATE user SET pseudo = CONCAT('user_', id) WHERE pseudo IS NULL OR pseudo = ''");

        // Add unique constraint
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');

        // Create booking table
        $this->addSql('CREATE TABLE booking (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT NOT NULL,
            computer_id INT NOT NULL,
            start_time DATETIME NOT NULL,
            end_time DATETIME NOT NULL,
            INDEX IDX_USER (user_id),
            INDEX IDX_COMPUTER (computer_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_62A8A7A7F7D7B8B FOREIGN KEY (computer_id) REFERENCES computer (id)');
    }

    public function down(Schema $schema): void
    {
        // Corrected down migration to avoid errors if 'booking' table doesn't exist
        $this->addSql('DROP TABLE IF EXISTS booking');
        $this->addSql('DROP TABLE IF EXISTS `admin`');
        $this->addSql('DROP INDEX IF EXISTS UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user DROP COLUMN pseudo');
    }
}
