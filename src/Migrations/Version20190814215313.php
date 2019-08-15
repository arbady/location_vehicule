<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814215313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, adresse VARCHAR(255) NOT NULL, aeroport VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal INT NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type_cat VARCHAR(255) NOT NULL, cout_par_jour DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, date_inscription DATE NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, reservation_id INT NOT NULL, num_contrat INT NOT NULL, date_retour_reelle DATE NOT NULL, km_depart INT NOT NULL, km_retour INT NOT NULL, date_contrat DATE NOT NULL, montant_tot_htva DOUBLE PRECISION NOT NULL, montant_tot_tva DOUBLE PRECISION NOT NULL, signe TINYINT(1) NOT NULL, INDEX IDX_603499934A4A3511 (vehicule_id), UNIQUE INDEX UNIQ_60349993B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, agence_id INT NOT NULL, vehicule_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_2CBACE2FD725330D (agence_id), INDEX IDX_2CBACE2F4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, num_facture INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_facture DATE NOT NULL, montant_total_htva DOUBLE PRECISION NOT NULL, montant_total_tva DOUBLE PRECISION NOT NULL, paye TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_FE8664101823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode_de_paiement (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_AC92AFA97F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, marque_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_100285584827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE penalisation (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, description LONGTEXT NOT NULL, date_penal DATE NOT NULL, montant_a_payer DOUBLE PRECISION NOT NULL, montant_tot_htva DOUBLE PRECISION NOT NULL, montant_tot_tva DOUBLE PRECISION NOT NULL, INDEX IDX_A190BDC61823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permis (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_debut_permis DATE NOT NULL, date_fin_permis DATE NOT NULL, categorie_permis VARCHAR(2) NOT NULL, INDEX IDX_17389453A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, agence_id INT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, date_res DATE NOT NULL, date_debut_loc DATE NOT NULL, date_fin_loc DATE NOT NULL, montant_tot_tva DOUBLE PRECISION NOT NULL, acompte DOUBLE PRECISION NOT NULL, acompte_paye TINYINT(1) NOT NULL, statut_res TINYINT(1) NOT NULL, INDEX IDX_42C84955D725330D (agence_id), INDEX IDX_42C84955BCF5E72D (categorie_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, roles JSON NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, etat_id INT NOT NULL, modele_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, caracteristiques VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_292FFF1D12B2DC9C (matricule), INDEX IDX_292FFF1DBCF5E72D (categorie_id), INDEX IDX_292FFF1DD5E86FF (etat_id), INDEX IDX_292FFF1DAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499934A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE mode_de_paiement ADD CONSTRAINT FK_AC92AFA97F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE penalisation ADD CONSTRAINT FK_A190BDC61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE permis ADD CONSTRAINT FK_17389453A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FD725330D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D725330D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BCF5E72D');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DBCF5E72D');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101823061F');
        $this->addSql('ALTER TABLE penalisation DROP FOREIGN KEY FK_A190BDC61823061F');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DD5E86FF');
        $this->addSql('ALTER TABLE mode_de_paiement DROP FOREIGN KEY FK_AC92AFA97F2DEE08');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DAC14B70A');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993B83297E7');
        $this->addSql('ALTER TABLE permis DROP FOREIGN KEY FK_17389453A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499934A4A3511');
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2F4A4A3511');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE mode_de_paiement');
        $this->addSql('DROP TABLE modele');
        $this->addSql('DROP TABLE penalisation');
        $this->addSql('DROP TABLE permis');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicule');
    }
}
