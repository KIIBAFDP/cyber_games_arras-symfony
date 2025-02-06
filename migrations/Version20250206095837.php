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
        return 'Add pseudo field to user and ensure uniqueness';
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user DROP pseudo');
    }
}
