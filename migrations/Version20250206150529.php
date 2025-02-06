<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206150529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE computer_game (computer_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_3EE43D3EA426D518 (computer_id), INDEX IDX_3EE43D3EE48FD905 (game_id), PRIMARY KEY(computer_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE computer_game ADD CONSTRAINT FK_3EE43D3EA426D518 FOREIGN KEY (computer_id) REFERENCES computer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer_game ADD CONSTRAINT FK_3EE43D3EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer DROP installed_games');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer_game DROP FOREIGN KEY FK_3EE43D3EA426D518');
        $this->addSql('ALTER TABLE computer_game DROP FOREIGN KEY FK_3EE43D3EE48FD905');
        $this->addSql('DROP TABLE computer_game');
        $this->addSql('ALTER TABLE computer ADD installed_games JSON NOT NULL');
    }
}
