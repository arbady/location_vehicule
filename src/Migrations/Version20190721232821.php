<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721232821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie DROP reserve_de_vehicule_disponible');
        $this->addSql('ALTER TABLE penalisation DROP FOREIGN KEY FK_A190BDC61823061F');
        $this->addSql('DROP INDEX UNIQ_A190BDC61823061F ON penalisation');
        $this->addSql('ALTER TABLE penalisation DROP contrat_id');
        $this->addSql('ALTER TABLE permis DROP num_permis');
        $this->addSql('ALTER TABLE reservation DROP heure_debut_loc, DROP heure_fin_loc');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('ALTER TABLE categorie ADD reserve_de_vehicule_disponible INT NOT NULL');
        $this->addSql('ALTER TABLE penalisation ADD contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalisation ADD CONSTRAINT FK_A190BDC61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A190BDC61823061F ON penalisation (contrat_id)');
        $this->addSql('ALTER TABLE permis ADD num_permis INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD heure_debut_loc TIME NOT NULL, ADD heure_fin_loc TIME NOT NULL');
    }
}
