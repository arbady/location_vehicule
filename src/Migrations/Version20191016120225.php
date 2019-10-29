<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191016120225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disponibilite ADD date_id INT DEFAULT NULL, DROP date_dispo');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FB897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('CREATE INDEX IDX_2CBACE2FB897366B ON disponibilite (date_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FB897366B');
        $this->addSql('DROP INDEX IDX_2CBACE2FB897366B ON disponibilite');
        $this->addSql('ALTER TABLE disponibilite ADD date_dispo DATE NOT NULL, DROP date_id');
    }
}
