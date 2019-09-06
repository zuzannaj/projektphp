<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806163852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bus_routes (id INT AUTO_INCREMENT NOT NULL, bus_line_id INT NOT NULL, stop_id INT NOT NULL, stop_order INT NOT NULL, INDEX IDX_F8F9569CE660648F (bus_line_id), INDEX IDX_F8F9569C3902063D (stop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bus_routes ADD CONSTRAINT FK_F8F9569CE660648F FOREIGN KEY (bus_line_id) REFERENCES bus_lines (id)');
        $this->addSql('ALTER TABLE bus_routes ADD CONSTRAINT FK_F8F9569C3902063D FOREIGN KEY (stop_id) REFERENCES stops (id)');
        $this->addSql('DROP TABLE routes');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE routes (id INT AUTO_INCREMENT NOT NULL, bus_line_id INT NOT NULL, stop_id INT NOT NULL, stop_order INT NOT NULL, INDEX IDX_32D5C2B33902063D (stop_id), INDEX IDX_32D5C2B3E660648F (bus_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B33902063D FOREIGN KEY (stop_id) REFERENCES stops (id)');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B3E660648F FOREIGN KEY (bus_line_id) REFERENCES bus_lines (id)');
        $this->addSql('DROP TABLE bus_routes');
    }
}
