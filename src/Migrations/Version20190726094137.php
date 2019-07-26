<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190726094137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie DROP reserve_de_vehicule_disponible');
        $this->addSql('ALTER TABLE client CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD reservation_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_60349993B83297E7 ON contrat (reservation_id)');
        $this->addSql('ALTER TABLE disponibilite ADD agence_id INT NOT NULL, ADD vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_2CBACE2FD725330D ON disponibilite (agence_id)');
        $this->addSql('CREATE INDEX IDX_2CBACE2F4A4A3511 ON disponibilite (vehicule_id)');
        $this->addSql('ALTER TABLE facture ADD contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE8664101823061F ON facture (contrat_id)');
        $this->addSql('ALTER TABLE mode_de_paiement ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE mode_de_paiement ADD CONSTRAINT FK_AC92AFA97F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_AC92AFA97F2DEE08 ON mode_de_paiement (facture_id)');
        $this->addSql('ALTER TABLE modele ADD vehicule_id INT NOT NULL, ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_100285584A4A3511 ON modele (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_100285584827B9B2 ON modele (marque_id)');
        $this->addSql('ALTER TABLE penalisation DROP INDEX UNIQ_A190BDC61823061F, ADD INDEX IDX_A190BDC61823061F (contrat_id)');
        $this->addSql('ALTER TABLE penalisation CHANGE contrat_id contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE permis CHANGE num_permis client_id INT NOT NULL');
        $this->addSql('ALTER TABLE permis ADD CONSTRAINT FK_1738945319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_1738945319EB6921 ON permis (client_id)');
        $this->addSql('ALTER TABLE reservation ADD agence_id INT NOT NULL, ADD categorie_id INT NOT NULL, ADD client_id INT NOT NULL, DROP heure_debut_loc, DROP heure_fin_loc');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_42C84955D725330D ON reservation (agence_id)');
        $this->addSql('CREATE INDEX IDX_42C84955BCF5E72D ON reservation (categorie_id)');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('ALTER TABLE vehicule ADD contrat_id INT NOT NULL, ADD categorie_id INT NOT NULL, ADD etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D1823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D1823061F ON vehicule (contrat_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1DBCF5E72D ON vehicule (categorie_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1DD5E86FF ON vehicule (etat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE categorie ADD reserve_de_vehicule_disponible INT NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE password password INT NOT NULL');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993B83297E7');
        $this->addSql('DROP INDEX IDX_60349993B83297E7 ON contrat');
        $this->addSql('ALTER TABLE contrat DROP reservation_id');
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FD725330D');
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2F4A4A3511');
        $this->addSql('DROP INDEX IDX_2CBACE2FD725330D ON disponibilite');
        $this->addSql('DROP INDEX IDX_2CBACE2F4A4A3511 ON disponibilite');
        $this->addSql('ALTER TABLE disponibilite DROP agence_id, DROP vehicule_id');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101823061F');
        $this->addSql('DROP INDEX UNIQ_FE8664101823061F ON facture');
        $this->addSql('ALTER TABLE facture DROP contrat_id');
        $this->addSql('ALTER TABLE mode_de_paiement DROP FOREIGN KEY FK_AC92AFA97F2DEE08');
        $this->addSql('DROP INDEX IDX_AC92AFA97F2DEE08 ON mode_de_paiement');
        $this->addSql('ALTER TABLE mode_de_paiement DROP facture_id');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584A4A3511');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('DROP INDEX IDX_100285584A4A3511 ON modele');
        $this->addSql('DROP INDEX IDX_100285584827B9B2 ON modele');
        $this->addSql('ALTER TABLE modele DROP vehicule_id, DROP marque_id');
        $this->addSql('ALTER TABLE penalisation DROP INDEX IDX_A190BDC61823061F, ADD UNIQUE INDEX UNIQ_A190BDC61823061F (contrat_id)');
        $this->addSql('ALTER TABLE penalisation CHANGE contrat_id contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE permis DROP FOREIGN KEY FK_1738945319EB6921');
        $this->addSql('DROP INDEX IDX_1738945319EB6921 ON permis');
        $this->addSql('ALTER TABLE permis CHANGE client_id num_permis INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D725330D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BCF5E72D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('DROP INDEX IDX_42C84955D725330D ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955BCF5E72D ON reservation');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD heure_debut_loc TIME NOT NULL, ADD heure_fin_loc TIME NOT NULL, DROP agence_id, DROP categorie_id, DROP client_id');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D1823061F');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DBCF5E72D');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DD5E86FF');
        $this->addSql('DROP INDEX IDX_292FFF1D1823061F ON vehicule');
        $this->addSql('DROP INDEX IDX_292FFF1DBCF5E72D ON vehicule');
        $this->addSql('DROP INDEX IDX_292FFF1DD5E86FF ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP contrat_id, DROP categorie_id, DROP etat_id');
    }
}
