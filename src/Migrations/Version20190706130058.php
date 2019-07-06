<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706130058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parking (id INT AUTO_INCREMENT NOT NULL, nb_vehicule INT NOT NULL, vehicule_dispo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permis (id INT AUTO_INCREMENT NOT NULL, date_debut_permis DATE NOT NULL, date_fin_permis DATE NOT NULL, num_permis INT NOT NULL, categorie_permis VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE disponible');
        $this->addSql('ALTER TABLE penalisation ADD contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalisation ADD CONSTRAINT FK_A190BDC61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A190BDC61823061F ON penalisation (contrat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE disponible (id INT AUTO_INCREMENT NOT NULL, nb_vehicule INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE permis');
        $this->addSql('ALTER TABLE penalisation DROP FOREIGN KEY FK_A190BDC61823061F');
        $this->addSql('DROP INDEX UNIQ_A190BDC61823061F ON penalisation');
        $this->addSql('ALTER TABLE penalisation DROP contrat_id');
    }
}
