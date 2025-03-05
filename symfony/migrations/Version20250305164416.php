<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305164416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (num_rpps VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, specialite VARCHAR(255) NOT NULL, PRIMARY KEY(num_rpps))');
        $this->addSql('CREATE TABLE patient (num_secu_sociale VARCHAR(255) NOT NULL, medecin_perso_num_rpps VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, antecedent VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(num_secu_sociale))');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBC3F2D8EF ON patient (medecin_perso_num_rpps)');
        $this->addSql('CREATE TABLE rendez_vous (id SERIAL NOT NULL, rpps_medecin VARCHAR(255) NOT NULL, patient_num_secu_sociale VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_65E8AA0A78519CAD ON rendez_vous (rpps_medecin)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A53B8516 ON rendez_vous (patient_num_secu_sociale)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBC3F2D8EF FOREIGN KEY (medecin_perso_num_rpps) REFERENCES medecin (num_rpps) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A78519CAD FOREIGN KEY (rpps_medecin) REFERENCES medecin (num_rpps) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A53B8516 FOREIGN KEY (patient_num_secu_sociale) REFERENCES patient (num_secu_sociale) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EBC3F2D8EF');
        $this->addSql('ALTER TABLE rendez_vous DROP CONSTRAINT FK_65E8AA0A78519CAD');
        $this->addSql('ALTER TABLE rendez_vous DROP CONSTRAINT FK_65E8AA0A53B8516');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rendez_vous');
    }
}
