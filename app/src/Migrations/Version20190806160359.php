<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806160359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, bus_line_id_id INT NOT NULL, stop_id_id INT NOT NULL, stop_order INT NOT NULL, INDEX IDX_2C42079C00B5690 (bus_line_id_id), INDEX IDX_2C42079F2A67560 (stop_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079C00B5690 FOREIGN KEY (bus_line_id_id) REFERENCES bus_lines (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079F2A67560 FOREIGN KEY (stop_id_id) REFERENCES stops (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE route');
    }
}
