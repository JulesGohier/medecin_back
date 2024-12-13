<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213121033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_rpps BIGINT NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE patient (id SERIAL NOT NULL, medecin_perso_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, num_secu_sociale VARCHAR(255) NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, antecedent VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB4A3785CD ON patient (medecin_perso_id)');
        $this->addSql('CREATE TABLE rendez_vous (id SERIAL NOT NULL, id_medecin_id INT DEFAULT NULL, id_patient_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_65E8AA0AA1799A53 ON rendez_vous (id_medecin_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0ACE0312AE ON rendez_vous (id_patient_id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB4A3785CD FOREIGN KEY (medecin_perso_id) REFERENCES medecin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA1799A53 FOREIGN KEY (id_medecin_id) REFERENCES medecin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ACE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EB4A3785CD');
        $this->addSql('ALTER TABLE rendez_vous DROP CONSTRAINT FK_65E8AA0AA1799A53');
        $this->addSql('ALTER TABLE rendez_vous DROP CONSTRAINT FK_65E8AA0ACE0312AE');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rendez_vous');
    }
}
