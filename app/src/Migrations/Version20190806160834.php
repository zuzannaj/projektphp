<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806160834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079C00B5690');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079F2A67560');
        $this->addSql('DROP INDEX IDX_2C42079C00B5690 ON route');
        $this->addSql('DROP INDEX IDX_2C42079F2A67560 ON route');
        $this->addSql('ALTER TABLE route ADD bus_line_id INT NOT NULL, ADD stop_id INT NOT NULL, DROP bus_line_id_id, DROP stop_id_id');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079E660648F FOREIGN KEY (bus_line_id) REFERENCES bus_lines (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420793902063D FOREIGN KEY (stop_id) REFERENCES stops (id)');
        $this->addSql('CREATE INDEX IDX_2C42079E660648F ON route (bus_line_id)');
        $this->addSql('CREATE INDEX IDX_2C420793902063D ON route (stop_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079E660648F');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420793902063D');
        $this->addSql('DROP INDEX IDX_2C42079E660648F ON route');
        $this->addSql('DROP INDEX IDX_2C420793902063D ON route');
        $this->addSql('ALTER TABLE route ADD bus_line_id_id INT NOT NULL, ADD stop_id_id INT NOT NULL, DROP bus_line_id, DROP stop_id');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079C00B5690 FOREIGN KEY (bus_line_id_id) REFERENCES bus_lines (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079F2A67560 FOREIGN KEY (stop_id_id) REFERENCES stops (id)');
        $this->addSql('CREATE INDEX IDX_2C42079C00B5690 ON route (bus_line_id_id)');
        $this->addSql('CREATE INDEX IDX_2C42079F2A67560 ON route (stop_id_id)');
    }
}
